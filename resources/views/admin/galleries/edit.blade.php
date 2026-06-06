@extends('layouts.admin')

@section('title', 'Edit Foto')

@section('content')
    <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data" class="admin-card stack-form">
        @csrf
        @method('PUT')
        @include('admin.galleries.form')
    </form>
@endsection
