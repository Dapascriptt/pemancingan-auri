@php
    use Illuminate\Support\Str;
    $imageUrl = fn (?string $path) => $path ? (Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path)) : null;
@endphp

<label>Nama Fasilitas
    <input name="title" value="{{ old('title', $facility->title) }}" required>
    @error('title') <small class="form-error">{{ $message }}</small> @enderror
</label>
<label>Deskripsi
    <textarea name="description" rows="4">{{ old('description', $facility->description) }}</textarea>
</label>
<div class="form-grid two">
    <label>Urutan
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $facility->sort_order ?? 0) }}">
    </label>
    <label>Gambar / Icon
        <input type="file" name="image" accept="image/png,image/jpeg,image/webp">
        @if($imageUrl($facility->image))
            <img class="preview-img" src="{{ $imageUrl($facility->image) }}" alt="{{ $facility->title }}" width="120" height="90" loading="lazy">
        @endif
        @error('image') <small class="form-error">{{ $message }}</small> @enderror
    </label>
</div>
<label class="check-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $facility->is_active ?? true))>
    Tampilkan di website
</label>
<div class="form-actions">
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-outline" href="{{ route('admin.facilities.index') }}">Batal</a>
</div>
