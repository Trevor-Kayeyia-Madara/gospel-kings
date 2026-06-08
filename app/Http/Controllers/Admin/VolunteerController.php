<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VolunteerController extends Controller
{
    public function index(): View
    {
        return view('admin.volunteers.index', [
            'volunteers' => Volunteer::with('event')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.volunteers.create', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'shift' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
            'is_confirmed' => ['nullable', 'boolean'],
        ]);

        $data['is_confirmed'] = $request->boolean('is_confirmed');

        Volunteer::create($data);

        return redirect()->route('admin.volunteers.index')->with('status', 'Volunteer added.');
    }

    public function edit(Volunteer $volunteer): View
    {
        return view('admin.volunteers.edit', [
            'volunteer' => $volunteer,
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function update(Request $request, Volunteer $volunteer): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'shift' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
            'is_confirmed' => ['nullable', 'boolean'],
        ]);

        $data['is_confirmed'] = $request->boolean('is_confirmed');

        $volunteer->update($data);

        return redirect()->route('admin.volunteers.index')->with('status', 'Volunteer updated.');
    }

    public function destroy(Volunteer $volunteer): RedirectResponse
    {
        $volunteer->delete();

        return back()->with('status', 'Volunteer removed.');
    }
}
