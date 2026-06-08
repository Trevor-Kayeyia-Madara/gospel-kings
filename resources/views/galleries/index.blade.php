@extends('layouts.app')

@section('title', 'Media Gallery')

@section('content')
<section class="section">
    <div class="container">
        <div class="eyebrow mb-2">Gallery</div>
        <h1 class="fw-bold mb-4">Media Gallery</h1>
        <p class="muted mb-5">Photos and videos from ministry events.</p>

        <div class="row g-4">
            @forelse ($galleries as $gallery)
                <div class="col-md-4">
                    <a href="{{ route('galleries.show', $gallery) }}" class="text-decoration-none">
                        <div class="content-card p-0 overflow-hidden h-100">
                            @if ($gallery->mediaFiles->first() && $gallery->mediaFiles->first()->type === 'photo')
                                <img src="{{ asset($gallery->mediaFiles->first()->path) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $gallery->title }}">
                            @else
                                <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-white fw-bold">GALLERY</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h3 class="h6 fw-bold text-dark">{{ $gallery->title }}</h3>
                                <p class="small text-muted mb-0">{{ $gallery->mediaFiles->count() }} items · {{ $gallery->event->title ?? 'General' }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">No galleries yet.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
