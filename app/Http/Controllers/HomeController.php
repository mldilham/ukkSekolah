<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data untuk halaman home
        $tokos = Toko::with(['user', 'produks'])->take(6)->get(); // 6 toko terbaru
        $produks = Produk::with(['kategori', 'toko.user', 'gambarProduks'])->take(8)->get(); // 8 produk terbaru
        $kategoris = Kategori::all();

        return view('home', compact('tokos', 'produks', 'kategoris'));
    }
}
