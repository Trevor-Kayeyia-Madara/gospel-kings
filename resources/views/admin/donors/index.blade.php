@extends('admin.layouts.app')

@section('page-title', 'Donors')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Donors & Giving</h2>
    <a href="{{ route('admin.donors.create') }}" class="btn btn-primary">Add Donor</a>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Total Donors</div>
            <div class="h2 mb-0">{{ $donors->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Total Amount</div>
            <div class="h2 mb-0 text-success">KES {{ number_format($donors->sum('amount'), 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Confirmed</div>
            <div class="h2 mb-0">{{ $donors->where('status', 'confirmed')->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Pending</div>
            <div class="h2 mb-0 text-warning">{{ $donors->where('status', 'pending')->count() }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Public</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($donors as $donor)
                        <tr>
                            <td>{{ $donor->event->title ?? 'General' }}</td>
                            <td class="fw-bold">{{ $donor->is_anonymous ? 'Anonymous' : $donor->full_name }}</td>
                            <td>{{ $donor->donation_type ?? '—' }}</td>
                            <td>{{ $donor->amount ? 'KES '.number_format($donor->amount, 2) : '—' }}</td>
                            <td>{{ ucfirst($donor->payment_method) }}</td>
                            <td>
                                <span class="badge {{ $donor->status === 'confirmed' ? 'bg-success' : ($donor->status === 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                    {{ $donor->status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $donor->is_public ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $donor->is_public ? 'Public' : 'Private' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.donors.edit', $donor) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.donors.destroy', $donor) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this donor?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No donors yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
