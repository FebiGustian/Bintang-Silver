@extends('layouts.panel')

@section('title', $k['judul'])
@section('judul', $k['judul'])
@section('subjudul', 'Riwayat transaksi cabang')

@section('content')
<section class="cards" style="grid-template-columns:repeat(2,1fr)">
    <div class="card">
        <p>TRANSAKSI BULAN INI</p>
        <h2>{{ $jumlahBulanIni }}</h2>
        <small>{{ now()->format('m/Y') }}</small>
    </div>
    <div class="card">
        <p>NILAI {{ strtoupper($k['judul']) }} BULAN INI</p>
        <h2>Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</h2>
        <small>Total nilai transaksi</small>
    </div>
</section>

<div class="panel">
    <div class="panel-head">
        <h3>Riwayat {{ $k['judul'] }}</h3>
        <a class="btn" href="{{ route('stok.create', $jenis) }}">+ Tambah {{ $k['judul'] }}</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>{{ $k['pihak'] }}</th>
                    <th class="num">Item</th>
                    <th class="num">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $t)
                    <tr>
                        <td>{{ $t->nomor_transaksi }}</td>
                        <td>{{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                        <td>{{ $t->pihak ?: '-' }}</td>
                        <td class="num">{{ $t->details_count }}</td>
                        <td class="num">Rp {{ number_format((float) $t->total, 0, ',', '.') }}</td>
                        <td class="num"><a href="{{ route('stok.show', ['jenis' => $jenis, 'id' => $t->id]) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:#8491a5;padding:30px">Belum ada transaksi di cabang ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $transaksis->links('pagination::default') }}
</div>
@endsection
