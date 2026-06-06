@extends('layouts.admin')

@section('title', 'Peserta')

@section('content')
    <div class="admin-card">
        <div class="table-toolbar">
            <form method="GET" class="search-form">
                <input name="search" value="{{ $search }}" placeholder="Cari peserta">
                <button class="btn btn-outline" type="submit">Search</button>
            </form>
            <a class="btn btn-primary" href="{{ route('admin.participants.create') }}">Tambah</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama</th><th>Kontak</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td><strong>{{ $participant->name }}</strong><small>{{ $participant->note }}</small></td>
                            <td>{{ $participant->phone ?: '-' }}</td>
                            <td>{{ $participant->is_active ? 'Aktif' : 'Nonaktif' }} / Urutan {{ $participant->sort_order }}</td>
                            <td class="row-actions">
                                <a href="{{ route('admin.participants.edit', $participant) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.participants.destroy', $participant) }}" onsubmit="return confirm('Hapus peserta ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $participants->links() }}
    </div>
@endsection
