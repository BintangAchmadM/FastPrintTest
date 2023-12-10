<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'harga', 'kategori_id', 'status_id'];
    protected $primaryKey = 'id_produk';
    protected $keyType = 'string';

    protected $table = 'products';

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

}
