<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class KategoriController extends Controller
{
    // ===============================
    // KATEGORI MANAGEMENT
    // ===============================
    public function index()
    {
        $kategoris = Kategori::paginate(5);
        return view('admin.kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $kategori = Kategori::findOrFail($decryptedId);
        return view('admin.kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $kategori = Kategori::findOrFail($decryptedId);

        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategoris')->ignore($kategori->id_kategori, 'id_kategori')],
        ]);

        $kategori->update($request->all());

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $kategori = Kategori::findOrFail($decryptedId);

        // Cek apakah kategori masih digunakan oleh produk
        if ($kategori->produks()->exists()) {
            return redirect()->route('admin.kategoris.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
