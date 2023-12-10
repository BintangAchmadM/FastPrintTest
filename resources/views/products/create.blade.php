@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <h2 class="my-4">Tambah Produk</h2>

    <form action="{{ route('products.store') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="form-control" required>
            @error('nama_produk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" value="{{ old('harga') }}" class="form-control" required>
            @error('harga')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Tambah Produk</button>
    </form>
@endsection
