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
            'nama' => 'Member 1',
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
        $minuman = Kategori::create([
            'nama_kategori' => 'Minuman',
        ]);

        $alatsekolah = Kategori::create([
            'nama_kategori' => 'Peralatan Sekolah',
        ]);

        $makanan = Kategori::create([
            'nama_kategori' => 'Makanan',
        ]);


        // Create Stores
        $toko1 = Toko::create([
            'nama_toko' => 'Toko Minuman Ahmad',
            'deskripsi' => 'Dengan pelayanan cepat dan ramah, serta pilihan menu yang beragam, toko kami menjadi tempat ideal untuk mencari minuman yang menyegarkan di segala suasana. Baik untuk melepas dahaga, menemani kerja, atau sekadar menikmati waktu santai, kami siap menyajikan minuman terbaik untuk Anda.',
            'gambar' => 'toko1.jpg',
            'id_user' => $member1->id_user,
            'kontak_toko' => '081234567890',
            'alamat' => 'Jl. Raya Garut',
        ]);

        $toko2 = Toko::create([
            'nama_toko' => 'Siti Collection',
            'deskripsi' => 'Dengan pelayanan ramah dan pilihan produk yang selalu up-to-date, toko kami hadir untuk membantu siswa, guru, dan orang tua mendapatkan kebutuhan belajar dengan mudah dan nyaman. Baik untuk persiapan masuk sekolah, perlengkapan harian, maupun kebutuhan tugas khusus, semuanya tersedia dalam satu tempat.',
            'gambar' => 'toko2.jpg',
            'id_user' => $member2->id_user,
            'kontak_toko' => '081234567891',
            'alamat' => 'Jl. Raya Garut',
        ]);

        $toko3 = Toko::create([
            'nama_toko' => 'Toko Makanan Budi',
            'deskripsi' => 'Dengan cita rasa yang otentik, pelayanan ramah, serta harga yang bersahabat, toko kami menjadi pilihan tepat untuk menikmati makanan enak setiap hari. Baik untuk makan di tempat, dibawa pulang, maupun dipesan secara online, kami selalu siap menyajikan hidangan terbaik untuk Anda.',
            'gambar' => 'toko3.jpg',
            'id_user' => $member3->id_user,
            'kontak_toko' => '081234567892',
            'alamat' => 'Jl. Raya Garut',
        ]);

        // Create Products
        $produk1 = Produk::create([
            'id_kategori' => $minuman->id_kategori,
            'nama_produk' => 'Es Jeruk Nipis',
            'harga' => 5000,
            'stok' => 100,
            'deskripsi' => 'Es jeruk nipis adalah minuman segar yang dibuat dari perasan jeruk nipis asli, dicampur dengan air dingin dan sedikit gula untuk menyeimbangkan rasa. Perpaduan rasa asam yang khas, manis yang ringan, serta sensasi dingin menjadikan es jeruk nipis pilihan sempurna untuk melepas dahaga. Minuman ini tidak hanya menyegarkan, tetapi juga kaya vitamin C dan dipercaya membantu meningkatkan daya tahan tubuh. Cocok dinikmati saat cuaca panas atau sebagai pendamping makanan apa pun.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk2 = Produk::create([
            'id_kategori' => $minuman->id_kategori,
            'nama_produk' => 'Es Kopi',
            'harga' => 6500,
            'stok' => 8,
            'deskripsi' => 'Es kopi adalah minuman dingin yang dibuat dari campuran kopi hitam berkualitas yang disajikan dengan es batu untuk memberikan sensasi segar. Aromanya yang khas, rasa pahit yang lembut, serta sentuhan manis sesuai selera menjadikan es kopi pilihan favorit untuk menemani aktivitas sehari-hari. Minuman ini memberikan energi sekaligus kesegaran, cocok dinikmati saat cuaca panas atau saat membutuhkan penyegar pikiran.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk3 = Produk::create([
            'id_kategori' => $alatsekolah->id_kategori,
            'nama_produk' => 'Buku',
            'harga' => 3000,
            'stok' => 100,
            'deskripsi' => 'Buku ini hadir dengan kondisi bersih, rapi, dan terawat, cocok untuk Anda yang ingin menambah wawasan atau sekadar mencari bacaan berkualitas. Dengan isi materi yang lengkap dan mudah dipahami, buku ini sangat direkomendasikan untuk pelajar, mahasiswa, maupun pembaca umum. Dibuat dengan kualitas cetak yang baik, halaman yang utuh, serta sampul menarik, buku ini memberikan pengalaman membaca yang nyaman. Cocok sebagai koleksi pribadi atau hadiah untuk teman dan keluarga.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        $produk4 = Produk::create([
            'id_kategori' => $alatsekolah->id_kategori,
            'nama_produk' => 'Puplen HiTech',
            'harga' => 7000,
            'stok' => 100,
            'deskripsi' => 'Pulpen Hi-Tech adalah pulpen gel dengan ujung tinta super halus yang dirancang untuk menghasilkan tulisan yang rapi, presisi, dan nyaman digunakan dalam waktu lama. Dengan ujung 0.3–0.5 mm, pulpen ini mampu menulis dengan detail tinggi tanpa bleber atau macet. Tinta gelnya cepat kering, tidak mudah luntur, dan konsisten dari awal hingga akhir pemakaian. Cocok untuk pelajar, mahasiswa, pekerja kantor, hingga kebutuhan menggambar teknik atau membuat catatan yang rapi.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        $produk5 = Produk::create([
            'id_kategori' => $makanan->id_kategori,
            'nama_produk' => 'Citul',
            'harga' => 2500,
            'stok' => 100,
            'deskripsi' => 'Aci Tulang adalah camilan khas berbahan dasar adonan aci yang dibentuk menyerupai tulang dan digoreng hingga renyah di luar namun tetap kenyal di dalam. Dipadukan dengan bumbu pedas, gurih, atau asin, aci tulang menawarkan cita rasa yang nagih dan cocok dinikmati kapan saja. Teksturnya yang unik—crispy saat digigit dan kenyal di dalam—membuat aci tulang jadi favorit banyak orang, terutama pecinta makanan pedas. Cocok untuk teman nonton, nongkrong, atau camilan sehari-hari.',
            'tanggal_upload' => now(),
            'id_toko' => $toko3->id_toko,
        ]);

        $produk8 = Produk::create([
            'id_kategori' => $minuman->id_kategori,
            'nama_produk' => 'Es kelapa',
            'harga' => 10000,
            'stok' => 100,
            'deskripsi' => 'Es kelapa adalah minuman segar yang dibuat dari air kelapa muda asli dengan tambahan daging kelapa yang lembut. Disajikan dengan es batu, minuman ini memberikan rasa manis alami dan kesegaran yang menenangkan. Kaya akan elektrolit dan mineral, es kelapa sangat cocok untuk menghilangkan dahaga, terutama saat cuaca panas. Rasanya yang alami dan menyehatkan membuatnya menjadi pilihan favorit banyak orang.',
            'tanggal_upload' => now(),
            'id_toko' => $toko1->id_toko,
        ]);

        $produk9 = Produk::create([
            'id_kategori' => $alatsekolah->id_kategori,
            'nama_produk' => 'Pensil',
            'harga' => 4000,
            'stok' => 100,
            'deskripsi' => 'Pensil ini dirancang dengan kualitas unggul untuk menghasilkan tulisan yang jelas, halus, dan nyaman digunakan. Terbuat dari bahan kayu yang kuat serta isi grafit yang tidak mudah patah, pensil ini cocok untuk keperluan menulis, menggambar, maupun membuat sketsa. Dilengkapi dengan bentuk ergonomis yang mudah digenggam, pensil ini ideal digunakan oleh pelajar, mahasiswa, hingga profesional. Tersedia dalam tingkat kekerasan yang stabil sehingga hasil coretan tetap konsisten.',
            'tanggal_upload' => now(),
            'id_toko' => $toko2->id_toko,
        ]);

        // Create Product Images (sample data - in real app, images would be uploaded)
        // GambarProduk::create([
        //     'id_produk' => $produk1->id_produk,
        //     'nama_gambar' => 'samsung-a54-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk1->id_produk,
        //     'nama_gambar' => 'samsung-a54-2.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk2->id_produk,
        //     'nama_gambar' => 'asus-vivobook-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk3->id_produk,
        //     'nama_gambar' => 'dress-casual-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk4->id_produk,
        //     'nama_gambar' => 'sneakers-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk5->id_produk,
        //     'nama_gambar' => 'kopi-arabica-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk6->id_produk,
        //     'nama_gambar' => 'dumbbell-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk7->id_produk,
        //     'nama_gambar' => 'vitamin-c-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk8->id_produk,
        //     'nama_gambar' => 'sony-headphone-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk9->id_produk,
        //     'nama_gambar' => 'kemeja-formal-1.jpg',
        // ]);

        // GambarProduk::create([
        //     'id_produk' => $produk10->id_produk,
        //     'nama_gambar' => 'bola-basket-1.jpg',
        // ]);

    }
}
