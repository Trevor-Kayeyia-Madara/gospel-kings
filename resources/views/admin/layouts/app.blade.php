<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Gospel Kings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --gk-ink: #0D0D0D;
            --gk-muted: #4a4a4a;
            --gk-line: #e0e0e0;
            --gk-red: #D97A07;
            --gk-green: #126149;
            --gk-gold: #F2CB05;
            --gk-gold-dark: #F2B705;
            --gk-soft: #F2F2F2;
            --sidebar-width: 260px;
        }
        body { background: var(--gk-soft); color: var(--gk-ink); font-family: Inter, system-ui, sans-serif; }
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-width); background: #0D0D0D; color: #e6e6e6; padding-top: 56px; overflow-y: auto; z-index: 1040; border-right: 1px solid #1f1f1f; }
        .sidebar a { color: #b8b8b8; text-decoration: none; padding: 10px 20px; display: block; font-size: .95rem; }
        .sidebar a:hover, .sidebar a.active { color: var(--gk-gold); background: #1a1a1a; }
        .sidebar .brand { position: fixed; top: 0; left: 0; width: var(--sidebar-width); height: 56px; background: #0D0D0D; border-bottom: 1px solid var(--gk-gold-dark); display: flex; align-items: center; padding: 0 20px; font-weight: 700; color: #fff; z-index: 1050; }
        .main { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid var(--gk-line); padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1030; }
        .content { padding: 24px; }
        .card { border: 1px solid var(--gk-line); border-radius: 8px; background: #fff; }
        .btn-primary { --bs-btn-bg: var(--gk-gold); --bs-btn-border-color: var(--gk-gold); --bs-btn-hover-bg: var(--gk-gold-dark); --bs-btn-hover-border-color: var(--gk-gold-dark); --bs-btn-color: #0D0D0D; border-radius: 8px; font-weight: 600; }
        .btn-success { --bs-btn-bg: var(--gk-green); --bs-btn-border-color: var(--gk-green); border-radius: 8px; }
        .btn-outline-primary { --bs-btn-color: var(--gk-gold-dark); border-color: var(--gk-gold-dark); }
        .btn-outline-primary:hover { --bs-btn-bg: var(--gk-gold); --bs-btn-color: #0D0D0D; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">
            <span class="brand-mark me-2" style="width:30px;height:30px;border-radius:6px;display:inline-grid;place-items:center;color:#0D0D0D;background:var(--gk-gold);font-weight:800;font-size:.85rem;">GK</span>
            Gospel Kings
        </div>
        <div class="pt-3">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">Content</div>
            <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">Announcements</a>
            <a href="{{ route('admin.sponsors.index') }}" class="{{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">Sponsors</a>
            <a href="{{ route('admin.guest-ministers.index') }}" class="{{ request()->routeIs('admin.guest-ministers.*') ? 'active' : '' }}">Guest Ministers</a>
            <a href="{{ route('admin.galleries.index') }}" class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">Galleries</a>
            <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">Media Library</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">Events</div>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.index') ? 'active' : '' }}">Manage Events</a>
            <a href="{{ route('admin.events.create') }}" class="{{ request()->routeIs('admin.events.create') ? 'active' : '' }}">Create Event</a>
            <a href="{{ route('admin.check-in.index') }}" class="{{ request()->routeIs('admin.check-in.*') ? 'active' : '' }}">Check-In</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">Settings</div>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
            <a href="{{ route('admin.vip-packages.index') }}" class="{{ request()->routeIs('admin.vip-packages.*') ? 'active' : '' }}">VIP Packages</a>
            <a href="{{ route('admin.volunteers.index') }}" class="{{ request()->routeIs('admin.volunteers.*') ? 'active' : '' }}">Volunteers</a>
            <a href="{{ route('admin.donors.index') }}" class="{{ request()->routeIs('admin.donors.*') ? 'active' : '' }}">Donors</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">People</div>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users & Roles</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">Reports</div>
            <a href="{{ route('admin.reports.registrations') }}" class="{{ request()->routeIs('admin.reports.registrations') ? 'active' : '' }}">Registrations</a>
            <a href="{{ route('admin.reports.finance') }}" class="{{ request()->routeIs('admin.reports.finance') ? 'active' : '' }}">Finance</a>

            <div class="text-uppercase text-muted small fw-bold px-3 pt-3 pb-1">Account</div>
            <a href="{{ route('home') }}">View Website</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link p-0 text-start" style="width:100%;text-align:left;padding:10px 20px;color:#e57373;">Logout</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <h1 class="h5 mb-0">@yield('page-title', 'Dashboard')</h1>
            <div class="small text-muted">{{ auth()->user()?->name }}</div>
        </div>
        <div class="content">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
