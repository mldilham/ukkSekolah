<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    // ===============================
    // TOKO MANAGEMENT
    // ===============================
    public function index()
    {
        $tokos = Toko::with('user')->paginate(10);
        return view('admin.tokos.index', compact('tokos'));
    }

    public function create()
    {
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'id_user' => 'required|exists:users,id_user',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        $data = $request->all();

        // Handle upload gambar
        // if ($request->hasFile('gambar')) {
        //     $file = $request->file('gambar');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('public/tokos', $filename);
        //     $data['gambar'] = $filename;
        // }

        Toko::create($data);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil dibuat.');
    }

    public function edit($id)
    {
        $toko = Toko::findOrFail($id);
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.edit', compact('toko', 'users'));
    }

    public function update(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'id_user' => 'required|exists:users,id_user',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        $data = $request->except('gambar');

        // Handle upload gambar baru
        // if ($request->hasFile('gambar')) {
        //     // Hapus gambar lama jika ada
        //     if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
        //         Storage::delete('public/tokos/' . $toko->gambar);
        //     }

        //     // Upload gambar baru
        //     $file = $request->file('gambar');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('public/tokos', $filename);
        //     $data['gambar'] = $filename;
        // }

        $toko->update($data);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);

        // Hapus gambar toko jika ada
        // if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
        //     Storage::delete('public/tokos/' . $toko->gambar);
        // }

        // // Hapus semua produk dan gambar produk terkait
        // foreach ($toko->produks as $produk) {
        //     foreach ($produk->gambarProduks as $gambarProduk) {
        //         Storage::disk('public')->delete($gambarProduk->nama_gambar);
        //         $gambarProduk->delete();
        //     }
        //     $produk->delete();
        // }

        $toko->delete();

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko dan semua produk terkait berhasil dihapus.');
    }
}
