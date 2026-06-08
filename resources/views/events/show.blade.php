@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">{{ $event->category?->name }}</div>
                    <h1 class="fw-bold">{{ $event->title }} {{ $event->edition }}</h1>
                    <p class="lead muted">{{ $event->theme }}</p>
                    <p>{{ $event->description }}</p>
                    <div class="content-card p-4 mt-4">
                        <h2 class="h5 fw-bold">Event Schedule</h2>
                        @foreach ($event->schedule ?? [] as $item)
                            <div class="d-flex gap-3 border-top py-3">
                                <strong style="width: 90px">{{ $item['time'] }}</strong>
                                <span>{{ $item['item'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="content-card p-4">
                        <div class="fw-bold">Date</div>
                        <p class="muted">{{ $event->starts_at->format('l, F d, Y · g:i A') }}</p>
                        <div class="fw-bold">Venue</div>
                        <p class="muted">{{ $event->venue }} {{ $event->city ? '· '.$event->city : '' }}</p>
                        <div class="fw-bold">Capacity</div>
                        <p class="muted">{{ $event->capacity ?? 'Open' }} attendees</p>
                        <a class="btn btn-primary w-100" href="{{ route('events.register', $event) }}">Register now</a>
                    </div>
                    @if ($event->vipPackages->isNotEmpty())
                        <div class="content-card p-4 mt-3">
                            <h2 class="h5 fw-bold">VIP Packages</h2>
                            @foreach ($event->vipPackages as $package)
                                <div class="border-top py-3">
                                    <div class="fw-bold">{{ $package->name }}</div>
                                    <div class="muted">KES {{ number_format($package->amount) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
