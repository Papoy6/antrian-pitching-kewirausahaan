@extends('layouts.app')
@section('title', 'Masuk')

@push('styles')
<style>
    .login-shell {
        min-height: calc(100vh - 9rem);
        display: grid;
        align-items: center;
        padding: 1.5rem 0 3rem;
    }

    .login-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, .26);
        border-radius: 1.45rem;
        background:
            linear-gradient(145deg, rgba(255,255,255,.96), rgba(255,255,255,.88)),
            radial-gradient(circle at 10% 0%, rgba(37,99,235,.12), transparent 22rem);
        box-shadow: 0 24px 70px rgba(15, 23, 42, .13);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .login-card:hover {
        transform: translateY(-4px);
        border-color: rgba(37, 99, 235, .34);
        box-shadow: 0 30px 86px rgba(15, 23, 42, .16);
    }

    .login-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto;
        height: .42rem;
        background: linear-gradient(90deg, #2563eb, #14b8a6);
    }

    .brand-mark {
        width: 3.35rem;
        height: 3.35rem;
        display: grid;
        place-items: center;
        margin: 0 auto 1rem;
        border-radius: 1.1rem;
        color: #ffffff;
        font-size: 1.35rem;
        background: linear-gradient(135deg, #2563eb, #0f766e);
        box-shadow: 0 14px 30px rgba(37, 99, 235, .28);
    }

    .login-title {
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .login-subtitle {
        max-width: 25rem;
        margin: .45rem auto 0;
        color: #667085;
    }

    .login-card .form-control {
        padding-left: 1rem;
        border-radius: 1rem;
        transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .login-card .form-control:focus {
        transform: translateY(-1px);
    }

    .login-card .btn {
        min-height: 3rem;
        border-radius: 1rem;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .login-card .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(37, 99, 235, .22) !important;
    }

    .admin-hint {
        border: 1px dashed rgba(37, 99, 235, .25);
        border-radius: 1rem;
        padding: .8rem .9rem;
        background: rgba(239, 246, 255, .7);
    }
</style>
@endpush

@section('content')
<div class="login-shell">
    <div class="row justify-content-center w-100 mx-0">
        <div class="col-md-7 col-lg-5 col-xl-4">
            <div class="card login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="brand-mark">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                    <h4 class="login-title mb-0">Masuk ke Sistem</h4>
                    <p class="login-subtitle small">Kelola antrean pitching kewirausahaan dengan tampilan yang lebih rapi dan nyaman.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                        <div class="form-check mb-0">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Masuk</button>
                </form>

                <p class="mt-4 mb-0 small text-center">
                    Belum punya akun peserta? <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
                <div class="admin-hint mt-3 small text-muted">
                    Akun petugas BPA default:
                    <div class="mt-1"><code>admin@bpa.telkomuniversity.ac.id</code> / <code>password123</code></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
