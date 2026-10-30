<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori')->diCabang((int) session('cabang_id'));

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('barangs.nama_barang', 'like', "%{$search}%")
                    ->orWhere('barangs.sku', 'like', "%{$search}%")
                    ->orWhere('barangs.barcode', 'like', "%{$search}%");
            });
        }

        $barangs = $query->latest('barangs.created_at')->paginate(10)->withQueryString();

        // Tampilkan stok milik cabang yang sedang aktif
        $barangs->getCollection()->transform(function ($barang) {
            $barang->stok = $barang->stok_cabang;
            $barang->stok_minimum = $barang->stok_minimum_cabang;

            return $barang;
        });

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::where('is_active', true)->get();

        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:barangs,sku'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:barangs,barcode'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'merek' => ['nullable', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'lokasi_penyimpanan' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nama_barang']) . '-' . Str::slug($validated['sku']);
        $validated['is_active'] = $request->boolean('is_active');

        $barang = Barang::create($validated);

        // Stok dicatat untuk cabang yang sedang aktif
        $barang->cabangs()->syncWithoutDetaching([
            (int) session('cabang_id') => [
                'stok' => $validated['stok'],
                'stok_minimum' => $validated['stok_minimum'],
            ],
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load('kategori');
        $this->terapkanStokCabang($barang);

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::where('is_active', true)->get();
        $this->terapkanStokCabang($barang);

        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'sku' => [
                'required', 'string', 'max:255',
                Rule::unique('barangs', 'sku')->ignore($barang->id),
            ],
            'barcode' => [
                'nullable', 'string', 'max:255',
                Rule::unique('barangs', 'barcode')->ignore($barang->id),
            ],
            'nama_barang' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'merek' => ['nullable', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],
            'lokasi_penyimpanan' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['nama_barang']) . '-' . Str::slug($validated['sku']);
        $validated['is_active'] = $request->boolean('is_active');

        // Stok disimpan per cabang, bukan di tabel barang
        $stok = $validated['stok'];
        $stokMinimum = $validated['stok_minimum'];
        unset($validated['stok'], $validated['stok_minimum']);

        $barang->update($validated);

        $barang->cabangs()->syncWithoutDetaching([
            (int) session('cabang_id') => [
                'stok' => $stok,
                'stok_minimum' => $stokMinimum,
            ],
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Isi atribut stok (hanya untuk tampilan) dengan stok cabang yang aktif.
     */
    private function terapkanStokCabang(Barang $barang): void
    {
        $pivot = $barang->cabangs()
            ->where('cabangs.id', (int) session('cabang_id'))
            ->first()?->pivot;

        $barang->stok = $pivot?->stok ?? 0;
        $barang->stok_minimum = $pivot?->stok_minimum ?? 0;
    }
}
