@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <section class="section section-soft">
        <div class="container">
            <div class="eyebrow mb-2">Events</div>
            <h1 class="fw-bold mb-4">All ministry events</h1>
            <div class="row g-4">
                @foreach ($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="content-card p-4 h-100">
                            <div class="small muted">{{ $event->category?->name }} · {{ $event->starts_at->format('M d, Y') }}</div>
                            <h2 class="h4 fw-bold mt-2">{{ $event->title }} {{ $event->edition }}</h2>
                            <p class="muted">{{ $event->summary }}</p>
                            <div class="d-flex gap-2">
                                <a class="btn btn-primary" href="{{ route('events.register', $event) }}">Register</a>
                                <a class="btn btn-outline-dark" href="{{ route('events.show', $event) }}">Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $events->links() }}</div>
        </div>
    </section>
@endsection
