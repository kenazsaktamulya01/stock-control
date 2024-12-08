<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // Menampilkan daftar barang
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    // Form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Proses gambar
        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images'), $imageName);
        }
    
        try {
            Barang::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'stok' => $validated['stok'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar' => $imageName,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Menampilkan pesan error jika ada masalah
        }
        
        Barang::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stok' => $validated['stok'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $imageName,
        ]);
    
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }
    



    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    // Memperbarui data barang
    public function update(Request $request, $id)
{
    $barang = Barang::findOrFail($id);

    // Validasi input termasuk deskripsi
    $request->validate([
        'nama' => 'required',
        'deskripsi' => 'nullable|string|max:1000', // Validasi deskripsi
        'stok' => 'required|integer',
        'harga' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Proses gambar
    $path = $barang->gambar; // Menyimpan path gambar lama
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($path) {
            Storage::disk('public')->delete($path);
        }
        // Simpan gambar baru
        $path = $request->file('gambar')->store('images', 'public');
    }

    // Update data barang
    $barang->update([
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi, // Menyimpan deskripsi
        'stok' => $request->stok,
        'harga' => $request->harga,
        'gambar' => $path,
    ]);

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}


    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
