@extends('layouts.app')

@section('title', 'Category Management')
@section('subtitle', 'Group your products by category.')

@section('content')
    <div class="toolbar">
        <div></div>
        <a href="{{ route('kategori.create') }}" class="button">+ Add Category</a>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>COLOR</th>
                    <th>PRODUCTS</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                    <tr>
                        <td class="sku">{{ $item->kode_kategori }}</td>
                        <td><strong>{{ $item->nama_kategori }}</strong><br><small>{{ $item->deskripsi }}</small></td>
                        <td><span class="swatch" style="background: {{ $item->warna }}"></span></td>
                        <td>{{ $item->barangs_count }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="status">Active</span>
                            @else
                                <span class="low">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('kategori.edit', $item) }}">Edit</a>
                                <form action="{{ route('kategori.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty">Belum ada kategori. Klik Add Category untuk menambahkan kategori pertama.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $kategori->links() }}</div>
    </section>
@endsection
