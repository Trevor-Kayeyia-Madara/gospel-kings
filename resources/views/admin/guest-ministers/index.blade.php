@extends('admin.layouts.app')

@section('page-title', 'Guest Ministers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Guest Ministers</h2>
    <a href="{{ route('admin.guest-ministers.create') }}" class="btn btn-primary">Add Minister</a>
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
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ministers as $minister)
                        <tr>
                            <td>{{ $minister->event->title ?? '—' }}</td>
                            <td>{{ $minister->name }}</td>
                            <td>{{ $minister->role ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $minister->is_public ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $minister->is_public ? 'Public' : 'Private' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.guest-ministers.edit', $minister) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.guest-ministers.destroy', $minister) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this minister?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No guest ministers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
