@extends('admin.layouts.app')

@section('page-title', 'Announcements')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Announcements</h2>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">Publish Announcement</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $announcement)
                        <tr>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ $announcement->published_at?->format('M d, Y') ?? 'Draft' }}</td>
                            <td>
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this announcement?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No announcements found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
