@extends('admin.layouts.app')

@section('page-title', 'Edit Volunteer')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.volunteers.update', $volunteer) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select">
                    <option value="">None (General Volunteer)</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected($volunteer->event_id == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $volunteer->full_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $volunteer->phone) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $volunteer->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control" value="{{ old('role', $volunteer->role) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Shift</label>
                    <input type="text" name="shift" class="form-control" value="{{ old('shift', $volunteer->shift) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Skills (comma separated)</label>
                    <input type="text" name="skills" class="form-control" value="{{ old('skills', $volunteer->skills ? implode(', ', $volunteer->skills) : '') }}">
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $volunteer->notes) }}</textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_confirmed" id="is_confirmed" class="form-check-input" value="1" {{ $volunteer->is_confirmed ? 'checked' : '' }}>
                <label for="is_confirmed" class="form-check-label">Confirmed</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Volunteer</button>
            <a href="{{ route('admin.volunteers.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
