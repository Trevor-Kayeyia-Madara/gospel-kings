@extends('layouts.app')

@section('title', 'Guest Ministers')

@section('content')
<section class="section">
    <div class="container">
        <div class="eyebrow mb-2">Ministry</div>
        <h1 class="fw-bold mb-4">Guest Ministers</h1>
        <p class="muted mb-5">Meet the ministers and guest speakers serving in this conference.</p>

        <div class="row g-4">
            @forelse ($ministers as $minister)
                <div class="col-md-4">
                    <div class="content-card p-4 h-100">
                        <h3 class="h5 fw-bold">{{ $minister->name }}</h3>
                        @if ($minister->role)
                            <div class="badge bg-warning text-dark mb-2">{{ $minister->role }}</div>
                        @endif
                        @if ($minister->email)
                            <p class="small muted mb-0"><strong>Email:</strong> {{ $minister->email }}</p>
                        @endif
                        @if ($minister->phone)
                            <p class="small muted mb-0"><strong>Phone:</strong> {{ $minister->phone }}</p>
                        @endif
                        @if ($minister->event)
                            <p class="small muted mt-2 mb-0">{{ $minister->event->title }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">No guest ministers listed yet.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
