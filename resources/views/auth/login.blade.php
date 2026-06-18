@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h4 class="mb-3">Masuk</h4>
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
                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <button class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="mt-3 mb-0 small">
                Belum punya akun peserta? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
            <p class="mt-2 mb-0 small text-muted">
                Akun petugas BPA default: <code>admin@bpa.telkomuniversity.ac.id</code> / <code>password123</code>
            </p>
        </div>
    </div>
</div>
@endsection