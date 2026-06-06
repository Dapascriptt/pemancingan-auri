@extends('layouts.admin')

@section('title', 'Tambah Foto')

@section('content')
    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="admin-card stack-form">
        @csrf
        @include('admin.galleries.form')
    </form>
@endsection
