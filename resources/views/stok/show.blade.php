@extends('layouts.panel')

@section('title', $trx->nomor_transaksi)
@section('judul', $k['judul'])
@section('subjudul', $trx->nomor_transaksi)

@section('content')
@if ($errors->any())
    <div class="alert err">{{ $errors->first() }}</div>
@endif

<div class="panel" style="margin-bottom:20px">
    <div class="grid3">
        <div>
            <p class="muted">Tanggal</p>
            <strong>{{ date('d/m/Y', strtotime($trx->tanggal)) }}</strong>
        </div>
        <div>
            <p class="muted">{{ $k['pihak'] }}</p>
            <strong>{{ $trx->pihak ?: '-' }}</strong>
        </div>
        <div>
            <p class="muted">Nomor referensi</p>
            <strong>{{ $trx->nomor_referensi ?: '-' }}</strong>
        </div>
    </div>
    <div class="grid3" style="margin-top:18px">
        <div>
            <p class="muted">Dicatat oleh</p>
            <strong>{{ $trx->user->name ?? '-' }}</strong>
        </div>
        <div style="grid-column:span 2">
            <p class="muted">Catatan</p>
            <strong>{{ $trx->catatan ?: '-' }}</strong>
        </div>
    </div>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>SKU</th>
                    <th class="num">Jumlah</th>
                    <th class="num">Harga</th>
                    <th class="num">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trx->details as $d)
                    <tr>
                        <td>{{ $d->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $d->barang->sku ?? '-' }}</td>
                        <td class="num">{{ $d->jumlah }}</td>
                        <td class="num">Rp {{ number_format((float) $d->harga, 0, ',', '.') }}</td>
                        <td class="num">Rp {{ number_format((float) $d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="num"><strong>Total</strong></td>
                    <td class="num"><strong>Rp {{ number_format((float) $trx->total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="margin-top:22px;display:flex;gap:10px">
        <a href="{{ route('stok.index', $jenis) }}" class="btn btn-secondary">Kembali</a>
        <form action="{{ route('stok.destroy', ['jenis' => $jenis, 'id' => $trx->id]) }}" method="POST"
              onsubmit="return confirm('Hapus transaksi ini? Stok cabang akan dikembalikan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus transaksi</button>
        </form>
    </div>
</div>
@endsection
