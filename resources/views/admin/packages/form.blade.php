<label>Nama Paket
    <input name="name" value="{{ old('name', $package->name) }}" required>
    @error('name') <small class="form-error">{{ $message }}</small> @enderror
</label>
<div class="form-grid two">
    <label>Harga
        <input name="price" value="{{ old('price', $package->price) }}" placeholder="Rp25.000">
    </label>
    <label>Urutan
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $package->sort_order ?? 0) }}">
    </label>
</div>
<label>Deskripsi
    <textarea name="description" rows="4">{{ old('description', $package->description) }}</textarea>
</label>
<label>Fitur Paket
    <textarea name="features_text" rows="5" placeholder="Satu fitur per baris">{{ old('features_text', implode(PHP_EOL, $package->features ?? [])) }}</textarea>
</label>
<div class="form-grid two">
    <label class="check-row">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured ?? false))>
        Jadikan highlight
    </label>
    <label class="check-row">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active ?? true))>
        Tampilkan di website
    </label>
</div>
<div class="form-actions">
    <button class="btn btn-primary" type="submit">Simpan</button>
    <a class="btn btn-outline" href="{{ route('admin.packages.index') }}">Batal</a>
</div>
