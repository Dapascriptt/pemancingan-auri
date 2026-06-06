<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function edit()
    {
        return view('admin.contacts.edit', [
            'contact' => Contact::query()->firstOrFail(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'address' => ['nullable', 'string', 'max:1200'],
            'whatsapp' => ['nullable', 'string', 'max:40'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'opening_hours' => ['nullable', 'string', 'max:120'],
            'maps_embed' => ['nullable', 'string', 'max:4000'],
            'maps_url' => ['nullable', 'url', 'max:500'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'facebook' => ['nullable', 'url', 'max:500'],
            'tiktok' => ['nullable', 'url', 'max:500'],
        ]);

        Contact::query()->firstOrFail()->update($data);

        return back()->with('success', 'Kontak berhasil diperbarui.');
    }
}
