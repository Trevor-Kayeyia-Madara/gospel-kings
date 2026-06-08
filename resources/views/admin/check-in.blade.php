@extends('layouts.app')

@section('title', 'Check-In')

@section('content')
    <section class="section section-soft">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="eyebrow mb-2">Attendance</div>
                    <h1 class="fw-bold">Check-In Desk</h1>
                    <p class="muted">Paste a scanned QR payload, registration number, or ticket number to verify and admit an attendee.</p>
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                </div>
                <div class="col-lg-7">
                    <form class="content-card p-4 mb-4" method="POST" action="{{ route('admin.check-in.search') }}">
                        @csrf
                        <label class="form-label">Ticket / QR code</label>
                        <div class="d-flex gap-2">
                            <input class="form-control" name="code" placeholder="DINEWI-26-0001 or full QR URL" required autofocus>
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    @if ($registration)
                        <div class="content-card p-4">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="small muted">{{ $registration->event->title }}</div>
                                    <h2 class="h4 fw-bold">{{ $registration->full_name }}</h2>
                                    <p class="muted mb-0">{{ $registration->registration_number }} · {{ $registration->ticket->ticket_number }}</p>
                                </div>
                                <span class="badge text-bg-{{ $registration->status === 'confirmed' ? 'success' : 'warning' }} align-self-start">
                                    {{ ucfirst(str_replace('_', ' ', $registration->status)) }}
                                </span>
                            </div>

                            @if ($registration->ticket->checked_in_at)
                                <div class="alert alert-secondary mt-4 mb-0">Already checked in at {{ $registration->ticket->checked_in_at->format('g:i A') }}.</div>
                            @else
                                <form method="POST" action="{{ route('admin.check-in.store', $registration->ticket) }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="entry_point" value="Main Gate">
                                    <button class="btn btn-primary btn-lg w-100" @disabled($registration->status !== 'confirmed')>Approve Entry</button>
                                    @if ($registration->status !== 'confirmed')
                                        <div class="small muted mt-2">Only confirmed tickets can be admitted.</div>
                                    @endif
                                </form>
                            @endif
                        </div>
                    @elseif(request()->isMethod('post'))
                        <div class="alert alert-danger">No ticket found.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
