<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // ===============================
    // DASHBOARD
    // ===============================
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTokos = Toko::count();
        $totalKategoris = Kategori::count();
        $totalProduks = Produk::count();
        $totalGambarProduks = GambarProduk::count();

        return view('admin.dashboard', compact('totalUsers', 'totalTokos', 'totalKategoris', 'totalProduks', 'totalGambarProduks'));
    }

    // ===============================
    // USER MANAGEMENT
    // ===============================
    public function indexUser()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:13',
            'username' => 'required|string|max:255|unique:users',
            'role' => 'required|in:admin,member',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:13',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'role' => 'required|in:admin,member',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Hapus semua toko dan produk terkait
        foreach ($user->tokos as $toko) {
            foreach ($toko->produks as $produk) {
                foreach ($produk->gambarProduks as $gambarProduk) {
                    Storage::disk('public')->delete($gambarProduk->nama_gambar);
                    $gambarProduk->delete();
                }
                $produk->delete();
            }
            if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
                Storage::delete('public/tokos/' . $toko->gambar);
            }
            $toko->delete();
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User dan semua data terkait berhasil dihapus.');
    }

    // ===============================
    // TOKO MANAGEMENT
    // ===============================
    public function indexToko()
    {
        $tokos = Toko::with('user')->paginate(10);
        return view('admin.tokos.index', compact('tokos'));
    }

    public function createToko()
    {
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.create', compact('users'));
    }

    public function storeToko(Request $request)
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
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/tokos', $filename);
            $data['gambar'] = $filename;
        }

        Toko::create($data);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil dibuat.');
    }

    public function editToko($id)
    {
        $toko = Toko::findOrFail($id);
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.edit', compact('toko', 'users'));
    }

    public function updateToko(Request $request, $id)
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

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroyToko($id)
    {
        $toko = Toko::findOrFail($id);

        // Hapus gambar toko jika ada
        if ($toko->gambar && Storage::exists('public/tokos/' . $toko->gambar)) {
            Storage::delete('public/tokos/' . $toko->gambar);
        }

        // Hapus semua produk dan gambar produk terkait
        foreach ($toko->produks as $produk) {
            foreach ($produk->gambarProduks as $gambarProduk) {
                Storage::disk('public')->delete($gambarProduk->nama_gambar);
                $gambarProduk->delete();
            }
            $produk->delete();
        }

        $toko->delete();

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko dan semua produk terkait berhasil dihapus.');
    }

    // ===============================
    // KATEGORI MANAGEMENT
    // ===============================
    public function indexKategori()
    {
        $kategoris = Kategori::paginate(10);
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function createKategori()
    {
        return view('admin.kategoris.create');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    public function editKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategoris')->ignore($kategori->id_kategori, 'id_kategori')],
        ]);

        $kategori->update($request->all());

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan oleh produk
        if ($kategori->produks()->exists()) {
            return redirect()->route('admin.kategoris.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ===============================
    // PRODUK MANAGEMENT
    // ===============================
    public function indexProduk()
    {
        $produks = Produk::with(['kategori', 'toko.user'])->paginate(10);
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.index', compact('produks', 'kategoris', 'tokos'));
    }

    public function createProduk()
    {
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.create', compact('kategoris', 'tokos'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:tokos,id_toko',
        ]);

        $data = $request->all();
        $data['tanggal_upload'] = now();

        Produk::create($data);

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function editProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        $tokos = Toko::with('user')->get();
        return view('admin.produks.edit', compact('produk', 'kategoris', 'tokos'));
    }

    public function updateProduk(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:tokos,id_toko',
        ]);

        $produk->update($request->all());

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduk($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus semua gambar produk terkait
        foreach ($produk->gambarProduks as $gambarProduk) {
            Storage::disk('public')->delete($gambarProduk->nama_gambar);
            $gambarProduk->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produks.index')
            ->with('success', 'Produk dan gambar terkait berhasil dihapus.');
    }

    // ===============================
    // GAMBAR PRODUK MANAGEMENT
    // ===============================
    public function indexGambarProduk()
    {
        $gambarProduks = GambarProduk::with(['produk.toko.user', 'produk.kategori'])->paginate(10);
        return view('admin.gambar_produks.index', compact('gambarProduks'));
    }

    public function createGambarProduk()
    {
        $produks = Produk::with(['toko.user', 'kategori'])->get();
        return view('admin.gambar_produks.create', compact('produks'));
    }

    public function storeGambarProduk(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produks,id_produk',
            'nama_gambar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Upload gambar
        $file = $request->file('nama_gambar');
        $filename = time() . '_' . $request->id_produk . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/produks', $filename);

        GambarProduk::create([
            'id_produk' => $request->id_produk,
            'nama_gambar' => $filename,
        ]);

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil ditambahkan.');
    }

    public function editGambarProduk($id)
    {
        $gambarProduk = GambarProduk::findOrFail($id);
        $produks = Produk::with(['toko.user', 'kategori'])->get();
        return view('admin.gambar_produks.edit', compact('gambarProduk', 'produks'));
    }

    public function updateGambarProduk(Request $request, $id)
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
            $file->storeAs('public/produks', $filename);
            $data['nama_gambar'] = $filename;
        }

        $gambarProduk->update($data);

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil diperbarui.');
    }

    public function destroyGambarProduk($id)
    {
        $gambarProduk = GambarProduk::findOrFail($id);

        // Hapus file gambar
        Storage::disk('public')->delete('produks/' . $gambarProduk->nama_gambar);

        $gambarProduk->delete();

        return redirect()->route('admin.gambar_produks.index')
            ->with('success', 'Gambar produk berhasil dihapus.');
    }
}
