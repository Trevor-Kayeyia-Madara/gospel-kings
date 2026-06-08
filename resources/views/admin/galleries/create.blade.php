@extends('admin.layouts.app')

@section('page-title', 'Create Gallery')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.galleries.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select">
                    <option value="">None (General Gallery)</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Gallery Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug (optional)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            </div>
            <button type="submit" class="btn btn-primary">Create Gallery</button>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
