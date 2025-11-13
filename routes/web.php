<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GambarProdukController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// ===============================
// 🔐 AUTHENTICATION ROUTES
// ===============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// 📦 ROUTES UNTUK ADMIN
// ===============================
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ===============================
    // 👤 USER MANAGEMENT
    // ===============================
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Alias route untuk kompatibilitas
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // ===============================
    // 🏪 TOKO MANAGEMENT
    // ===============================
    Route::get('/tokos', [TokoController::class, 'index'])->name('tokos.index');
    Route::get('/tokos/create', [TokoController::class, 'create'])->name('tokos.create');
    Route::post('/tokos', [TokoController::class, 'store'])->name('tokos.store');
    Route::get('/tokos/{id}/edit', [TokoController::class, 'edit'])->name('tokos.edit');
    Route::put('/tokos/{id}', [TokoController::class, 'update'])->name('tokos.update');
    Route::delete('/tokos/{id}', [TokoController::class, 'destroy'])->name('tokos.destroy');

    // ===============================
    // 🏷️ KATEGORI MANAGEMENT
    // ===============================
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

    // ===============================
    // 📦 PRODUK MANAGEMENT
    // ===============================
    Route::resource('produks', ProdukController::class)->names([
        'index' => 'produks.index',
        'create' => 'produks.create',
        'store' => 'produks.store',
        'edit' => 'produks.edit',
        'update' => 'produks.update',
        'destroy' => 'produks.destroy',
        'show' => 'produks.show',
    ]);

    // ===============================
    // 🖼️ GAMBAR PRODUK MANAGEMENT
    // ===============================
    Route::get('/gambar-produks', [GambarProdukController::class, 'index'])->name('gambar_produks.index');
    Route::get('/gambar-produks/create', [GambarProdukController::class, 'create'])->name('gambar_produks.create');
    Route::post('/gambar-produks', [GambarProdukController::class, 'store'])->name('gambar_produks.store');
    Route::get('/gambar-produks/{id}/edit', [GambarProdukController::class, 'edit'])->name('gambar_produks.edit');
    Route::put('/gambar-produks/{id}', [GambarProdukController::class, 'update'])->name('gambar_produks.update');
    Route::delete('/gambar-produks/{id}', [GambarProdukController::class, 'destroy'])->name('gambar_produks.destroy');
});

// ===============================
// 👤 ROUTES UNTUK MEMBER
// ===============================
Route::prefix('member')->name('member.')->middleware('role:member')->group(function () {
    // Dashboard Member
    Route::get('/dashboard', function () {
        return view('member.dashboard');
    })->name('dashboard');

    // ===============================
    // 🏪 TOKO MANAGEMENT FOR MEMBERS
    // ===============================
    Route::get('/tokos', [MemberController::class, 'indexToko'])->name('tokos.index');
    Route::get('/tokos/create', [MemberController::class, 'createToko'])->name('tokos.create');
    Route::post('/tokos', [MemberController::class, 'storeToko'])->name('tokos.store');
    Route::get('/tokos/edit', [MemberController::class, 'editToko'])->name('tokos.edit');
    Route::put('/tokos', [MemberController::class, 'updateToko'])->name('tokos.update');
    Route::delete('/tokos', [MemberController::class, 'destroyToko'])->name('tokos.destroy');

    // ===============================
    // 📦 PRODUK MANAGEMENT FOR MEMBERS
    // ===============================
    Route::get('/produks', [MemberController::class, 'indexProduk'])->name('produks.index');
    Route::get('/produks/create', [MemberController::class, 'createProduk'])->name('produks.create');
    Route::post('/produks', [MemberController::class, 'storeProduk'])->name('produks.store');
    Route::get('/produks/{id}/edit', [MemberController::class, 'editProduk'])->name('produks.edit');
    Route::put('/produks/{id}', [MemberController::class, 'updateProduk'])->name('produks.update');
    Route::delete('/produks/{id}', [MemberController::class, 'destroyProduk'])->name('produks.destroy');
});

// ===============================
// 🏪 TOKO PUBLIC PROFILE (untuk semua user)
// ===============================
Route::get('/tokos', [PublicController::class, 'indexToko'])->name('public.tokos.index');
Route::get('/tokos/{id_toko}', [PublicController::class, 'showToko'])->name('tokos.show');
Route::get('/produks', [PublicController::class, 'indexProduk'])->name('public.produks.index');
Route::get('/produks/{id}', [PublicController::class, 'showProduk'])->name('produks.show');
