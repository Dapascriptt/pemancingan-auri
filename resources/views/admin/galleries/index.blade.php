@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
    <div class="admin-card">
        <div class="table-toolbar">
            <form method="GET" class="search-form">
                <input name="search" value="{{ $search }}" placeholder="Cari caption">
                <button class="btn btn-outline" type="submit">Search</button>
            </form>
            <a class="btn btn-primary" href="{{ route('admin.galleries.create') }}">Tambah</a>
        </div>
        <div class="admin-gallery">
            @forelse($galleries as $gallery)
                @php
                    $src = Illuminate\Support\Str::startsWith($gallery->image, ['http://', 'https://']) ? $gallery->image : asset('storage/'.$gallery->image);
                @endphp
                <article>
                    <img src="{{ $src }}" alt="{{ $gallery->caption ?: 'Galeri' }}" width="220" height="150" loading="lazy">
                    <strong>{{ $gallery->caption ?: 'Tanpa caption' }}</strong>
                    <span>{{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }} - Urutan {{ $gallery->sort_order }}</span>
                    <div class="row-actions">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p>Belum ada foto.</p>
            @endforelse
        </div>
        {{ $galleries->links() }}
    </div>
@endsection
