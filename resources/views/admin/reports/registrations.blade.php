@extends('admin.layouts.app')

@section('page-title', 'Registrations Report')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Registrations Report</h2>
    <a href="{{ route('admin.reports.registrations.export') }}" class="btn btn-success">Export CSV</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reg Number</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th>Package</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $reg)
                        <tr>
                            <td class="fw-bold">{{ $reg->registration_number }}</td>
                            <td>{{ $reg->full_name }}</td>
                            <td>{{ $reg->phone }}</td>
                            <td>{{ $reg->event->title ?? '—' }}</td>
                            <td>{{ $reg->vipPackage->name ?? 'Free' }}</td>
                            <td><span class="badge bg-secondary">{{ $reg->registration_type }}</span></td>
                            <td><span class="badge {{ $reg->status === 'confirmed' ? 'bg-success' : ($reg->status === 'payment_pending' ? 'bg-warning' : 'bg-secondary') }}">{{ $reg->status }}</span></td>
                            <td>{{ $reg->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No registrations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
