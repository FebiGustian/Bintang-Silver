@extends('layouts.panel')

@section('title', 'Tambah ' . $k['judul'])
@section('judul', 'Tambah ' . $k['judul'])
@section('subjudul', 'Catat transaksi stok')

@section('content')
@if ($errors->any())
    <div class="alert err">
        @foreach ($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

@if ($barangs->isEmpty())
    <div class="alert err">
        {{ $jenis === 'keluar' ? 'Belum ada barang yang stoknya tersedia di cabang ini.' : 'Belum ada barang aktif. Tambahkan barang di menu Products terlebih dahulu.' }}
    </div>
@endif

<form action="{{ route('stok.store', $jenis) }}" method="POST" class="panel">
    @csrf

    <div class="grid3">
        <div class="field">
            <label for="tanggal">Tanggal</label>
            <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>
        </div>
        <div class="field">
            <label for="pihak">{{ $k['pihak'] }}</label>
            <input id="pihak" type="text" name="pihak" value="{{ old('pihak') }}">
        </div>
        <div class="field">
            <label for="nomor_referensi">Nomor referensi</label>
            <input id="nomor_referensi" type="text" name="nomor_referensi" value="{{ old('nomor_referensi') }}">
        </div>
    </div>

    <div class="field">
        <label for="catatan">Catatan</label>
        <textarea id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
    </div>

    <h3 style="margin:18px 0 10px">Daftar barang</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th style="width:110px">Jumlah</th>
                    <th style="width:170px">{{ $jenis === 'masuk' ? 'Harga beli' : 'Harga jual' }}</th>
                    <th style="width:160px">Subtotal</th>
                    <th style="width:50px"></th>
                </tr>
            </thead>
            <tbody id="baris"></tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="num"><strong>Total</strong></td>
                    <td colspan="2"><strong id="total">Rp 0</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <button type="button" class="btn btn-secondary" id="tambah" style="margin-top:12px">+ Tambah baris</button>

    <div style="margin-top:22px;display:flex;gap:10px">
        <button type="submit" class="btn">Simpan transaksi</button>
        <a href="{{ route('stok.index', $jenis) }}" class="btn btn-secondary">Batal</a>
    </div>
</form>

<script>
(function () {
    const barangs = @json($barangs);
    const jenis = @json($jenis);
    const lama = Object.values(@json(old('items', [])));
    const tbody = document.getElementById('baris');
    const totalEl = document.getElementById('total');
    const rupiah = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    let urut = 0;

    function hitung() {
        let total = 0;
        tbody.querySelectorAll('tr').forEach(tr => {
            const jumlah = parseFloat(tr.querySelector('.jumlah').value) || 0;
            const harga = parseFloat(tr.querySelector('.harga').value) || 0;
            const sub = jumlah * harga;
            tr.querySelector('.sub').textContent = rupiah(sub);
            total += sub;
        });
        totalEl.textContent = rupiah(total);
    }

    function tambahBaris(data = {}) {
        const i = urut++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><select class="barang" name="items[${i}][barang_id]" required></select></td>
            <td><input class="jumlah" type="number" name="items[${i}][jumlah]" min="1" value="${parseInt(data.jumlah) || 1}" required></td>
            <td><input class="harga" type="number" name="items[${i}][harga]" min="0" step="any" value="${parseFloat(data.harga) || 0}" required></td>
            <td class="sub">Rp 0</td>
            <td><button type="button" class="btn-x" title="Hapus baris">&times;</button></td>`;

        const sel = tr.querySelector('.barang');
        const jumlah = tr.querySelector('.jumlah');
        const harga = tr.querySelector('.harga');

        sel.add(new Option('Pilih barang', ''));
        barangs.forEach(b => {
            const o = new Option(`${b.nama} (${b.sku}) - stok ${b.stok}`, b.id);
            o.dataset.harga = b.harga;
            o.dataset.stok = b.stok;
            if (String(b.id) === String(data.barang_id)) o.selected = true;
            sel.add(o);
        });

        const batasi = () => {
            const o = sel.selectedOptions[0];
            if (jenis === 'keluar' && o && o.dataset.stok) jumlah.max = o.dataset.stok;
        };

        sel.addEventListener('change', () => {
            const o = sel.selectedOptions[0];
            if (o && o.dataset.harga !== undefined) harga.value = o.dataset.harga;
            batasi();
            hitung();
        });
        jumlah.addEventListener('input', hitung);
        harga.addEventListener('input', hitung);
        tr.querySelector('.btn-x').addEventListener('click', () => {
            if (tbody.children.length > 1) { tr.remove(); hitung(); }
        });

        tbody.appendChild(tr);
        batasi();
        hitung();
    }

    document.getElementById('tambah').addEventListener('click', () => tambahBaris());

    if (lama.length) { lama.forEach(item => tambahBaris(item)); } else { tambahBaris(); }
})();
</script>
@endsection
