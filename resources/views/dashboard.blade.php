@extends('layouts.panel')

@section('title', 'Dashboard')
@section('judul', 'Dashboard Overview')
@section('subjudul', 'Inventory Management Workspace')

@section('content')
<section class="welcome">
    <h2>Welcome to Bintang Silver 👋</h2>
    <p>Data di halaman ini khusus untuk cabang {{ $cabang->nama_cabang ?? '-' }}.</p>
</section>

<h3 class="title">Inventory Summary</h3>
<section class="cards">
    <div class="card"><p>TOTAL PRODUCTS</p><h2>{{ number_format($totalProduk, 0, ',', '.') }}</h2><small>Registered products</small></div>
    <div class="card"><p>INVENTORY VALUE</p><h2>Rp {{ number_format($nilaiStok, 0, ',', '.') }}</h2><small>Estimated stock value</small></div>
    <div class="card"><p>LOW STOCK</p><h2>{{ $stokMenipis }}</h2><small>Need replenishment</small></div>
    <div class="card"><p>OUT OF STOCK</p><h2>{{ $stokHabis }}</h2><small>Unavailable products</small></div>
    <div class="card"><p>BARANG MASUK BULAN INI</p><h2>Rp {{ number_format($nilaiMasuk, 0, ',', '.') }}</h2><small>{{ $jumlahMasuk }} transaksi</small></div>
    <div class="card"><p>BARANG KELUAR BULAN INI</p><h2>Rp {{ number_format($nilaiKeluar, 0, ',', '.') }}</h2><small>{{ $jumlahKeluar }} transaksi</small></div>
</section>

<section class="content">
    <div class="panel">
        <h3>Stock Movement</h3>
        <div class="legend">
            <span><i class="dot"></i>Masuk</span>
            <span><i class="dot out"></i>Keluar</span>
            <span>(jumlah barang per bulan)</span>
        </div>
        <div class="chart">
            @foreach ($grafik as $g)
                <div class="grp">
                    <div class="bar" style="height:{{ $g['masuk'] / $maks * 100 }}%" title="Masuk: {{ $g['masuk'] }}"></div>
                    <div class="bar out" style="height:{{ $g['keluar'] / $maks * 100 }}%" title="Keluar: {{ $g['keluar'] }}"></div>
                </div>
            @endforeach
        </div>
        <div class="months">
            @foreach ($grafik as $g)
                <span>{{ $g['bulan'] }}</span>
            @endforeach
        </div>
    </div>

    <div class="panel">
        <h3>Recent Activity</h3>
        @forelse ($aktivitas as $a)
            <div class="activity">
                <a href="{{ route('stok.show', ['jenis' => $a['jenis'], 'id' => $a['id']]) }}">
                    <strong>{{ $a['jenis'] === 'masuk' ? '↓ Barang Masuk' : '↑ Barang Keluar' }}</strong>
                    <small>{{ $a['nomor'] }} · Rp {{ number_format($a['total'], 0, ',', '.') }} · {{ date('d/m/Y H:i', $a['waktu']) }}</small>
                </a>
            </div>
        @empty
            <div class="activity"><small>Belum ada aktivitas di cabang ini.</small></div>
        @endforelse
    </div>
</section>
@endsection
