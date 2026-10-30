@csrf

<div class="form-group">
    <label for="sku">SKU</label>
    <input type="text" id="sku" name="sku" value="{{ old('sku', $barang->sku ?? '') }}">
    @error('sku') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="barcode">Barcode (opsional)</label>
    <input type="text" id="barcode" name="barcode" value="{{ old('barcode', $barang->barcode ?? '') }}">
    @error('barcode') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="nama_barang">Nama Barang</label>
    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}">
    @error('nama_barang') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="merek">Merek (opsional)</label>
    <input type="text" id="merek" name="merek" value="{{ old('merek', $barang->merek ?? '') }}">
    @error('merek') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="kategori_id">Kategori</label>
    <select id="kategori_id" name="kategori_id">
        <option value="">Pilih kategori</option>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" @selected(old('kategori_id', $barang->kategori_id ?? '') == $kategori->id)>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    @if($kategoris->isEmpty())
        <p class="error-text">Belum ada kategori aktif. <a href="{{ route('kategori.create') }}">Tambah kategori dulu</a>.</p>
    @endif
    @error('kategori_id') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="satuan">Satuan</label>
    <input type="text" id="satuan" name="satuan" placeholder="pcs, box, kg" value="{{ old('satuan', $barang->satuan ?? '') }}">
    @error('satuan') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="harga_beli">Harga Beli</label>
    <input type="number" step="0.01" min="0" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli ?? '') }}">
    @error('harga_beli') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="harga_jual">Harga Jual</label>
    <input type="number" step="0.01" min="0" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual ?? '') }}">
    @error('harga_jual') <p class="error-text">{{ $message }}</p> @enderror
</div>

@if(!isset($barang))
<div class="form-group">
    <label for="stok">Stok Awal</label>
    <input type="number" min="0" id="stok" name="stok" value="{{ old('stok', 0) }}">
    @error('stok') <p class="error-text">{{ $message }}</p> @enderror
</div>
@else
<div class="form-group">
    <label>Stok Saat Ini</label>
    <p style="margin:0">{{ $barang->stok }} {{ $barang->satuan }}</p>
</div>
@endif

<div class="form-group">
    <label for="stok_minimum">Stok Minimum</label>
    <input type="number" min="0" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $barang->stok_minimum ?? 5) }}">
    @error('stok_minimum') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="lokasi_penyimpanan">Lokasi Penyimpanan (opsional)</label>
    <input type="text" id="lokasi_penyimpanan" name="lokasi_penyimpanan" placeholder="Contoh: Rak A2" value="{{ old('lokasi_penyimpanan', $barang->lokasi_penyimpanan ?? '') }}">
    @error('lokasi_penyimpanan') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi (opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    @php
        $aktif = old() ? old('is_active') : ($barang->is_active ?? true);
    @endphp
    <label>
        <input type="checkbox" name="is_active" value="1" @checked($aktif)>
        Barang aktif
    </label>
</div>

<div class="actions">
    <button type="submit" class="button">Simpan</button>
    <a href="{{ route('barang.index') }}" class="button button-secondary">Batal</a>
</div>
