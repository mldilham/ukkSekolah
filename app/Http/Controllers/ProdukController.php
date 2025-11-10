<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // ===============================
    // PRODUK MANAGEMENT
    // ===============================
    public function index()
    {
        $produks = Produk::with(['kategori', 'toko.user', 'gambarProduks'])->paginate(10);
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.index', compact('produks', 'kategoris', 'tokos'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.create', compact('kategoris', 'tokos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:tokos,id_toko',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->all();
        $data['tanggal_upload'] = now();

        $produk = Produk::create($data);

        // Handle upload gambar produk
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $produk->id_produk . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produks'), $filename);

            GambarProduk::create([
                'id_produk' => $produk->id_produk,
                'nama_gambar' => $filename,
            ]);
        }

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.edit', compact('produk', 'kategoris', 'tokos'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:tokos,id_toko',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $produk->update($request->all());

        // Handle upload gambar produk baru
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->gambarProduks->count() > 0) {
                foreach ($produk->gambarProduks as $gambarProduk) {
                    unlink(public_path('produks/' . $gambarProduk->nama_gambar));
                    $gambarProduk->delete();
                }
            }

            // Upload gambar baru
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $produk->id_produk . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produks'), $filename);

            GambarProduk::create([
                'id_produk' => $produk->id_produk,
                'nama_gambar' => $filename,
            ]);
        }

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus semua gambar produk terkait
        foreach ($produk->gambarProduks as $gambarProduk) {
            unlink(public_path('produks/' . $gambarProduk->nama_gambar));
            $gambarProduk->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk dan gambar terkait berhasil dihapus.');
    }
}
