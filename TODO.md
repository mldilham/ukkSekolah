# TODO: Update Produk dengan Gambar Multiple (Tanpa JavaScript)

## Langkah-langkah:

-   [x] Modifikasi `resources/views/admin/produks/edit.blade.php`: Tambahkan checkbox untuk setiap gambar yang ada dengan name="delete_gambar[]", hapus onsubmit JavaScript, ganti dengan checkbox untuk memilih gambar yang akan dihapus.
-   [x] Modifikasi `app/Http/Controllers/ProdukController.php` update(): Tambahkan validasi untuk delete_gambar (array of integers, exists in gambar_produks), logika untuk menghapus gambar yang dipilih (hapus file dari storage dan record dari DB), lalu tambah gambar baru jika ada.
-   [ ] Test update produk: Pilih gambar untuk dihapus via checkbox, tambah gambar baru, pastikan data tersimpan, file terhapus/ditambah, tidak ada error validasi atau storage.
-   [ ] Verifikasi tidak ada gambar yang dihapus jika tidak dipilih, dan fungsi lain tetap berjalan.
