<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// ===============================
// 🔐 AUTHENTICATION ROUTES
// ===============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard umum
Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

// ===============================
// 📦 ROUTES UNTUK ADMIN
// ===============================
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ===============================
    // 👤 USER MANAGEMENT
    // ===============================
    Route::get('/users', [AdminController::class, 'indexUser'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Alias route untuk kompatibilitas
    Route::get('/users', [AdminController::class, 'indexUser'])->name('users');

    // ===============================
    // 🏪 TOKO MANAGEMENT
    // ===============================
    Route::get('/tokos', [AdminController::class, 'indexToko'])->name('tokos.index');
    Route::get('/tokos/create', [AdminController::class, 'createToko'])->name('tokos.create');
    Route::post('/tokos', [AdminController::class, 'storeToko'])->name('tokos.store');
    Route::get('/tokos/{id}/edit', [AdminController::class, 'editToko'])->name('tokos.edit');
    Route::put('/tokos/{id}', [AdminController::class, 'updateToko'])->name('tokos.update');
    Route::delete('/tokos/{id}', [AdminController::class, 'destroyToko'])->name('tokos.destroy');

    // ===============================
    // 🏷️ KATEGORI MANAGEMENT
    // ===============================
    Route::get('/kategoris', [AdminController::class, 'indexKategori'])->name('kategoris.index');
    Route::get('/kategoris/create', [AdminController::class, 'createKategori'])->name('kategoris.create');
    Route::post('/kategoris', [AdminController::class, 'storeKategori'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [AdminController::class, 'editKategori'])->name('kategoris.edit');
    Route::put('/kategoris/{id}', [AdminController::class, 'updateKategori'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [AdminController::class, 'destroyKategori'])->name('kategoris.destroy');

    // ===============================
    // 📦 PRODUK MANAGEMENT
    // ===============================
    Route::get('/produks', [AdminController::class, 'indexProduk'])->name('produks.index');
    Route::get('/produks/create', [AdminController::class, 'createProduk'])->name('produks.create');
    Route::post('/produks', [AdminController::class, 'storeProduk'])->name('produks.store');
    Route::get('/produks/{id}/edit', [AdminController::class, 'editProduk'])->name('produks.edit');
    Route::put('/produks/{id}', [AdminController::class, 'updateProduk'])->name('produks.update');
    Route::delete('/produks/{id}', [AdminController::class, 'destroyProduk'])->name('produks.destroy');

    // ===============================
    // 🖼️ GAMBAR PRODUK MANAGEMENT
    // ===============================
    Route::get('/gambar-produks', [AdminController::class, 'indexGambarProduk'])->name('gambar_produks.index');
    Route::get('/gambar-produks/create', [AdminController::class, 'createGambarProduk'])->name('gambar_produks.create');
    Route::post('/gambar-produks', [AdminController::class, 'storeGambarProduk'])->name('gambar_produks.store');
    Route::get('/gambar-produks/{id}/edit', [AdminController::class, 'editGambarProduk'])->name('gambar_produks.edit');
    Route::put('/gambar-produks/{id}', [AdminController::class, 'updateGambarProduk'])->name('gambar_produks.update');
    Route::delete('/gambar-produks/{id}', [AdminController::class, 'destroyGambarProduk'])->name('gambar_produks.destroy');
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
    Route::get('/tokos', [App\Http\Controllers\MemberController::class, 'indexToko'])->name('tokos.index');
    Route::get('/tokos/create', [App\Http\Controllers\MemberController::class, 'createToko'])->name('tokos.create');
    Route::post('/tokos', [App\Http\Controllers\MemberController::class, 'storeToko'])->name('tokos.store');
    Route::get('/tokos/edit', [App\Http\Controllers\MemberController::class, 'editToko'])->name('tokos.edit');
    Route::put('/tokos', [App\Http\Controllers\MemberController::class, 'updateToko'])->name('tokos.update');
    Route::delete('/tokos', [App\Http\Controllers\MemberController::class, 'destroyToko'])->name('tokos.destroy');

    // Profil publik toko (akses tanpa middleware member)
});

// ===============================
// 🏪 TOKO PUBLIC PROFILE (untuk semua user)
// ===============================
Route::get('/tokos/{id_toko}', [App\Http\Controllers\MemberController::class, 'showToko'])->name('tokos.show');
