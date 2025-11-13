<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GambarProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class GambarProdukController extends Controller
{
    // ===============================
    // GAMBAR PRODUK MANAGEMENT
    // ===============================
    public function index()
    {
        $gambarProduks = GambarProduk::with(['produk.toko.user', 'produk.kategori'])->paginate(10);
        return view('admin.gambar_produks.index', compact('gambarProduks'));
    }

    public function create()
    {
        $produks = Produk::with(['toko.user', 'kategori'])->get();
        return view('admin.gambar_produks.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'nama_gambar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Upload gambar
        $file = $request->file('nama_gambar');
        $filename = time() . '_' . $request->id_produk . '.' . $file->getClientOriginalExtension();
        $file->storeAs('produks', $filename, 'public');

        GambarProduk::create([
            'id_produk' => $request->id_produk,
            'nama_gambar' => $filename,
        ]);

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gambarProduk = GambarProduk::findOrFail($id);
        $produks = Produk::with(['toko.user', 'kategori'])->get();
        return view('admin.gambar_produks.edit', compact('gambarProduk', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $gambarProduk = GambarProduk::findOrFail($id);

        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'nama_gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = ['id_produk' => $request->id_produk];

        // Handle upload gambar baru
        if ($request->hasFile('nama_gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);

            // Upload gambar baru
            $file = $request->file('nama_gambar');
            $filename = time() . '_' . $request->id_produk . '.' . $file->getClientOriginalExtension();
            $file->storeAs('produks', $filename, 'public');
            $data['nama_gambar'] = $filename;
        }

        $gambarProduk->update($data);

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gambarProduk = GambarProduk::findOrFail($id);

        // Hapus file gambar
        Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);

        $gambarProduk->delete();

        // Redirect ke URL yang diminta atau kembali
        $redirectTo = request('redirect_to');
        if ($redirectTo) {
            return redirect($redirectTo)
                ->with('success', 'Gambar produk berhasil dihapus.');
        }

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil dihapus.');
    }
}
