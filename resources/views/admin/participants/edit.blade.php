@extends('layouts.admin')

@section('title', 'Edit Peserta')

@section('content')
    <form method="POST" action="{{ route('admin.participants.update', $participant) }}" class="admin-card stack-form">
        @csrf
        @method('PUT')
        @include('admin.participants.form')
    </form>
@endsection
