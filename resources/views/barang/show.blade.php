@extends('layouts.app')

@section('title', 'Product Detail')
@section('subtitle', $barang->nama_barang)

@section('content')
    <section class="panel">
        <table>
            <tbody>
                <tr><th>SKU</th><td>{{ $barang->sku }}</td></tr>
                <tr><th>BARCODE</th><td>{{ $barang->barcode ?? '-' }}</td></tr>
                <tr><th>NAMA</th><td>{{ $barang->nama_barang }}</td></tr>
                <tr><th>MEREK</th><td>{{ $barang->merek ?? '-' }}</td></tr>
                <tr><th>KATEGORI</th><td>{{ $barang->kategori->nama_kategori ?? '-' }}</td></tr>
                <tr><th>HARGA BELI</th><td>Rp {{ number_format((float)$barang->harga_beli, 0, ',', '.') }}</td></tr>
                <tr><th>HARGA JUAL</th><td>Rp {{ number_format((float)$barang->harga_jual, 0, ',', '.') }}</td></tr>
                <tr><th>STOK</th><td>{{ $barang->stok }} {{ $barang->satuan }} (minimum {{ $barang->stok_minimum }})</td></tr>
                <tr><th>LOKASI</th><td>{{ $barang->lokasi_penyimpanan ?? '-' }}</td></tr>
                <tr><th>DESKRIPSI</th><td>{{ $barang->deskripsi ?? '-' }}</td></tr>
                <tr><th>STATUS</th><td>{{ $barang->is_active ? 'Active' : 'Inactive' }}</td></tr>
            </tbody>
        </table>
        <div class="actions" style="margin-top:20px">
            <a href="{{ route('barang.edit', $barang) }}" class="button">Edit</a>
            <a href="{{ route('barang.index') }}" class="button button-secondary">Kembali</a>
        </div>
    </section>
@endsection
