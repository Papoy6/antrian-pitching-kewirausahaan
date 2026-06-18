<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Antrian Pitching Kewirausahaan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color: #f5f7fb; }
        .navbar-brand { font-weight: 600; }
        .badge-status { font-size: .8rem; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: .6rem; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->check() ? route('peserta.dashboard') : route('login')) }}">
            <i class="bi bi-people-fill"></i> Antrian Pitching Kewirausahaan
        </a>
        @auth
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