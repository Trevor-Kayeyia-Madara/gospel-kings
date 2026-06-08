@extends('admin.layouts.app')

@section('page-title', 'Media Library')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Media Library</h2>
    <a href="{{ route('admin.media.create') }}" class="btn btn-primary">Upload Media</a>
</div>

<form method="GET" action="{{ route('admin.media.index') }}" class="card mb-3">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Filter by Gallery</label>
                <select name="gallery_id" class="form-select">
                    <option value="">All galleries</option>
                    @foreach ($galleries as $gallery)
                        <option value="{{ $gallery->id }}" @selected($currentGallery == $gallery->id)>{{ $gallery->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-secondary w-100">Filter</button>
            </div>
        </div>
    </div>
</form>

<div class="row g-3">
    @forelse ($media as $item)
        <div class="col-md-3">
            <div class="card">
                @if ($item->type === 'photo')
                    <img src="{{ asset($item->path) }}" class="card-img-top" style="height:160px;object-fit:cover;" alt="{{ $item->title }}">
                @else
                    <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height:160px;">
                        <span class="text-white fw-bold">VIDEO</span>
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
                <div class="card-body text-center text-muted py-5">No media found.</div>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $media->links() }}
</div>
@endsection
