@extends('layouts.admin')

@section('title', 'Edit Paket')

@section('content')
    <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="admin-card stack-form">
        @csrf
        @method('PUT')
        @include('admin.packages.form')
    </form>
@endsection
