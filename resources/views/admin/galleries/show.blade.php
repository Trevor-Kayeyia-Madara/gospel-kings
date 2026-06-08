@extends('admin.layouts.app')

@section('page-title', $gallery->title)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-0">{{ $gallery->title }}</h2>
        <p class="text-muted mb-0">{{ $gallery->event->title ?? 'General Gallery' }}</p>
    </div>
    <div>
        <a href="{{ route('admin.media.create') }}?gallery_id={{ $gallery->id }}" class="btn btn-primary">Add Media</a>
        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this gallery and all media?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Delete Gallery</button>
        </form>
    </div>
</div>

<div class="row g-3">
    @forelse ($gallery->mediaFiles as $item)
        <div class="col-md-3">
            <div class="card">
                @if ($item->type === 'photo')
                    <img src="{{ asset($item->path) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="{{ $item->title }}">
                @else
                    <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height:180px;">
                        <span class="text-white">Video</span>
                    </div>
                @endif
                <div class="card-body p-2">
                    <p class="card-text small mb-1">{{ $item->title }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-secondary">{{ $item->type }}</span>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this media?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    No media in this gallery. <a href="{{ route('admin.media.create') }}?gallery_id={{ $gallery->id }}">Add media</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    <a href="{{ route('admin.galleries.index') }}" class="btn btn-link">Back to galleries</a>
</div>
@endsection
