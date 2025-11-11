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
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'toko.user', 'gambarProduks']);

        // Filter berdasarkan pencarian nama produk
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter berdasarkan toko
        if ($request->has('toko') && !empty($request->toko)) {
            $query->where('id_toko', $request->toko);
        }

        $produks = $query->paginate(10)->appends($request->query());
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

        // Handle upload gambar jika ada
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $produk->id_produk . '.' . $file->getClientOriginalExtension();
            $file->storeAs('produks', $filename, 'public');

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

        // Handle upload gambar baru jika ada
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            foreach ($produk->gambarProduks as $gambarProduk) {
                Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);
                $gambarProduk->delete();
            }

            // Upload gambar baru
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $produk->id_produk . '.' . $file->getClientOriginalExtension();
            $file->storeAs('produks', $filename, 'public');

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
            Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);
            $gambarProduk->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk dan gambar terkait berhasil dihapus.');
    }
}
