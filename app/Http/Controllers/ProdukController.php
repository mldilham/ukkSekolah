<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

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

        $produks = $query->paginate(5);
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
            'gambar_produk' => 'nullable|array|max:10',
            'gambar_produk.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except('gambar_produk');
        $data['tanggal_upload'] = now();

        $produk = Produk::create($data);

        // Simpan semua gambar
        if ($request->hasFile('gambar_produk')) {
            foreach ($request->file('gambar_produk') as $file) {
                $filename = uniqid() . '.' . $file->extension();
                if ($file->storeAs('produks', $filename, 'public')) {
                    GambarProduk::create([
                        'id_produk' => $produk->id_produk,
                        'nama_gambar' => $filename,
                    ]);
                }
            }
        }

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil dibuat dengan beberapa gambar.');
    }

    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $produk = Produk::findOrFail($decryptedId);
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.edit', compact('produk', 'kategoris', 'tokos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $produk = Produk::findOrFail($decryptedId);

        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:tokos,id_toko',
            'delete_gambar' => 'nullable|array',
            'delete_gambar.*' => 'integer|exists:gambar_produks,id_gambar',
            'gambar_produk' => 'nullable|array|max:10',
            'gambar_produk.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $produk->update($request->except(['gambar_produk', 'delete_gambar']));

        // Hapus gambar yang dipilih
        if ($request->has('delete_gambar') && is_array($request->delete_gambar)) {
            foreach ($request->delete_gambar as $id_gambar) {
                $gambar = GambarProduk::find($id_gambar);
                if ($gambar && $gambar->id_produk == $produk->id_produk) {
                    Storage::disk('public')->delete('produks/' . $gambar->nama_gambar);
                    $gambar->delete();
                }
            }
        }

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar_produk')) {
            foreach ($request->file('gambar_produk') as $file) {
                $filename = uniqid() . '.' . $file->extension();
                if ($file->storeAs('produks', $filename, 'public')) {
                    GambarProduk::create([
                        'id_produk' => $produk->id_produk,
                        'nama_gambar' => $filename,
                    ]);
                }
            }
        }

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }


    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $produk = Produk::findOrFail($decryptedId);

        // Hapus semua gambar produk terkait
        foreach ($produk->gambarProduks as $gambarProduk) {
            Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);
            $gambarProduk->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk dan gambar terkait berhasil dihapus.');
    }

    public function show($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $produk = Produk::with(['kategori', 'toko', 'gambarProduks'])->findOrFail($decryptedId);
        return view('admin.produks.show', compact('produk'));
    }

}
