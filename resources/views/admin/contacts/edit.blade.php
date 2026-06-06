@extends('layouts.admin')

@section('title', 'Kontak')

@section('content')
    <form method="POST" action="{{ route('admin.contacts.update') }}" class="admin-card stack-form">
        @csrf
        @method('PUT')

        <label>Alamat
            <textarea name="address" rows="4">{{ old('address', $contact->address) }}</textarea>
        </label>
        <div class="form-grid two">
            <label>WhatsApp
                <input name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}" placeholder="6281234567890">
            </label>
            <label>Telepon
                <input name="phone" value="{{ old('phone', $contact->phone) }}">
            </label>
            <label>Email
                <input type="email" name="email" value="{{ old('email', $contact->email) }}">
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </label>
            <label>Jam Operasional
                <input name="opening_hours" value="{{ old('opening_hours', $contact->opening_hours) }}">
            </label>
        </div>
        <label>Maps Embed URL
            <input name="maps_embed" value="{{ old('maps_embed', $contact->maps_embed) }}" placeholder="https://maps.google.com/maps?...&output=embed">
        </label>
        <label>Google Maps URL
            <input name="maps_url" value="{{ old('maps_url', $contact->maps_url) }}">
            @error('maps_url') <small class="form-error">{{ $message }}</small> @enderror
        </label>
        <div class="form-grid three">
            <label>Instagram
                <input name="instagram" value="{{ old('instagram', $contact->instagram) }}">
            </label>
            <label>Facebook
                <input name="facebook" value="{{ old('facebook', $contact->facebook) }}">
            </label>
            <label>TikTok
                <input name="tiktok" value="{{ old('tiktok', $contact->tiktok) }}">
            </label>
        </div>
        <button class="btn btn-primary" type="submit">Simpan Kontak</button>
    </form>
@endsection
