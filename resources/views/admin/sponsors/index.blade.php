@extends('admin.layouts.app')

@section('page-title', 'Sponsors')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Sponsors & Partners</h2>
    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">Add Sponsor</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Tier</th>
                        <th>Pledged</th>
                        <th>Received</th>
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sponsors as $sponsor)
                        <tr>
                            <td>{{ $sponsor->event->title ?? '—' }}</td>
                            <td>{{ $sponsor->name }}</td>
                            <td>{{ $sponsor->tier ?? '—' }}</td>
                            <td>{{ number_format($sponsor->pledged_amount, 2) }}</td>
                            <td>{{ number_format($sponsor->received_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $sponsor->is_public ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $sponsor->is_public ? 'Public' : 'Private' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sponsor?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No sponsors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
