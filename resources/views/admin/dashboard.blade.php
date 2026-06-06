@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="stat-grid">
        <article class="stat-card">
            <span>Total Galeri</span>
            <strong>{{ $galleryCount }}</strong>
        </article>
        <article class="stat-card">
            <span>Total Fasilitas</span>
            <strong>{{ $facilityCount }}</strong>
        </article>
        <article class="stat-card">
            <span>Total Paket</span>
            <strong>{{ $packageCount }}</strong>
        </article>
        <article class="stat-card">
            <span>Total Peserta</span>
            <strong>{{ $participantCount }}</strong>
        </article>
    </div>
@endsection
