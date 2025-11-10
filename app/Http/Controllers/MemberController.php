<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /** ---------------------------
     *  TOKO MANAGEMENT FOR MEMBERS
     *  --------------------------- */

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

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/tokos', $filename);
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

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
                Storage::delete('public/tokos/' . $toko->gambar);
            }

            // Upload gambar baru
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/tokos', $filename);
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

        // Hapus gambar toko jika ada
        if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
            Storage::delete('public/tokos/' . $toko->gambar);
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

    /**
     * Tampilkan profil publik toko
     */
    public function showToko($id_toko)
    {
        $toko = Toko::with(['user', 'produks.kategori', 'produks.gambarProduks'])->findOrFail($id_toko);

        return view('member.tokos.show', compact('toko'));
    }
}
