<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Gospel Kings Band</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --gk-red: #a12224; --gk-green: #126149; }
        body { background: linear-gradient(135deg, var(--gk-red), var(--gk-green)); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: Inter, system-ui, sans-serif; }
        .login-card { background: #fff; border-radius: 12px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
        .brand-mark { width: 48px; height: 48px; border-radius: 10px; display: inline-grid; place-items: center; color: #fff; background: linear-gradient(135deg, var(--gk-red), var(--gk-green)); font-weight: 800; font-size: 1.1rem; }
        .btn-primary { --bs-btn-bg: var(--gk-red); --bs-btn-border-color: var(--gk-red); --bs-btn-hover-bg: #7f1b1d; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-mark mb-2">GK</div>
            <h3 class="h5 mb-0">Gospel Kings Band</h3>
            <p class="text-muted small">Admin Login</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
