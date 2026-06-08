<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --gk-ink: #0D0D0D;
            --gk-muted: #4a4a4a;
            --gk-line: #e0e0e0;
            --gk-red: #D97A07;
            --gk-green: #0D0D0D;
            --gk-gold: #F2CB05;
            --gk-soft: #F2F2F2;
            --gk-gold-dark: #F2B705;
        }

        body {
            color: var(--gk-ink);
            background: #fff;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .navbar {
            border-bottom: 1px solid var(--gk-line);
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(12px);
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: inline-grid;
            place-items: center;
            color: #0D0D0D;
            background: var(--gk-gold);
            font-weight: 800;
        }

        .hero {
            min-height: calc(100vh - 86px);
            display: flex;
            align-items: center;
            background:
                linear-gradient(90deg, rgba(13, 13, 13, .82), rgba(13, 13, 13, .5), rgba(13, 13, 13, .2)),
                url("https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1800&q=80") center/cover;
            color: #fff;
        }

        .section {
            padding: 72px 0;
        }

        .section-soft {
            background: var(--gk-soft);
        }

        .eyebrow {
            color: var(--gk-gold-dark);
            font-size: .8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .btn-primary {
            --bs-btn-bg: var(--gk-gold);
            --bs-btn-border-color: var(--gk-gold);
            --bs-btn-hover-bg: var(--gk-gold-dark);
            --bs-btn-hover-border-color: var(--gk-gold-dark);
            --bs-btn-color: #0D0D0D;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-outline-light,
        .btn-outline-dark {
            border-radius: 8px;
        }

        .content-card {
            border: 1px solid var(--gk-line);
            border-radius: 8px;
            background: #fff;
        }

        .metric {
            border-left: 4px solid var(--gk-gold-dark);
            background: #fff;
            border-radius: 8px;
            padding: 18px;
        }

        .muted {
            color: var(--gk-muted);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            min-height: 46px;
        }

        footer {
            background: #0D0D0D;
            color: #d6d6d6;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
                <span class="brand-mark">GK</span>
                <span>Gospel Kings Band</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="mainNav" class="collapse navbar-collapse">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                    <a class="nav-link" href="{{ route('david-kasika') }}">David Kasika</a>
                    <a class="nav-link" href="{{ route('events.index') }}">Events</a>
                    <a class="nav-link" href="{{ route('sponsors.index') }}">Sponsors</a>
                    <a class="nav-link" href="{{ route('galleries.index') }}">Gallery</a>
                    <a class="btn btn-primary ms-lg-2" href="{{ route('events.index') }}">Register</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="py-5">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-3">
            <div>
                <div class="fw-bold text-white">Gospel Kings Band Digital Platform</div>
                <div class="small">Website, events, registrations, ticketing, communication, and reporting.</div>
            </div>
            <div class="small">Prepared by Invodtech Ltd</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
