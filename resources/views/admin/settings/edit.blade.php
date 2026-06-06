@php
    use Illuminate\Support\Str;
    $imageUrl = fn (?string $path) => $path ? (Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path)) : null;
    $highlights = old('highlight_label') ? collect(old('highlight_label'))->map(fn ($label, $i) => ['label' => $label, 'value' => old('highlight_value')[$i] ?? ''])->all() : ($setting->highlights ?: []);
    $highlights = array_pad($highlights, 3, ['label' => '', 'value' => '']);
@endphp

@extends('layouts.admin')

@section('title', 'Home Settings')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-card stack-form">
        @csrf
        @method('PUT')

        <div class="form-grid two">
            <label>Nama Website
                <input name="site_name" value="{{ old('site_name', $setting->site_name) }}" required>
                @error('site_name') <small class="form-error">{{ $message }}</small> @enderror
            </label>
            <label>Meta Title
                <input name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}">
            </label>
        </div>
        <label>Meta Description
            <textarea name="meta_description" rows="2">{{ old('meta_description', $setting->meta_description) }}</textarea>
        </label>
        <label>Meta Keywords
            <input name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords) }}">
        </label>

        <hr>
        <h2>Hero</h2>
        <label>Eyebrow
            <input name="hero_eyebrow" value="{{ old('hero_eyebrow', $setting->hero_eyebrow) }}">
        </label>
        <label>Title
            <input name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" required>
            @error('hero_title') <small class="form-error">{{ $message }}</small> @enderror
        </label>
        <label>Subtitle
            <textarea name="hero_subtitle" rows="3">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>
        </label>
        <div class="form-grid two">
            <label>CTA Text
                <input name="hero_cta_text" value="{{ old('hero_cta_text', $setting->hero_cta_text) }}">
            </label>
            <label>CTA Link
                <input name="hero_cta_link" value="{{ old('hero_cta_link', $setting->hero_cta_link) }}" placeholder="#paket">
            </label>
            <label>Secondary Text
                <input name="hero_secondary_text" value="{{ old('hero_secondary_text', $setting->hero_secondary_text) }}">
            </label>
            <label>Secondary Link
                <input name="hero_secondary_link" value="{{ old('hero_secondary_link', $setting->hero_secondary_link) }}" placeholder="#kontak">
            </label>
        </div>
        <label>Hero Image
            <input type="file" name="hero_image" accept="image/png,image/jpeg,image/webp">
            @if($imageUrl($setting->hero_image))
                <img class="preview-img" src="{{ $imageUrl($setting->hero_image) }}" alt="Preview hero" width="220" height="140" loading="lazy">
            @endif
            @error('hero_image') <small class="form-error">{{ $message }}</small> @enderror
        </label>

        <hr>
        <h2>Tentang</h2>
        <label>Judul
            <input name="about_title" value="{{ old('about_title', $setting->about_title) }}">
        </label>
        <label>Deskripsi
            <textarea name="about_description" rows="5">{{ old('about_description', $setting->about_description) }}</textarea>
        </label>
        <label>Gambar Tentang
            <input type="file" name="about_image" accept="image/png,image/jpeg,image/webp">
            @if($imageUrl($setting->about_image))
                <img class="preview-img" src="{{ $imageUrl($setting->about_image) }}" alt="Preview tentang" width="220" height="140" loading="lazy">
            @endif
        </label>

        <hr>
        <h2>Highlight Hero</h2>
        <div class="form-grid three">
            @foreach($highlights as $item)
                <label>Label
                    <input name="highlight_label[]" value="{{ $item['label'] ?? '' }}">
                </label>
                <label class="span-two">Value
                    <input name="highlight_value[]" value="{{ $item['value'] ?? '' }}">
                </label>
            @endforeach
        </div>

        <button class="btn btn-primary" type="submit">Simpan Settings</button>
    </form>
@endsection
