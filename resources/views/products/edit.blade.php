@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <h2 class="my-4">Edit Produk</h2>

    <form action="{{ route('products.update', $product->id_produk) }}" method="post">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" name="nama_produk" value="{{ $product->nama_produk }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" value="{{ $product->harga }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori:</label>
            <select name="kategori_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->kategori_id == $category->id ? 'selected' : '' }}>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status_id">Status:</label>
            <select name="status_id" class="form-control" required>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $product->status_id == $status->id ? 'selected' : '' }}>
                        {{ $status->nama_status }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
@endsection
