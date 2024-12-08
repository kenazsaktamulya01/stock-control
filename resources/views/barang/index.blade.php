@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang</h1>
    @auth
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger mb-3">Logout</button>
        </form>
    @endauth
    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th> <!-- Menambahkan kolom deskripsi -->
                <th>Gambar</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang->name }}</td>
                <td>{{ $barang->price }}</td>
                <td>{{ $barang->stok }}</td>
                <td>{{ $barang->deskripsi }}</td> <!-- Menampilkan deskripsi -->
                <td>
                    @if ($barang->gambar)
                        <img src="{{ asset('images/' . $barang->gambar) }}" width="100" alt="Gambar Barang">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
