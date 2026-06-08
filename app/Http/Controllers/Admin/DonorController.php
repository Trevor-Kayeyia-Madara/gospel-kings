<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Donor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorController extends Controller
{
    public function index(): View
    {
        return view('admin.donors.index', [
            'donors' => Donor::with('event')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.donors.create', [
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
            'donation_type' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_anonymous' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_anonymous'] = $request->boolean('is_anonymous');
        $data['is_public'] = $request->boolean('is_public');

        Donor::create($data);

        return redirect()->route('admin.donors.index')->with('status', 'Donor added.');
    }

    public function edit(Donor $donor): View
    {
        return view('admin.donors.edit', [
            'donor' => $donor,
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function update(Request $request, Donor $donor): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'donation_type' => ['nullable', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'is_anonymous' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_anonymous'] = $request->boolean('is_anonymous');
        $data['is_public'] = $request->boolean('is_public');

        $donor->update($data);

        return redirect()->route('admin.donors.index')->with('status', 'Donor updated.');
    }

    public function destroy(Donor $donor): RedirectResponse
    {
        $donor->delete();

        return back()->with('status', 'Donor removed.');
    }
}
