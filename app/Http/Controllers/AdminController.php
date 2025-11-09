<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\GambarProduk;

class AdminController extends Controller
{
    /** ---------------------------
     *  DASHBOARD
     *  --------------------------- */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTokos = Toko::count();
        $totalKategoris = Kategori::count();
        $totalProduks = Produk::count();

        return view('admin.dashboard', compact('totalUsers', 'totalTokos', 'totalKategoris', 'totalProduks'));
    }

    /** ---------------------------
     *  USER MANAGEMENT
     *  --------------------------- */
    public function indexUser()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:13',
            'username' => 'required|string|max:20|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,member',
        ]);

        User::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser($id_user)
    {
        $user = User::findOrFail($id_user);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:13',
            'username' => 'required|string|max:20|unique:users,username,' . $id_user . ',id_user',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,member',
        ]);

        $user->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser($id_user)
    {
        User::findOrFail($id_user)->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    /** ---------------------------
     *  TOKO MANAGEMENT
     *  --------------------------- */
    public function indexToko()
    {
        $tokos = Toko::with('user')->get();
        return view('admin.tokos.index', compact('tokos'));
    }

    public function createToko()
    {
        $users = User::all();
        return view('admin.tokos.create', compact('users'));
    }

    public function storeToko(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string|max:100',
            'id_user' => 'required|exists:users,id_user',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        Toko::create($request->all());

        return redirect()->route('admin.tokos.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function editToko($id_toko)
    {
        $toko = Toko::findOrFail($id_toko);
        $users = User::all();
        return view('admin.tokos.edit', compact('toko', 'users'));
    }

    public function updateToko(Request $request, $id_toko)
    {
        $toko = Toko::findOrFail($id_toko);

        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string|max:100',
            'id_user' => 'required|exists:users,id_user',
            'kontak_toko' => 'required|string|max:13',
            'alamat' => 'required|string',
        ]);

        $toko->update($request->all());

        return redirect()->route('admin.tokos.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroyToko($id_toko)
    {
        Toko::findOrFail($id_toko)->delete();
        return redirect()->route('admin.tokos.index')->with('success', 'Toko berhasil dihapus.');
    }

    /** ---------------------------
     *  KATEGORI MANAGEMENT
     *  --------------------------- */
    public function indexKategori()
    {
        $kategoris = Kategori::all();
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function createKategori()
    {
        return view('admin.kategoris.create');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategoris')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editKategori($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function updateKategori(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);

        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        $kategori->update($request->all());

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id_kategori)
    {
        Kategori::findOrFail($id_kategori)->delete();
        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }

    /** ---------------------------
     *  PRODUK MANAGEMENT
     *  --------------------------- */
    public function indexProduk()
    {
        $produks = Produk::with('kategori', 'toko')->get();
        return view('admin.produks.index', compact('produks'));
    }

    public function createProduk()
    {
        $kategoris = Kategori::all();
        $tokos = Toko::all();
        return view('admin.produks.create', compact('kategoris', 'tokos'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'tanggal_upload' => 'required|date',
            'id_toko' => 'required|exists:tokos,id_toko',
        ]);

        Produk::create($request->all());

        return redirect()->route('admin.produks')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduk($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        $kategoris = Kategori::all();
        $tokos = Toko::all();
        return view('admin.produks.edit', compact('produk', 'kategoris', 'tokos'));
    }

    public function updateProduk(Request $request, $id_produk)
    {
        $produk = Produk::findOrFail($id_produk);

        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'tanggal_upload' => 'required|date',
            'id_toko' => 'required|exists:tokos,id_toko',
        ]);

        $produk->update($request->all());

        return redirect()->route('admin.produks')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduk($id_produk)
    {
        Produk::findOrFail($id_produk)->delete();
        return redirect()->route('admin.produks')->with('success', 'Produk berhasil dihapus.');
    }

    /** ---------------------------
     *  GAMBAR PRODUK MANAGEMENT
     *  --------------------------- */
    public function indexGambarProduk()
    {
        $gambarProduks = GambarProduk::with('produk')->get();
        return view('admin.gambar_produks.index', compact('gambarProduks'));
    }

    public function createGambarProduk()
    {
        $produks = Produk::all();
        return view('admin.gambar_produks.create', compact('produks'));
    }

    public function storeGambarProduk(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'nama_gambar' => 'required|string|max:50',
        ]);

        GambarProduk::create($request->all());

        return redirect()->route('admin.gambar_produks')->with('success', 'Gambar produk berhasil ditambahkan.');
    }

    public function editGambarProduk($id_gambar_produk)
    {
        $gambarProduk = GambarProduk::findOrFail($id_gambar_produk);
        $produks = Produk::all();
        return view('admin.gambar_produks.edit', compact('gambarProduk', 'produks'));
    }

    public function updateGambarProduk(Request $request, $id_gambar_produk)
    {
        $gambarProduk = GambarProduk::findOrFail($id_gambar_produk);

        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'nama_gambar' => 'required|string|max:50',
        ]);

        $gambarProduk->update($request->all());

        return redirect()->route('admin.gambar_produks')->with('success', 'Gambar produk berhasil diperbarui.');
    }

    public function deleteGambarProduk($id_gambar_produk)
    {
        GambarProduk::findOrFail($id_gambar_produk)->delete();
        return redirect()->route('admin.gambar_produks')->with('success', 'Gambar produk berhasil dihapus.');
    }
}
