<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Kategori;

class PublicController extends Controller
{
    public function indexProduk(Request $request)
    {
        $query = Produk::with(['kategori', 'toko.user', 'gambarProduks']);

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('public.produks.index', compact('produks', 'kategoris'));
    }

    public function showProduk($id)
    {
        $produk = Produk::with(['kategori', 'toko.user', 'gambarProduks'])->findOrFail($id);

        return view('public.produks.show', compact('produk'));
    }

    public function indexToko()
    {
        $tokos = Toko::with(['user', 'produks'])->paginate(12);

        return view('public.tokos.index', compact('tokos'));
    }

    public function showToko($id_toko)
    {
        $toko = Toko::with(['user', 'produks.kategori', 'produks.gambarProduks'])->findOrFail($id_toko);

        return view('public.tokos.show', compact('toko'));
    }
}
