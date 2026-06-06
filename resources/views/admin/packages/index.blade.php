@extends('layouts.admin')

@section('title', 'Paket')

@section('content')
    <div class="admin-card">
        <div class="table-toolbar">
            <form method="GET" class="search-form">
                <input name="search" value="{{ $search }}" placeholder="Cari paket">
                <button class="btn btn-outline" type="submit">Search</button>
            </form>
            <a class="btn btn-primary" href="{{ route('admin.packages.create') }}">Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama</th><th>Harga</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td><strong>{{ $package->name }}</strong><small>{{ $package->description }}</small></td>
                            <td>{{ $package->price }}</td>
                            <td>{{ $package->is_active ? 'Aktif' : 'Nonaktif' }} @if($package->is_featured) / Highlight @endif</td>
                            <td class="row-actions">
                                <a href="{{ route('admin.packages.edit', $package) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" onsubmit="return confirm('Hapus paket ini?')">
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
        {{ $packages->links() }}
    </div>
@endsection
