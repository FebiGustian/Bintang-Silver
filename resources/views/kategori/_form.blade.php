@csrf

<div class="form-group">
    <label for="kode_kategori">Kode Kategori</label>
    <input type="text" id="kode_kategori" name="kode_kategori" placeholder="Contoh: ELK"
           value="{{ old('kode_kategori', $kategori->kode_kategori ?? '') }}">
    @error('kode_kategori') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="nama_kategori">Nama Kategori</label>
    <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Elektronik"
           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}">
    @error('nama_kategori') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="warna">Warna</label>
    <input type="color" id="warna" name="warna" value="{{ old('warna', $kategori->warna ?? '#2563eb') }}">
    @error('warna') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    @php
        $aktif = old() ? old('is_active') : ($kategori->is_active ?? true);
    @endphp
    <label>
        <input type="checkbox" name="is_active" value="1" @checked($aktif)>
        Kategori aktif
    </label>
</div>

<div class="actions">
    <button type="submit" class="button">Simpan</button>
    <a href="{{ route('kategori.index') }}" class="button button-secondary">Batal</a>
</div>
