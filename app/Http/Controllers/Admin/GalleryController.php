<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesUploads;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use ManagesUploads;

    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $galleries = Gallery::query()
            ->when($search, fn ($query) => $query->where('caption', 'like', "%{$search}%"))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.galleries.index', compact('galleries', 'search'));
    }

    public function create()
    {
        return view('admin.galleries.create', ['gallery' => new Gallery()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->storePublicImage($request->file('image'), 'galleries');

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deletePublicImage($gallery->image);
            $data['image'] = $this->storePublicImage($request->file('image'), 'galleries');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $this->deletePublicImage($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    private function validated(Request $request, bool $requireImage = false): array
    {
        $data = $request->validate([
            'caption' => ['nullable', 'string', 'max:160'],
            'image' => [$requireImage ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
