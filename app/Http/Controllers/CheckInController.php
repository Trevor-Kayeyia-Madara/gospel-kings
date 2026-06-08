<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\RegistrationTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function index(): View
    {
        return view('admin.check-in', ['registration' => null]);
    }

    public function search(Request $request): View
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:255'],
        ]);

        $code = $data['code'];
        $registrationNumber = str_contains($code, '/tickets/')
            ? str($code)->after('/tickets/')->before('/verify')->toString()
            : $code;

        return view('admin.check-in', [
            'registration' => Registration::with('event', 'ticket', 'vipPackage')
                ->where('registration_number', $registrationNumber)
                ->orWhereHas('ticket', fn ($query) => $query->where('ticket_number', $registrationNumber))
                ->first(),
        ]);
    }

    public function store(RegistrationTicket $ticket, Request $request): RedirectResponse
    {
        $ticket->loadMissing('registration.event');

        if (! $ticket->checked_in_at) {
            $ticket->update(['checked_in_at' => now()]);
            $ticket->attendanceLogs()->create([
                'event_id' => $ticket->registration->event_id,
                'checked_in_at' => now(),
                'entry_point' => $request->input('entry_point', 'Main Gate'),
            ]);
        }

        return redirect()->route('admin.check-in.index')->with('status', 'Ticket checked in successfully.');
    }
}
