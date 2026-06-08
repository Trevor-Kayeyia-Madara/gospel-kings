@extends('layouts.app')

@section('title', 'Sponsors & Partners')

@section('content')
<section class="section">
    <div class="container">
        <div class="eyebrow mb-2">Partners</div>
        <h1 class="fw-bold mb-4">Sponsors & Partners</h1>
        <p class="muted mb-5">We are grateful to our sponsors and partners who support the ministry.</p>

        <div class="row g-4">
            @forelse ($sponsors as $sponsor)
                <div class="col-md-4">
                    <div class="content-card p-4 text-center h-100">
                        @if ($sponsor->logo_path)
                            <img src="{{ $sponsor->logo_path }}" alt="{{ $sponsor->name }}" style="max-height: 80px; max-width: 100%; object-fit: contain;">
                        @endif
                        <h3 class="h5 fw-bold mt-3">{{ $sponsor->name }}</h3>
                        @if ($sponsor->tier)
                            <span class="badge bg-warning text-dark">{{ $sponsor->tier }}</span>
                        @endif
                        <p class="small muted mt-2">{{ $sponsor->event->title ?? 'General Partner' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">No sponsors listed yet.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
