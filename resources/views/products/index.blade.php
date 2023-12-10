@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Produk</h2>

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id_produk }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>{{ $product->harga }}</td>
                        <td>{{ $product->kategori->nama_kategori }}</td>
                        <td>{{ $product->status->nama_status }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.edit', $product->id_produk) }}" class="btn btn-warning" title="Edit" style="margin-right: 5px;">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id_produk) }}" method="post" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?')" style="margin-left: 5px;>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
