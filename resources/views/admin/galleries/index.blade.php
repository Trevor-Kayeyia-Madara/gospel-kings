@extends('admin.layouts.app')

@section('page-title', 'Galleries')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Galleries</h2>
    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">Create Gallery</a>
</div>

<div class="row g-3">
    @forelse ($galleries as $gallery)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $gallery->title }}</h5>
                    <p class="card-text text-muted small">{{ $gallery->event->title ?? 'General Gallery' }}</p>
                    <p class="card-text">{{ $gallery->description ?? 'No description' }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-secondary">{{ $gallery->mediaFiles->count() }} items</span>
                        <div>
                            <a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this gallery and all media?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <p>No galleries created yet.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">Create your first gallery</a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
