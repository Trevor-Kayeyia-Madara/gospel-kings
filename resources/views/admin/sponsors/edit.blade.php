@extends('admin.layouts.app')

@section('page-title', 'Edit Sponsor')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sponsors.update', $sponsor) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select">
                    <option value="">None (General)</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected($sponsor->event_id == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $sponsor->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tier</label>
                <input type="text" name="tier" class="form-control" value="{{ old('tier', $sponsor->tier) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Logo URL</label>
                <input type="text" name="logo_path" class="form-control" value="{{ old('logo_path', $sponsor->logo_path) }}">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pledged Amount (KES)</label>
                    <input type="number" step="0.01" name="pledged_amount" class="form-control" value="{{ old('pledged_amount', $sponsor->pledged_amount) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Received Amount (KES)</label>
                    <input type="number" step="0.01" name="received_amount" class="form-control" value="{{ old('received_amount', $sponsor->received_amount) }}">
                </div>
            </div>
            <div class="form-check mb-3 mt-3">
                <input type="checkbox" name="is_public" id="is_public" class="form-check-input" value="1" {{ $sponsor->is_public ? 'checked' : '' }}>
                <label for="is_public" class="form-check-label">Visible on public website</label>
            </div>
            <button type="submit" class="btn btn-primary">Update Sponsor</button>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
