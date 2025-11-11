<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        $tokos = Toko::with('user')->paginate(10);
        return view('admin.tokos.index', compact('tokos'));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.create', compact('users'));
    }

    // ===============================
    // STORE
    // ===============================
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

        // Cek apakah user sudah punya toko
        if (Toko::where('id_user', $request->id_user)->exists()) {
            return back()->withInput()->with('error', 'User ini sudah memiliki toko.');
        }

        $data = $request->only(['nama_toko', 'deskripsi', 'id_user', 'kontak_toko', 'alamat']);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('tokos', $filename, 'public');
            $data['gambar'] = $filename;
        }

        Toko::create($data);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil dibuat.');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $toko = Toko::findOrFail($id);
        $users = User::where('role', 'member')->get();
        return view('admin.tokos.edit', compact('toko', 'users'));
    }

    // ===============================
    // UPDATE
    // ===============================
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

        // Cegah user lain punya toko lebih dari satu
        $existingToko = Toko::where('id_user', $request->id_user)
                            ->where('id_toko', '!=', $id)
                            ->first();
        if ($existingToko) {
            return back()->withInput()->with('error', 'User ini sudah memiliki toko lain.');
        }

        $data = $request->only(['nama_toko', 'deskripsi', 'id_user', 'kontak_toko', 'alamat']);

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

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil diperbarui.');
    }

    // ===============================
    // DESTROY
    // ===============================
    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);

        // Hapus gambar toko kalau ada
        if ($toko->gambar && Storage::disk('public')->exists('tokos/' . $toko->gambar)) {
            Storage::disk('public')->delete('tokos/' . $toko->gambar);
        }

        $toko->delete();

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Toko berhasil dihapus.');
    }
}
