<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesUploads;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use ManagesUploads;

    public function edit()
    {
        return view('admin.settings.edit', [
            'setting' => SiteSetting::query()->firstOrFail(),
        ]);
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::query()->firstOrFail();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'hero_eyebrow' => ['nullable', 'string', 'max:120'],
            'hero_title' => ['required', 'string', 'max:180'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'hero_cta_text' => ['nullable', 'string', 'max:80'],
            'hero_cta_link' => ['nullable', 'string', 'max:120'],
            'hero_secondary_text' => ['nullable', 'string', 'max:80'],
            'hero_secondary_link' => ['nullable', 'string', 'max:120'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'about_title' => ['nullable', 'string', 'max:180'],
            'about_description' => ['nullable', 'string', 'max:1200'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'highlight_label' => ['nullable', 'array'],
            'highlight_label.*' => ['nullable', 'string', 'max:80'],
            'highlight_value' => ['nullable', 'array'],
            'highlight_value.*' => ['nullable', 'string', 'max:120'],
        ]);

        if ($request->hasFile('hero_image')) {
            $this->deletePublicImage($setting->hero_image);
            $data['hero_image'] = $this->storePublicImage($request->file('hero_image'), 'settings');
        }

        if ($request->hasFile('about_image')) {
            $this->deletePublicImage($setting->about_image);
            $data['about_image'] = $this->storePublicImage($request->file('about_image'), 'settings');
        }

        $data['highlights'] = $this->formatHighlights(
            $request->input('highlight_label', []),
            $request->input('highlight_value', [])
        );

        unset($data['highlight_label'], $data['highlight_value']);

        $setting->update($data);

        return back()->with('success', 'Home settings berhasil diperbarui.');
    }

    private function formatHighlights(array $labels, array $values): array
    {
        $items = [];

        foreach ($labels as $index => $label) {
            $value = $values[$index] ?? null;
            if ($label || $value) {
                $items[] = ['label' => $label, 'value' => $value];
            }
        }

        return $items;
    }
}
