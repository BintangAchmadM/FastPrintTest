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

        $currentTime = time();
        $currentDate = date('d-m-y', $currentTime);

        $username = 'tesprogrammer101223C09';
        $password = 'bisacoding-' . date('d-m-y', $currentTime);

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
                    
                    $kategori = $item['kategori'];
                    $status = $item['status'];

                    $kategoriModel = \App\Models\Kategori::firstOrCreate(['nama_kategori' => $kategori]);
                    $kategoriId = $kategoriModel->id;

                    $statusModel = \App\Models\Status::firstOrCreate(['nama_status' => $status]);
                    $statusId = $statusModel->id;

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

    public function showallProducts()
    {
        $products = Product::with(['kategori', 'status'])->get();

        return view('show_all_product', compact('products'));
    }
    
    public function showSellableProducts()
    {
        $sellableProducts = Product::whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->get();

        return view('sellable_products', compact('sellableProducts'));
    }

    public function index()
    {
        $products = Product::whereHas('status', function ($query) {
            $query->where('nama_status', 'bisa dijual');
        })->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $statuses = Status::all();

        $categories = Kategori::all();

        return view('products.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $statuses = Status::all();

        $categories = Kategori::all();

        return view('products.edit', compact('product','categories','statuses'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}

