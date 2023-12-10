<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk yang Bisa Dijual</title>
</head>
<body>
    <h1>Produk yang Bisa Dijual</h1>

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
</body>
</html>
