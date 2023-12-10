<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Kategori;
use App\Models\Status;

class productController extends Controller
{
    public function fetchDataFromApi()
    {
        $client = new Client();

        // Mendapatkan waktu server
        $currentTime = time();
        $currentDate = date('d-m-y', $currentTime);

        // Mendapatkan username dan password sesuai format
        $username = 'tesprogrammer101223C09';
        $password = 'bisacoding-' . date('d-m-y', $currentTime);

        // Menghasilkan hash MD5 dari password
        $passwordMd5 = md5($password);

        try {
            $response = $client->post('https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
                'form_params' => [
                    'username' => $username,
                    'password' => $passwordMd5,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $this->saveDataToLocalDatabase($data);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function saveDataToLocalDatabase(array $data)
    {
        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $item) {
                if (is_array($item) && isset($item['id_produk'], $item['nama_produk'], $item['harga'], $item['kategori'], $item['status'])) {
                    // Dapatkan ID kategori dan status dari nama mereka
                    $kategori = $item['kategori'];
                    $status = $item['status'];
    
                    // Cari atau buat record kategori
                    $kategoriModel = \App\Models\Kategori::firstOrCreate(['nama_kategori' => $kategori]);
                    $kategoriId = $kategoriModel->id;
    
                    // Cari atau buat record status
                    $statusModel = \App\Models\Status::firstOrCreate(['nama_status' => $status]);
                    $statusId = $statusModel->id;
    
                    // Simpan data ke dalam database
                    Product::updateOrCreate(
                        ['id_produk' => $item['id_produk']],
                        [
                            'nama_produk' => $item['nama_produk'],
                            'harga' => $item['harga'],
                            'kategori_id' => $kategoriId,
                            'status_id' => $statusId,
                        ]
                    );
                }
            }
        }
    }

    public function showProducts()
    {
        $products = Product::with(['kategori', 'status'])->get();

        return view('show_product', compact('products'));
    }
    
    public function showSellableProducts()
    {
        // Menggunakan whereHas untuk menyaring berdasarkan relasi status
        $sellableProducts = Product::whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->get();

        // Alternatif menggunakan where pada relasi langsung
        // $sellableProducts = Product::where('status.nama_status', 'bisa dijual')->get();

        return view('sellable_products', compact('sellableProducts'));
    }

    public function index()
    {
        // Menyaring produk yang memiliki status "bisa dijual"
        $products = Product::whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Mendapatkan semua status
        $statuses = Status::all();

        // Mendapatkan semua kategori (seperti yang telah dijelaskan sebelumnya)
        $categories = Kategori::all();

        // Tampilkan formulir tambah dengan kategori dan status yang tersedia
        return view('products.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Simpan data baru ke dalam database
        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data produk yang akan diedit
        $product = Product::findOrFail($id);

        // Mendapatkan semua status
        $statuses = Status::all();

        // Mendapatkan semua kategori (seperti yang telah dijelaskan sebelumnya)
        $categories = Kategori::all();

        // Tampilkan formulir edit
        return view('products.edit', compact('product','categories','statuses'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input jika diperlukan
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Update data produk
        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        // Hapus data produk
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}

