<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\GambarProduk;

class AdminController extends Controller
{
    // ===============================
    // DASHBOARD
    // ===============================
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTokos = Toko::count();
        $totalKategoris = Kategori::count();
        $totalProduks = Produk::count();
        $totalGambarProduks = GambarProduk::count();

        return view('admin.dashboard', compact('totalUsers', 'totalTokos', 'totalKategoris', 'totalProduks', 'totalGambarProduks'));
    }



}
