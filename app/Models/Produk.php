<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'tanggal_upload',
        'id_toko',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }

    public function gambarProduks()
    {
        return $this->hasMany(GambarProduk::class, 'id_produk', 'id_produk');
    }
}
