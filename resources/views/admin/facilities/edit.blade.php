@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
    <form method="POST" action="{{ route('admin.facilities.update', $facility) }}" enctype="multipart/form-data" class="admin-card stack-form">
        @csrf
        @method('PUT')
        @include('admin.facilities.form')
    </form>
@endsection
