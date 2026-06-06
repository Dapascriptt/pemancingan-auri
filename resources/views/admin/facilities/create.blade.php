@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@section('content')
    <form method="POST" action="{{ route('admin.facilities.store') }}" enctype="multipart/form-data" class="admin-card stack-form">
        @csrf
        @include('admin.facilities.form')
    </form>
@endsection
