<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Testimoni;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data untuk halaman home
        $tokos = Toko::with(['user', 'produks'])->get(); // Semua toko untuk pagination di view
        $produks = Produk::with(['kategori', 'toko.user', 'gambarProduks'])->get(); // Semua produk untuk pagination di view
        $kategoris = Kategori::all();
        $testimonis = Testimoni::where('is_active', true)->get(); // Testimoni aktif

        return view('home', compact('tokos', 'produks', 'kategoris', 'testimonis'));
    }
}
