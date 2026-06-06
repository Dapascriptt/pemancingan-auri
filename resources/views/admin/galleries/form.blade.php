@php
    use Illuminate\Support\Str;
    $imageUrl = fn (?string $path) => $path ? (Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path)) : null;
@endphp

<label>Foto
    <input type="file" name="image" accept="image/png,image/jpeg,image/webp" @required(! $gallery->exists)>
    @if($imageUrl($gallery->image))
        <img class="preview-img" src="{{ $imageUrl($gallery->image) }}" alt="{{ $gallery->caption }}" width="160" height="110" loading="lazy">
    @endif
    @error('image') <small class="form-error">{{ $message }}</small> @enderror
</label>
<label>Caption
    <input name="caption" value="{{ old('caption', $gallery->caption) }}">
</label>
<label>Urutan
    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $gallery->sort_order ?? 0) }}">
</label>
<label class="check-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $gallery->is_active ?? true))>
    Tampilkan di website
</label>
<div class="form-actions">
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-outline" href="{{ route('admin.galleries.index') }}">Batal</a>
</div>
