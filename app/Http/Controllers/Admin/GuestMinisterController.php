<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GuestMinister;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestMinisterController extends Controller
{
    public function index(): View
    {
        return view('admin.guest-ministers.index', [
            'ministers' => GuestMinister::with('event')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.guest-ministers.create', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        GuestMinister::create($data);

        return redirect()->route('admin.guest-ministers.index')->with('status', 'Guest minister added.');
    }

    public function edit(GuestMinister $guestMinister): View
    {
        return view('admin.guest-ministers.edit', [
            'minister' => $guestMinister,
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function update(Request $request, GuestMinister $guestMinister): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        $guestMinister->update($data);

        return redirect()->route('admin.guest-ministers.index')->with('status', 'Guest minister updated.');
    }

    public function destroy(GuestMinister $guestMinister): RedirectResponse
    {
        $guestMinister->delete();

        return back()->with('status', 'Guest minister deleted.');
    }
}
