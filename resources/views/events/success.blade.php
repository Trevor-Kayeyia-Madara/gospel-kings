@extends('layouts.app')

@section('title', 'Registration Confirmed')

@section('content')
    <section class="section">
        <div class="container">
            <div class="content-card p-4 p-md-5 mx-auto" style="max-width: 760px">
                <div class="eyebrow mb-2">Registration Received</div>
                <h1 class="fw-bold">Thank you, {{ $registration->full_name }}</h1>
                <p class="muted">Your registration for {{ $registration->event->title }} {{ $registration->event->edition }} has been captured.</p>

                @if ($registration->registration_type === 'paid')
                    <div class="alert alert-info">M-Pesa status: {{ ucfirst(str_replace('_', ' ', $registration->payments()->latest()->first()?->status ?? 'pending')) }}. Complete the STK prompt on your phone to confirm your ticket.</div>
                @endif

                <div class="alert alert-warning mt-3">
                    <strong>Important:</strong> The QR code below will be scanned at the gate on {{ $registration->event->starts_at->format('l, F d, Y') }} for confirmation and check-in. Keep it accessible on your phone or print it.
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="metric">
                            <div class="small muted">Registration Number</div>
                            <div class="h4 fw-bold">{{ $registration->registration_number }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="metric">
                            <div class="small muted">Ticket Number</div>
                            <div class="h4 fw-bold">{{ $registration->ticket->ticket_number }}</div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="d-inline-block bg-white p-3 rounded-3 border">
                        {!! QrCode::size(280)->margin(2)->generate($registration->ticket->qr_payload) !!}
                    </div>
                    <p class="small muted mt-2 mb-0">Scan this at the event gate for entry</p>
                </div>

                <div class="mt-4 text-center">
                    <a class="btn btn-primary" href="{{ route('tickets.verify', $registration->registration_number) }}">View ticket verification</a>
                </div>
            </div>
        </div>
    </section>
@endsection
