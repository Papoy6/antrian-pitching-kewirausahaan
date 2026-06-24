<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Antrian Pitching Kewirausahaan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --app-bg: #f4f7fb;
            --app-ink: #102033;
            --app-muted: #667085;
            --app-primary: #2563eb;
            --app-primary-dark: #1d4ed8;
            --app-accent: #14b8a6;
            --app-card: rgba(255, 255, 255, .92);
            --app-border: rgba(148, 163, 184, .28);
            --app-shadow: 0 18px 50px rgba(15, 23, 42, .09);
        }

        * { letter-spacing: -.01em; }

        body {
            min-height: 100vh;
            color: var(--app-ink);
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, .16), transparent 34rem),
                radial-gradient(circle at top right, rgba(20, 184, 166, .18), transparent 30rem),
                linear-gradient(180deg, #eef4ff 0%, var(--app-bg) 38%, #f8fafc 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(148, 163, 184, .12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, .12) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.55), transparent 72%);
        }

        .navbar.app-navbar {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 58%, #0f766e 100%);
            box-shadow: 0 18px 44px rgba(15, 23, 42, .18);
        }

        .navbar.app-navbar .container { min-height: 4.5rem; }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-weight: 800;
        }

        .navbar-brand i {
            display: inline-grid;
            width: 2.25rem;
            height: 2.25rem;
            place-items: center;
            border-radius: .85rem;
            background: rgba(255, 255, 255, .16);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .18);
        }

        .app-navbar .nav-link {
            border-radius: 999px;
            padding: .45rem .85rem;
            opacity: .86;
            transition: .2s ease;
        }

        .app-navbar .nav-link:hover,
        .app-navbar .nav-link.fw-bold {
            background: rgba(255, 255, 255, .16);
            opacity: 1;
            text-decoration: none !important;
        }

        .container.pb-5 { position: relative; padding-top: .35rem; }

        .container.pb-5 > h3,
        .container.pb-5 > h4,
        .container.pb-5 > .d-flex h4 {
            font-weight: 800;
            color: var(--app-ink);
        }

        .container.pb-5 > h3::after,
        .container.pb-5 > h4::after {
            content: "";
            display: block;
            width: 4.5rem;
            height: .3rem;
            margin-top: .75rem;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--app-primary), var(--app-accent));
        }

        .card {
            overflow: hidden;
            border: 1px solid var(--app-border);
            border-radius: 1.15rem;
            background: var(--app-card);
            box-shadow: var(--app-shadow);
            backdrop-filter: blur(16px);
        }

        .card h4, .card h5, .card h6 {
            font-weight: 800;
            color: var(--app-ink);
        }

        .text-muted { color: var(--app-muted) !important; }

        .btn {
            border-radius: .85rem;
            font-weight: 700;
            box-shadow: none !important;
        }

        .btn-sm { border-radius: .7rem; font-weight: 700; }

        .btn-primary {
            border-color: var(--app-primary);
            background: linear-gradient(135deg, var(--app-primary), var(--app-primary-dark));
        }

        .btn-primary:hover {
            border-color: #1e40af;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-1px);
        }

        .btn-success {
            border-color: #059669;
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .btn-danger {
            border-color: #dc2626;
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-success,
        .btn-outline-danger,
        .btn-outline-light { background: rgba(255, 255, 255, .62); }

        .form-control, .form-select {
            min-height: 2.85rem;
            border-color: rgba(148, 163, 184, .55);
            border-radius: .9rem;
            background-color: rgba(255, 255, 255, .9);
        }

        .form-control:focus, .form-select:focus {
            border-color: rgba(37, 99, 235, .78);
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .13);
        }

        .form-label { font-weight: 700; color: #344054; }

        .table { --bs-table-bg: transparent; margin-bottom: .75rem; }

        .table thead th {
            color: #475467;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            border-bottom-color: rgba(148, 163, 184, .36);
        }

        .table tbody td { border-color: rgba(148, 163, 184, .22); }

        .badge { border-radius: 999px; font-weight: 800; }
        .badge-status { font-size: .82rem; }

        .alert {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .07);
        }

        a { color: var(--app-primary-dark); font-weight: 700; }
        hr { border-color: rgba(148, 163, 184, .35); opacity: 1; }

        code {
            border-radius: .45rem;
            padding: .1rem .35rem;
            color: #1e40af;
            background: #eff6ff;
        }

        @media (max-width: 991.98px) {
            .navbar.app-navbar .container { gap: 1rem; }
            .app-navbar .navbar-nav { flex-wrap: wrap; margin-left: 0 !important; }
            .app-navbar .d-flex.align-items-center {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->check() ? route('peserta.dashboard') : route('login')) }}">
            <i class="bi bi-people-fill"></i> Antrian Pitching Kewirausahaan
        </a>

        @auth
        @if(auth()->user()->isAdmin())
        <ul class="navbar-nav flex-row gap-3 me-auto ms-4">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold text-decoration-underline' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.antrean') ? 'fw-bold text-decoration-underline' : '' }}" href="{{ route('admin.antrean') }}">Antrean Verifikasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.konfirmasi') ? 'fw-bold text-decoration-underline' : '' }}" href="{{ route('admin.konfirmasi') }}">Menunggu Konfirmasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.jadwal.*') ? 'fw-bold text-decoration-underline' : '' }}" href="{{ route('admin.jadwal.index') }}">Kelola Jadwal</a>
            </li>
        </ul>
        @endif
        <div class="d-flex align-items-center">
            <span class="text-white me-3 small">
                {{ auth()->user()->name }} &middot; {{ auth()->user()->isAdmin() ? 'Petugas BPA' : 'Peserta' }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-light">Keluar</button>
            </form>
        </div>
        @endauth
    </div>
</nav>

<div class="container pb-5">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
