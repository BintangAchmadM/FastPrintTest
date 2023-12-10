@extends('layouts.app')

@section('title', 'Sellable Product')

@section('content')
    <div class="container mt-4">
        <h1>Produk yang Bisa Dijual</h1>

        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellableProducts as $product)
                    <tr>
                        <td>{{ $product->id_produk }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>{{ $product->harga }}</td>
                        <td>{{ $product->kategori->nama_kategori }}</td>
                        <td>{{ $product->status->nama_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
