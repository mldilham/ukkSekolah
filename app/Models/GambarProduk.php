<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProduk extends Model
{
    use HasFactory;

    protected $table = 'gambar_produks';
    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'id_produk',
        'nama_gambar',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
