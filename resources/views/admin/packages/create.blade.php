@extends('layouts.admin')

@section('title', 'Tambah Paket')

@section('content')
    <form method="POST" action="{{ route('admin.packages.store') }}" class="admin-card stack-form">
        @csrf
        @include('admin.packages.form')
    </form>
@endsection
