@extends('admin.layouts.app')

@section('page-title', 'VIP Packages')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">VIP Packages</h2>
    <a href="{{ route('admin.vip-packages.create') }}" class="btn btn-primary">Create VIP Package</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Amount (KES)</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $package)
                        <tr>
                            <td>{{ $package->event->title ?? '—' }}</td>
                            <td>{{ $package->name }}</td>
                            <td>{{ number_format($package->amount, 2) }}</td>
                            <td>{{ $package->capacity ?? '∞' }}</td>
                            <td>
                                <a href="{{ route('admin.vip-packages.edit', $package) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.vip-packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this package?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No VIP packages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
