@extends('admin.layouts.app')

@section('page-title', 'Add Donor')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.donors.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select">
                    <option value="">None (General Donation)</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" @selected(old('event_id') == $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Donation Type</label>
                    <input type="text" name="donation_type" class="form-control" value="{{ old('donation_type') }}" placeholder="e.g. Tithe, Offering, Partnership">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Amount (KES)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="mpesa">M-Pesa</option>
                        <option value="cash">Cash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" class="form-check-input" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                <label for="is_anonymous" class="form-check-label">Anonymous Donation</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_public" id="is_public" class="form-check-input" value="1" {{ old('is_public') ? 'checked' : '' }}>
                <label for="is_public" class="form-check-label">Show on public website</label>
            </div>
            <button type="submit" class="btn btn-primary">Save Donor</button>
            <a href="{{ route('admin.donors.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
