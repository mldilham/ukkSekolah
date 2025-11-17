<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use App\Http\Requests\StoreTestimoniRequest;
use App\Http\Requests\UpdateTestimoniRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonis = Testimoni::paginate(5);
        return view('admin.testimonis.index', compact('testimonis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimoniRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = true; // Set default status aktif

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimonis', 'public');
        }

        Testimoni::create($data);

        return redirect()->route('admin.testimonis.index')->with('success', 'Testimoni berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $testimoni = Testimoni::findOrFail($decryptedId);
        return view('admin.testimonis.edit', compact('testimoni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimoniRequest $request, $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $testimoni = Testimoni::findOrFail($decryptedId);
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($testimoni->foto && Storage::disk('public')->exists($testimoni->foto)) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('testimonis', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('admin.testimonis.index')->with('success', 'Testimoni berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $testimoni = Testimoni::findOrFail($decryptedId);
        // Delete photo if exists
        if ($testimoni->foto && Storage::disk('public')->exists($testimoni->foto)) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('admin.testimonis.index')->with('success', 'Testimoni berhasil dihapus');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $testimoni = Testimoni::findOrFail($decryptedId);
        $testimoni->update([
            'is_active' => !$testimoni->is_active
        ]);

        $status = $testimoni->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.testimonis.index')
            ->with('success', "Testimoni berhasil {$status}.");
    }
}
