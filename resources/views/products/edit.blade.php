@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <h2 class="my-4">Edit Produk</h2>

    <form action="{{ route('products.update', $product->id_produk) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="form-control" required>
            @error('nama_produk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="form-control" required>
            @error('harga')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
@endsection
