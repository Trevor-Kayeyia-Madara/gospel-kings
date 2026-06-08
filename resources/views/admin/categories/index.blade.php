@extends('admin.layouts.app')

@section('page-title', 'Categories')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Event Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create Category</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Events</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="fw-bold">{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->events->count() }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
