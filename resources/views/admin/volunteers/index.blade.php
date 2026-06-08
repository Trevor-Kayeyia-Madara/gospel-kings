@extends('admin.layouts.app')

@section('page-title', 'Volunteers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Volunteers</h2>
    <a href="{{ route('admin.volunteers.create') }}" class="btn btn-primary">Add Volunteer</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Shift</th>
                        <th>Confirmed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($volunteers as $volunteer)
                        <tr>
                            <td>{{ $volunteer->event->title ?? 'General' }}</td>
                            <td class="fw-bold">{{ $volunteer->full_name }}</td>
                            <td>{{ $volunteer->role ?? '—' }}</td>
                            <td>{{ $volunteer->phone }}</td>
                            <td>{{ $volunteer->shift ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $volunteer->is_confirmed ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $volunteer->is_confirmed ? 'Confirmed' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.volunteers.edit', $volunteer) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.volunteers.destroy', $volunteer) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this volunteer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No volunteers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
