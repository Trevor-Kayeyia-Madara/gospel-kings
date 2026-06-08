@extends('layouts.app')

@section('title', 'Ticket Verification')

@section('content')
    <section class="section section-soft">
        <div class="container">
            <div class="content-card p-4 p-md-5 mx-auto" style="max-width: 720px">
                <div class="eyebrow mb-2">Ticket Verification</div>
                <h1 class="fw-bold">{{ $registration->full_name }}</h1>
                <p class="muted mb-4">{{ $registration->event->title }} {{ $registration->event->edition }}</p>
                <div class="border rounded-3 p-4 bg-light text-center">
                    <div class="d-inline-block bg-white p-3 rounded-3 mb-3">
                        {!! QrCode::size(220)->margin(1)->generate($registration->ticket->qr_payload) !!}
                    </div>
                    <div class="display-6 fw-bold">{{ $registration->ticket->ticket_number }}</div>
                    <div class="small muted">QR payload: {{ $registration->ticket->qr_payload }}</div>
                </div>
                <div class="alert alert-success mt-4 mb-0">Status: {{ ucfirst(str_replace('_', ' ', $registration->status)) }}</div>
            </div>
        </div>
    </section>
@endsection
