@extends('admin.layouts.app')

@section('page-title', 'Edit Announcement')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Excerpt</label>
                <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt', $announcement->excerpt) }}" maxlength="500">
            </div>
            <div class="mb-3">
                <label class="form-label">Body</label>
                <textarea name="body" class="form-control" rows="6" required>{{ old('body', $announcement->body) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Publish Date</label>
                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
