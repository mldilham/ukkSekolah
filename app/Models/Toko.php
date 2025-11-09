<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'tokos';
    protected $primaryKey = 'id_toko';

    protected $fillable = [
        'nama_toko',
        'deskripsi',
        'gambar',
        'id_user',
        'kontak_toko',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_toko', 'id_toko');
    }
}
