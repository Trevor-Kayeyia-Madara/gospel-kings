@extends('admin.layouts.app')

@section('page-title', 'Add Guest Minister')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.guest-ministers.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select">
                    <option value="">None (General)</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role / Title</label>
                <input type="text" name="role" class="form-control" value="{{ old('role') }}">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_public" id="is_public" class="form-check-input" value="1" {{ old('is_public') ? 'checked' : '' }}>
                <label for="is_public" class="form-check-label">Visible on public website</label>
            </div>
            <button type="submit" class="btn btn-primary">Save Minister</button>
            <a href="{{ route('admin.guest-ministers.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
