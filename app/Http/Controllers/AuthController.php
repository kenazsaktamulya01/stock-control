<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        // Jika pengguna sudah login, redirect ke halaman barang
        if (Auth::check()) {
            return redirect()->route('barang.index');
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Ambil credentials dari request
        $credentials = $request->only('email', 'password');

        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            // Redirect ke halaman barang jika login berhasil
            return redirect()->route('barang.index')->with('success', 'Login berhasil!');
        }

        // Kembali ke halaman login jika gagal
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}

