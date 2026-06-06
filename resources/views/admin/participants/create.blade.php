@extends('layouts.admin')

@section('title', 'Tambah Peserta')

@section('content')
    <form method="POST" action="{{ route('admin.participants.store') }}" class="admin-card stack-form">
        @csrf
        @include('admin.participants.form')
    </form>
@endsection
