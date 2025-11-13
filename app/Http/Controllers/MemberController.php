<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{




    // ===============================
    // PRODUK MANAGEMENT FOR MEMBERS
    // ===============================

    /**
     * Menampilkan produk milik member
     */
    public function indexProduk()
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko. Buat toko terlebih dahulu.');
        }

        $produks = $toko->produks()->with(['kategori', 'gambarProduks'])->paginate(10);

        return view('member.produks.index', compact('produks', 'toko'));
    }

    /**
     * Form untuk membuat produk baru
     */
    public function createProduk()
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko. Buat toko terlebih dahulu.');
        }

        $kategoris = Kategori::all();

        return view('member.produks.create', compact('toko', 'kategoris'));
    }

    /**
     * Simpan produk baru
     */
    public function storeProduk(Request $request)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko. Buat toko terlebih dahulu.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar_produk' => 'nullable|array|max:10',
            'gambar_produk.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except('gambar_produk');
        $data['id_toko'] = $toko->id_toko;
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

        return redirect()->route('member.produks.index')
            ->with('success', 'Produk berhasil dibuat dengan beberapa gambar.');
    }

    /**
     * Form edit produk
     */
    public function editProduk($id)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $produk = Produk::where('id_toko', $toko->id_toko)->findOrFail($id);
        $kategoris = Kategori::all();

        return view('member.produks.edit', compact('produk', 'toko', 'kategoris'));
    }

    /**
     * Update produk
     */
    public function updateProduk(Request $request, $id)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $produk = Produk::where('id_toko', $toko->id_toko)->findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
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

        return redirect()->route('member.produks.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroyProduk($id)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $produk = Produk::where('id_toko', $toko->id_toko)->findOrFail($id);

        // Hapus gambar produk terkait
        // Hapus semua gambar produk terkait
        foreach ($produk->gambarProduks as $gambarProduk) {
            Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);
            $gambarProduk->delete();
        }

        $produk->delete();

        return redirect()->route('member.produks.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function showProduks($id)
    {
        $produk = Produk::with(['kategori', 'toko', 'gambarProduks'])->findOrFail($id);
        return view('member.produks.show', compact('produk'));
    }

    // ===============================
    // TOKO MANAGEMENT FOR MEMBERS
    // ===============================

    /**
     * Menampilkan toko milik member yang sedang login
     */
    public function indexToko()
    {
        $user = Auth::user();
        $toko = $user->tokos()->first(); // Member hanya bisa punya satu toko

        return view('member.tokos.index', compact('toko'));
    }

    /**
     * Form untuk membuat toko baru
     */
    public function createToko()
    {
        $user = Auth::user();

        // Cek apakah user sudah punya toko
        if ($user->tokos()->exists()) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda sudah memiliki toko. Setiap member hanya boleh memiliki satu toko.');
        }

        return view('member.tokos.create');
    }

    /**
     * Simpan toko baru
     */
    public function storeToko(Request $request)
    {
        $user = Auth::user();

        // Validasi: pastikan user belum punya toko
        if ($user->tokos()->exists()) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda sudah memiliki toko. Setiap member hanya boleh memiliki satu toko.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        $data = $request->all();
        $data['id_user'] = $user->id_user;

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('tokos', $filename, 'public');
            $data['gambar'] = $filename;
        }

        Toko::create($data);

        return redirect()->route('member.tokos.index')
            ->with('success', 'Toko berhasil dibuat.');
    }

    /**
     * Form edit toko
     */
    public function editToko()
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        return view('member.tokos.edit', compact('toko'));
    }

    /**
     * Update toko
     */
    public function updateToko(Request $request)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        $data = $request->except('gambar');

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($toko->gambar && Storage::disk('public')->exists('tokos/' . $toko->gambar)) {
                Storage::disk('public')->delete('tokos/' . $toko->gambar);
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('tokos', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $toko->update($data);

        return redirect()->route('member.tokos.index')
            ->with('success', 'Toko berhasil diperbarui.');
    }

    /**
     * Hapus toko beserta produk terkait
     */
    public function destroyToko(Request $request)
    {
        $user = Auth::user();
        $toko = $user->tokos()->first();

        if (!$toko) {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Anda belum memiliki toko.');
        }

        // Konfirmasi penghapusan
        if ($request->input('confirm') !== 'HAPUS') {
            return redirect()->route('member.tokos.index')
                ->with('error', 'Konfirmasi penghapusan tidak valid.');
        }

        // Hapus gambar toko kalau ada
        if ($toko->gambar && Storage::disk('public')->exists('tokos/' . $toko->gambar)) {
            Storage::disk('public')->delete('tokos/' . $toko->gambar);
        }

        // Hapus semua produk dan gambar produk terkait
        foreach ($toko->produks as $produk) {
            // Hapus gambar produk
            foreach ($produk->gambarProduks as $gambarProduk) {
                Storage::disk('public')->delete($gambarProduk->nama_gambar);
                $gambarProduk->delete();
            }
            $produk->delete();
        }

        // Hapus toko
        $toko->delete();

        return redirect()->route('member.tokos.index')
            ->with('success', 'Toko dan semua produk terkait berhasil dihapus.');
    }

    // ===============================
    // PUBLIC TOKO PROFILE
    // ===============================

    /**
     * Tampilkan profil publik toko
     */
    public function showToko(Request $request, $id_toko)
    {
        $toko = Toko::with(['user', 'produks.kategori', 'produks.gambarProduks'])->findOrFail($id_toko);

        // Jika ada parameter produk, redirect ke halaman detail produk admin
        if ($request->has('produk')) {
            $produk_id = $request->produk;
            // Verifikasi bahwa produk tersebut milik toko ini
            $produk = $toko->produks()->find($produk_id);
            if ($produk) {
                return redirect()->route('admin.produks.show', $produk_id);
            }
        }

        return view('member.tokos.show', compact('toko'));
    }
}
