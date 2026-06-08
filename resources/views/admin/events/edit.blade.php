@extends('admin.layouts.app')

@section('page-title', 'Edit Event')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.update', $event) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Event Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Edition</label>
                    <input type="text" name="edition" class="form-control" value="{{ old('edition', $event->edition) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Theme</label>
                    <input type="text" name="theme" class="form-control" value="{{ old('theme', $event->theme) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Summary</label>
                    <textarea name="summary" class="form-control" rows="2" required>{{ old('summary', $event->summary) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control" value="{{ old('venue', $event->venue) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $event->city) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Starts At</label>
                    <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ends At</label>
                    <input type="datetime-local" name="ends_at" class="form-control" value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $event->capacity) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Base Price (KES)</label>
                    <input type="number" step="0.01" name="base_price" class="form-control" value="{{ old('base_price', $event->base_price) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Banner Image URL</label>
                    <input type="text" name="banner_image" class="form-control" value="{{ old('banner_image', $event->banner_image) }}">
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4">
                        <input type="checkbox" name="is_paid" id="is_paid" class="form-check-input" value="1" {{ $event->is_paid ? 'checked' : '' }}>
                        <label for="is_paid" class="form-check-label">Paid Event</label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="registration_open" id="registration_open" class="form-check-input" value="1" {{ $event->registration_open ? 'checked' : '' }}>
                        <label for="registration_open" class="form-check-label">Registration Open</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Schedule (JSON)</label>
                    <textarea name="schedule" class="form-control" rows="3">{{ old('schedule', $event->schedule ? json_encode($event->schedule) : '') }}</textarea>
                    <div class="form-text">Example: [{"time":"09:00","item":"Opening"},{"time":"10:00","item":"Session 1"}]</div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Event</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
