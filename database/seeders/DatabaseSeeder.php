<?php

namespace Database\Seeders;

use App\Models\GambarProduk;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        $admin = User::create([
            'nama' => 'Admin MarSchool',
            'kontak' => '082119787632',
            'username' => 'Admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Member Users
        $member1 = User::create([
            'nama' => 'Member MarSchool',
            'kontak' => '081234567890',
            'username' => 'Member',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        $member2 = User::create([
            'nama' => 'Member 2',
            'kontak' => '081234567891',
            'username' => 'siti',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        $member3 = User::create([
            'nama' => 'Member 3 ',
            'kontak' => '081234567892',
            'username' => 'budi',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);

        // Create Categories
        $elektronik = Kategori::create([
            'nama_kategori' => 'Elektronik',
        ]);

        $fashion = Kategori::create([
            'nama_kategori' => 'Fashion',
        ]);

        $makanan = Kategori::create([
            'nama_kategori' => 'Makanan & Minuman',
        ]);

        $olahraga = Kategori::create([
            'nama_kategori' => 'Olahraga',
        ]);

        $kesehatan = Kategori::create([
            'nama_kategori' => 'Kesehatan & Kecantikan',
        ]);

        // Create Stores
        $toko1 = Toko::create([
            'nama_toko' => 'Toko Elektronik Ahmad',
            'deskripsi' => 'Menjual berbagai macam elektronik berkualitas dengan harga terjangkau',
            'gambar' => 'toko1.jpg',
            'id_user' => $member1->id_user,
            'kontak_toko' => '081234567890',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
        ]);

        $toko2 = Toko::create([
            'nama_toko' => 'Fashion Siti Collection',
            'deskripsi' => 'Koleksi fashion terbaru untuk pria dan wanita dengan model kekinian',
            'gambar' => 'toko2.jpg',
            'id_user' => $member2->id_user,
            'kontak_toko' => '081234567891',
            'alamat' => 'Jl. Malioboro No. 45, Yogyakarta',
        ]);

        $toko3 = Toko::create([
            'nama_toko' => 'Budi Sport Center',
            'deskripsi' => 'Pusat perlengkapan olahraga lengkap untuk semua kebutuhan Anda',
            'gambar' => 'toko3.jpg',
            'id_user' => $member3->id_user,
            'kontak_toko' => '081234567892',
            'alamat' => 'Jl. Veteran No. 67, Surabaya',
        ]);

        // Create Products
        $produk1 = Produk::create([
            'id_kategori' => $elektronik->id_kategori,
            'nama_produk' => 'Smartphone Samsung Galaxy A54',
            'harga' => 4500000,
            'stok' => 15,
            'deskripsi' => 'Smartphone Samsung Galaxy A54 dengan RAM 8GB, storage 128GB, kamera 50MP, dan baterai 5000mAh. Garansi resmi 1 tahun.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk2 = Produk::create([
            'id_kategori' => $elektronik->id_kategori,
            'nama_produk' => 'Laptop ASUS VivoBook 14',
            'harga' => 8500000,
            'stok' => 8,
            'deskripsi' => 'Laptop ASUS VivoBook 14 dengan processor Intel Core i5, RAM 8GB, SSD 512GB, layar 14 inch FHD.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk3 = Produk::create([
            'id_kategori' => $fashion->id_kategori,
            'nama_produk' => 'Dress Casual Wanita',
            'harga' => 150000,
            'stok' => 25,
            'deskripsi' => 'Dress casual wanita dengan bahan katun premium, motif floral, ukuran S/M/L/XL. Cocok untuk acara santai.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        $produk4 = Produk::create([
            'id_kategori' => $fashion->id_kategori,
            'nama_produk' => 'Sepatu Sneakers Pria',
            'harga' => 350000,
            'stok' => 12,
            'deskripsi' => 'Sepatu sneakers pria dengan desain modern, bahan sintetis berkualitas, sol karet anti slip. Ukuran 39-44.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        $produk5 = Produk::create([
            'id_kategori' => $makanan->id_kategori,
            'nama_produk' => 'Kopi Arabica Premium 500g',
            'harga' => 75000,
            'stok' => 30,
            'deskripsi' => 'Kopi arabica premium grade A, dipetik dari perkebunan di dataran tinggi. Aroma kuat, rasa balance.',
            'tanggal_upload' => now(),
            'id_toko' => $toko3->id_toko,
        ]);

        $produk6 = Produk::create([
            'id_kategori' => $olahraga->id_kategori,
            'nama_produk' => 'Dumbbell Set 20kg',
            'harga' => 250000,
            'stok' => 5,
            'deskripsi' => 'Set dumbbell 20kg terdiri dari 2 buah dumbbell 10kg masing-masing. Bahan besi cor berkualitas tinggi.',
            'tanggal_upload' => now(),
            'id_toko' => $toko3->id_toko,
        ]);

        $produk7 = Produk::create([
            'id_kategori' => $kesehatan->id_kategori,
            'nama_produk' => 'Vitamin C 1000mg',
            'harga' => 85000,
            'stok' => 50,
            'deskripsi' => 'Suplemen vitamin C 1000mg per kapsul, 60 kapsul per botol. Meningkatkan daya tahan tubuh.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk8 = Produk::create([
            'id_kategori' => $elektronik->id_kategori,
            'nama_produk' => 'Headphone Wireless Sony',
            'harga' => 450000,
            'stok' => 20,
            'deskripsi' => 'Headphone wireless Sony dengan noise cancelling, baterai 30 jam, foldable design.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk9 = Produk::create([
            'id_kategori' => $fashion->id_kategori,
            'nama_produk' => 'Kemeja Formal Pria',
            'harga' => 200000,
            'stok' => 18,
            'deskripsi' => 'Kemeja formal pria bahan katun, model slim fit, warna putih/navy. Ukuran M/L/XL.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        $produk10 = Produk::create([
            'id_kategori' => $olahraga->id_kategori,
            'nama_produk' => 'Bola Basket Spalding',
            'harga' => 180000,
            'stok' => 10,
            'deskripsi' => 'Bola basket Spalding ukuran 7, bahan komposit berkualitas tinggi, cocok untuk indoor/outdoor.',
            'tanggal_upload' => now(),
            'id_toko' => $toko3->id_toko,
        ]);

        // Create Product Images (sample data - in real app, images would be uploaded)
        GambarProduk::create([
            'id_produk' => $produk1->id_produk,
            'nama_gambar' => 'samsung-a54-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk1->id_produk,
            'nama_gambar' => 'samsung-a54-2.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk2->id_produk,
            'nama_gambar' => 'asus-vivobook-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk3->id_produk,
            'nama_gambar' => 'dress-casual-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk4->id_produk,
            'nama_gambar' => 'sneakers-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk5->id_produk,
            'nama_gambar' => 'kopi-arabica-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk6->id_produk,
            'nama_gambar' => 'dumbbell-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk7->id_produk,
            'nama_gambar' => 'vitamin-c-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk8->id_produk,
            'nama_gambar' => 'sony-headphone-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk9->id_produk,
            'nama_gambar' => 'kemeja-formal-1.jpg',
        ]);

        GambarProduk::create([
            'id_produk' => $produk10->id_produk,
            'nama_gambar' => 'bola-basket-1.jpg',
        ]);

    }
}
