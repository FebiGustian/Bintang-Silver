@extends('layouts.app')

@section('title', 'Product Management')
@section('subtitle', 'Manage and monitor your inventory products.')

@section('content')
    <div class="toolbar">
        <form action="{{ route('barang.index') }}" method="GET">
            <input type="search" name="search" placeholder="Search name, SKU, barcode..." value="{{ request('search') }}">
        </form>
        <a href="{{ route('barang.create') }}" class="button">+ Add Product</a>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>SKU</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>STOCK</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                    <tr>
                        <td><strong>{{ $barang->nama_barang }}</strong><br><small>{{ $barang->merek ?? '-' }}</small></td>
                        <td class="sku">{{ $barang->sku }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format((float)$barang->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $barang->stok }} {{ $barang->satuan }}</td>
                        <td>
                            @if(!$barang->is_active)
                                <span class="low">Inactive</span>
                            @elseif($barang->stok <= $barang->stok_minimum)
                                <span class="low">Low Stock</span>
                            @else
                                <span class="status">Active</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('barang.show', $barang) }}">Detail</a>
                                <a href="{{ route('barang.edit', $barang) }}">Edit</a>
                                <form action="{{ route('barang.destroy', $barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">Belum ada barang. Klik Add Product untuk menambahkan barang pertama.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $barangs->links() }}</div>
    </section>
@endsection
