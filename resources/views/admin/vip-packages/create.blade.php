@extends('admin.layouts.app')

@section('page-title', 'Create VIP Package')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.vip-packages.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select" required>
                    <option value="">Select event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Package Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Amount (KES)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Benefits (JSON)</label>
                    <input type="text" name="benefits" class="form-control" value="{{ old('benefits') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Package</button>
            <a href="{{ route('admin.vip-packages.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
