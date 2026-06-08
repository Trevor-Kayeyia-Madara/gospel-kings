@extends('admin.layouts.app')

@section('page-title', 'Events')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">All Events</h2>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Create Event</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Edition</th>
                        <th>Starts</th>
                        <th>Venue</th>
                        <th>Paid</th>
                        <th>Registrations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td class="fw-bold">{{ $event->title }}</td>
                            <td>{{ $event->edition ?? '—' }}</td>
                            <td>{{ $event->starts_at?->format('M d, Y H:i') }}</td>
                            <td>{{ $event->venue }} {{ $event->city ? '· '.$event->city : '' }}</td>
                            <td>
                                <span class="badge {{ $event->is_paid ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $event->is_paid ? 'KES '.number_format($event->base_price, 2) : 'Free' }}
                                </span>
                            </td>
                            <td>{{ $event->registrations_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary" target="_blank">View</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No events yet. Create your first event.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
