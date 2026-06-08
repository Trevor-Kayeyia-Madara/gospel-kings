@extends('admin.layouts.app')

@section('page-title', 'Finance Report')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Finance Report</h2>
    <a href="{{ route('admin.reports.finance.export') }}" class="btn btn-success">Export CSV</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Total Payments</div>
            <div class="h3 mb-0">KES {{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Pending</div>
            <div class="h3 mb-0 text-warning">KES {{ number_format($payments->where('status', 'pending')->sum('amount'), 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Donations</div>
            <div class="h3 mb-0">KES {{ number_format($donors->sum('amount'), 2) }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Payment ID</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Receipt</th>
                        <th>Attendee</th>
                        <th>Event</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>KES {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst($payment->method) }}</td>
                            <td><span class="badge {{ $payment->status === 'completed' ? 'bg-success' : ($payment->status === 'pending' ? 'bg-warning' : 'bg-secondary') }}">{{ $payment->status }}</span></td>
                            <td>{{ $payment->receipt_number ?? '—' }}</td>
                            <td>{{ $payment->registration->full_name ?? '—' }}</td>
                            <td>{{ $payment->registration->event->title ?? '—' }}</td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No payments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
