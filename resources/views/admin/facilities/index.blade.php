@extends('layouts.admin')

@section('title', 'Fasilitas')

@section('content')
    <div class="admin-card">
        <div class="table-toolbar">
            <form method="GET" class="search-form">
                <input name="search" value="{{ $search }}" placeholder="Cari fasilitas">
                <button class="btn btn-outline" type="submit">Search</button>
            </form>
            <a class="btn btn-primary" href="{{ route('admin.facilities.create') }}">Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($facilities as $facility)
                        <tr>
                            <td><strong>{{ $facility->title }}</strong><small>{{ $facility->description }}</small></td>
                            <td>{{ $facility->sort_order }}</td>
                            <td>{{ $facility->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td class="row-actions">
                                <a href="{{ route('admin.facilities.edit', $facility) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.facilities.destroy', $facility) }}" onsubmit="return confirm('Hapus fasilitas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $facilities->links() }}
    </div>
@endsection
