@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Barang</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="form-group">
            <label for="name">Nama Barang</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <br>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <br>
        <div class="form-group">
            <label for="stok">Jumlah Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <br>
        <div class="form-group">
            <label for="gambar">Gambar Barang</label>
            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
        </div>
        <br>
        
        <div class="form-group">
            <label for="deskripsi">Deskripsi Gambar</label>
            <br>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Tambahkan deskripsi untuk gambar barang"></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary ml-2">Kembali ke Daftar Barang</a>
    </form>
</div>
@endsection
