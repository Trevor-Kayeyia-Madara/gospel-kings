@extends('layouts.app')

@section('title', 'Gospel Kings Band Digital Platform')

@section('content')
    <header class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="eyebrow mb-3">Official Ministry Platform</div>
                    <h1 class="display-3 fw-bold mb-4">Gospel Kings Band</h1>
                    <p class="lead mb-4">A central digital home for ministry information, David Kasika's profile, events, registrations, ticketing, payments, media, partners, and long-term engagement.</p>
                    <div class="d-flex flex-wrap gap-2">
                        @if ($featuredEvent)
                            <a class="btn btn-primary btn-lg" href="{{ route('events.register', $featuredEvent) }}">Register for {{ $featuredEvent->title }}</a>
                            <a class="btn btn-outline-light btn-lg" href="{{ route('events.show', $featuredEvent) }}">View event</a>
                        @else
                            <a class="btn btn-primary btn-lg" href="{{ route('events.index') }}">View events</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <div class="eyebrow mb-2">Platform Modules</div>
                    <h2 class="fw-bold mb-3">Built for today’s event and the next season of ministry.</h2>
                    <p class="muted">Dine With The King is the first event on a platform designed for unlimited worship concerts, conferences, retreats, crusades, fundraising events, and special services.</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        @foreach (['Events Management', 'Free and Paid Registration', 'M-Pesa Workflow', 'QR Ticketing', 'VIP Management', 'Reports and Analytics'] as $module)
                            <div class="col-md-6">
                                <div class="content-card p-4 h-100">
                                    <div class="fw-bold">{{ $module }}</div>
                                    <div class="small muted mt-2">Configured as a reusable ministry platform module.</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
                <div>
                    <div class="eyebrow mb-2">Upcoming Events</div>
                    <h2 class="fw-bold mb-0">Current registrations</h2>
                </div>
                <a class="btn btn-outline-dark" href="{{ route('events.index') }}">All events</a>
            </div>
            <div class="row g-4">
                @foreach ($events as $event)
                    <div class="col-md-4">
                        <div class="content-card p-4 h-100">
                            <div class="small muted">{{ $event->starts_at->format('M d, Y') }} · {{ $event->venue }}</div>
                            <h3 class="h5 fw-bold mt-2">{{ $event->title }} {{ $event->edition }}</h3>
                            <p class="muted">{{ $event->summary }}</p>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-primary">Open event</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="h2 fw-bold mb-0">01</div>
                        <div class="fw-bold">Ministry Website</div>
                        <div class="small muted">Official public presence and profile.</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="h2 fw-bold mb-0">12+</div>
                        <div class="fw-bold">Event-Ready Modules</div>
                        <div class="small muted">Registration, VIP, ticketing, media, reports, partners.</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="metric">
                        <div class="h2 fw-bold mb-0">∞</div>
                        <div class="fw-bold">Future Events</div>
                        <div class="small muted">One platform for every future ministry gathering.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
