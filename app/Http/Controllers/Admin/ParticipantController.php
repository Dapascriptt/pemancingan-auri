<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $participants = Participant::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.participants.index', compact('participants', 'search'));
    }

    public function create()
    {
        return view('admin.participants.create', ['participant' => new Participant()]);
    }

    public function store(Request $request)
    {
        Participant::create($this->validated($request));

        return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function edit(Participant $participant)
    {
        return view('admin.participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $participant->update($this->validated($request));

        return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil diperbarui.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'note' => ['nullable', 'string', 'max:160'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
