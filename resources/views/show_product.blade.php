<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
</head>
<body>
    <h1>Daftar Produk</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
