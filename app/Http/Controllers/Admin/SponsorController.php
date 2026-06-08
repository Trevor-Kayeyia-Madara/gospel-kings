<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SponsorController extends Controller
{
    public function index(): View
    {
        return view('admin.sponsors.index', [
            'sponsors' => Sponsor::with('event')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.sponsors.create', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'tier' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:500'],
            'pledged_amount' => ['nullable', 'numeric', 'min:0'],
            'received_amount' => ['nullable', 'numeric', 'min:0'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        Sponsor::create($data);

        return redirect()->route('admin.sponsors.index')->with('status', 'Sponsor added.');
    }

    public function edit(Sponsor $sponsor): View
    {
        return view('admin.sponsors.edit', [
            'sponsor' => $sponsor,
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function update(Request $request, Sponsor $sponsor): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'tier' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'string', 'max:500'],
            'pledged_amount' => ['nullable', 'numeric', 'min:0'],
            'received_amount' => ['nullable', 'numeric', 'min:0'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        $sponsor->update($data);

        return redirect()->route('admin.sponsors.index')->with('status', 'Sponsor updated.');
    }

    public function destroy(Sponsor $sponsor): RedirectResponse
    {
        $sponsor->delete();

        return back()->with('status', 'Sponsor deleted.');
    }
}
