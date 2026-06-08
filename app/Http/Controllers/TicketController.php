<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function showQr(string $ticketNumber)
    {
        $registration = Registration::with('ticket', 'event')
            ->whereHas('ticket', fn ($q) => $q->where('ticket_number', $ticketNumber))
            ->firstOrFail();

        $qrData = route('tickets.verify', $registration->registration_number);

        return response()->stream(function () use ($qrData) {
            echo QrCode::format('png')->size(400)->generate($qrData);
        }, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="ticket-'.$ticketNumber.'.png"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
