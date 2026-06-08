<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Registration;
use App\Notifications\PaymentConfirmationNotification;
use App\Notifications\RegistrationConfirmationNotification;
use App\Services\DarajaService;
use App\Services\RegistrationNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class PlatformController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'featuredEvent' => Event::with('vipPackages')->where('registration_open', true)->orderBy('starts_at')->first(),
            'events' => Event::orderBy('starts_at')->take(3)->get(),
            'announcements' => Announcement::whereNotNull('published_at')->latest('published_at')->take(3)->get(),
        ]);
    }

    public function about(): View
    {
        return view('about');
    }

    public function davidKasika(): View
    {
        return view('david-kasika');
    }

    public function events(): View
    {
        return view('events.index', [
            'events' => Event::with('category')->orderBy('starts_at')->paginate(9),
        ]);
    }

    public function showEvent(Event $event): View
    {
        return view('events.show', [
            'event' => $event->load('vipPackages', 'category'),
        ]);
    }

    public function register(Event $event): View
    {
        return view('events.register', [
            'event' => $event->load('vipPackages'),
        ]);
    }

    public function storeRegistration(Request $request, Event $event, RegistrationNumberService $numbers, DarajaService $daraja): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'church' => ['nullable', 'string', 'max:255'],
            'county_city' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:30'],
            'vip_package_id' => ['nullable', Rule::exists('vip_packages', 'id')->where('event_id', $event->id)],
        ]);

        $packageId = $data['vip_package_id'] ?? null;
        $registration = Registration::create([
            ...$data,
            'event_id' => $event->id,
            'vip_package_id' => $packageId,
            'registration_number' => $numbers->generate($event),
            'registration_type' => $packageId ? 'paid' : 'free',
            'status' => $packageId ? 'payment_pending' : 'confirmed',
        ]);

        $registration->ticket()->create([
            'ticket_number' => $numbers->ticketNumber($event),
            'qr_payload' => route('tickets.verify', $registration->registration_number),
            'issued_at' => now(),
        ]);

        if ($registration->registration_type === 'paid') {
            $payment = $registration->payments()->create([
                'amount' => $registration->vipPackage->amount,
                'method' => 'mpesa',
                'status' => 'pending',
                'metadata' => ['next_step' => 'Daraja STK Push'],
            ]);

            try {
                $daraja->stkPush($payment);
            } catch (Throwable $exception) {
                $payment->update([
                    'status' => 'stk_failed',
                    'metadata' => [
                        'error' => $exception->getMessage(),
                        'next_step' => 'Retry STK Push or verify Daraja credentials/callback URL.',
                    ],
                ]);
            }
        }

        if ($registration->registration_type === 'free') {
            $registration->notify(new RegistrationConfirmationNotification($registration));
        } else {
            $registration->notify(new RegistrationConfirmationNotification($registration));
        }

        return redirect()->route('events.registration.success', $registration);
    }

    public function registrationSuccess(Registration $registration): View
    {
        return view('events.success', [
            'registration' => $registration->load('event', 'ticket', 'vipPackage'),
        ]);
    }

    public function verifyTicket(string $registrationNumber): View
    {
        return view('events.ticket', [
            'registration' => Registration::with('event', 'ticket', 'vipPackage')
                ->where('registration_number', $registrationNumber)
                ->firstOrFail(),
        ]);
    }

    public function sponsors(): View
    {
        return view('sponsors.index', [
            'sponsors' => \App\Models\Sponsor::where('is_public', true)->with('event')->get(),
        ]);
    }

    public function guestMinisters(): View
    {
        return view('guest-ministers.index', [
            'ministers' => \App\Models\GuestMinister::where('is_public', true)->with('event')->get(),
        ]);
    }

    public function galleries(): View
    {
        return view('galleries.index', [
            'galleries' => \App\Models\Gallery::with('event', 'mediaFiles')->get(),
        ]);
    }

    public function showGallery(\App\Models\Gallery $gallery): View
    {
        return view('galleries.show', [
            'gallery' => $gallery->load('mediaFiles', 'event'),
        ]);
    }
}
