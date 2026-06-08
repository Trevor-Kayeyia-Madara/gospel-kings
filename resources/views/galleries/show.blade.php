@extends('layouts.app')

@section('title', $gallery->title)

@section('content')
<section class="section">
    <div class="container">
        <div class="eyebrow mb-2">Gallery</div>
        <h1 class="fw-bold mb-2">{{ $gallery->title }}</h1>
        <p class="muted mb-4">{{ $gallery->event->title ?? 'General Gallery' }}</p>

        <div class="row g-3">
            @forelse ($gallery->mediaFiles as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="content-card p-0 overflow-hidden">
                        @if ($item->type === 'photo')
                            <img src="{{ asset($item->path) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $item->title }}">
                        @else
                            <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 220px;">
                                <span class="text-white fw-bold">VIDEO</span>
                            </div>
                        @endif
                        <div class="card-body p-2">
                            <p class="small mb-0">{{ $item->title }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">No media in this gallery.</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            <a href="{{ route('galleries.index') }}" class="btn btn-outline-dark">Back to galleries</a>
        </div>
    </div>
</section>
@endsection
