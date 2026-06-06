<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $packages = Package::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.packages.index', compact('packages', 'search'));
    }

    public function create()
    {
        return view('admin.packages.create', ['package' => new Package()]);
    }

    public function store(Request $request)
    {
        Package::create($this->validated($request));

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $package->update($this->validated($request));

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return back()->with('success', 'Paket berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'price' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:600'],
            'features_text' => ['nullable', 'string', 'max:1200'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $features = preg_split('/\r\n|\r|\n/', $data['features_text'] ?? '');
        $data['features'] = array_values(array_filter(array_map('trim', $features)));
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        unset($data['features_text']);

        return $data;
    }
}
