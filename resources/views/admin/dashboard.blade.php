@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Total Events</div>
            <div class="display-6 fw-bold">{{ $eventsCount }}</div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-outline-primary mt-2">Create Event</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Registrations</div>
            <div class="display-6 fw-bold">{{ $registrationsCount }}</div>
            <div class="small text-muted">{{ $confirmedCount }} confirmed</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Revenue (KES)</div>
            <div class="display-6 fw-bold text-success">{{ number_format($revenue, 2) }}</div>
            <div class="small text-muted">{{ $pendingPayments }} pending payments</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Check-Ins</div>
            <div class="display-6 fw-bold">{{ $checkInsCount }}</div>
            <a href="{{ route('admin.check-in.index') }}" class="btn btn-sm btn-outline-primary mt-2">Open Check-In</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">VIP Packages</div>
            <div class="h3 mb-0">{{ $vipPackagesCount }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">VIP Registrations</div>
            <div class="h3 mb-0 text-warning">{{ $vipRegistrations }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Free Registrations</div>
            <div class="h3 mb-0">{{ $freeRegistrations }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Media</div>
            <div class="h3 mb-0">{{ $mediaCount }}</div>
            <div class="small text-muted">{{ $galleriesCount }} galleries</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Guest Ministers</div>
            <div class="h3 mb-0">{{ $guestMinistersCount }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Sponsors</div>
            <div class="h3 mb-0">{{ $sponsorsCount }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Announcements</div>
            <div class="h3 mb-0">{{ $announcementsCount }}</div>
            <div class="small text-muted">{{ $publishedAnnouncements }} published, {{ $draftAnnouncements }} draft</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="text-muted small text-uppercase fw-bold">Pending</div>
            <div class="h3 mb-0 text-warning">{{ $pendingCount }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                Upcoming Events
                <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">New Event</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Event</th><th>Date</th><th>Registrations</th></tr></thead>
                    <tbody>
                        @forelse ($upcomingEvents as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->starts_at?->format('M d, Y') }}</td>
                                <td>{{ $event->registrations_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No upcoming events.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-bold">All Events</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Event</th><th>Registrations</th><th>Revenue</th></tr></thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->registrations_count }}</td>
                                <td>{{ number_format($event->payments->where('status', 'completed')->sum('amount'), 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No events yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header bg-white fw-bold">Latest Registrations</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Name</th><th>Event</th><th>Type</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse ($latestRegistrations as $reg)
                            <tr>
                                <td>{{ $reg->full_name }}</td>
                                <td>{{ $reg->event->title ?? '—' }}</td>
                                <td><span class="badge bg-secondary">{{ $reg->registration_type }}</span></td>
                                <td><span class="badge {{ $reg->status === 'confirmed' ? 'bg-success' : ($reg->status === 'payment_pending' ? 'bg-warning' : 'bg-secondary') }}">{{ $reg->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No registrations yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-bold">Quick Actions</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <a href="{{ route('admin.events.create') }}" class="btn btn-outline-primary w-100 mb-2">Create Event</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.vip-packages.create') }}" class="btn btn-outline-primary w-100 mb-2">Add VIP Package</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.announcements.create') }}" class="btn btn-outline-primary w-100 mb-2">Publish Announcement</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.galleries.create') }}" class="btn btn-outline-primary w-100 mb-2">New Gallery</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-outline-primary w-100 mb-2">Add Sponsor</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.check-in.index') }}" class="btn btn-outline-success w-100 mb-2">Check-In Station</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
