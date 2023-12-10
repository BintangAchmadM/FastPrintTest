
@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <h2 class="my-4">Tambah Produk</h2>
    
    <form action="{{ route('products.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="nama_produk">Nama Produk:</label>
        <input type="text" name="nama_produk" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="harga">Harga:</label>
        <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="kategori_id">Kategori:</label>
        <select name="kategori_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="status_id">Status:</label>
        <select name="status_id" class="form-control" required>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Tambah Produk</button>
</form>

@endsection


