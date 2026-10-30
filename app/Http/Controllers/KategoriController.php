<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('barangs')->latest()->paginate(15);

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori' => 'required|string|max:20|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:500',
            'warna'         => 'required|string|size:7',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kategori']) . '-' . Str::slug($validated['kode_kategori']);
        $validated['is_active'] = $request->boolean('is_active');

        Kategori::create($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:20',
                Rule::unique('kategoris', 'kode_kategori')->ignore($kategori->id)],
            'nama_kategori' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string|max:500',
            'warna'         => 'required|string|size:7',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kategori']) . '-' . Str::slug($validated['kode_kategori']);
        $validated['is_active'] = $request->boolean('is_active');

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->barangs()->exists()) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori masih dipakai oleh barang, tidak bisa dihapus.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}