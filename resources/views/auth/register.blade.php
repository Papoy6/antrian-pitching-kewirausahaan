@extends('layouts.app')
@section('title', 'Daftar Peserta')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h4 class="mb-3">Daftar Akun Peserta</h4>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Ketua Kelompok</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Daftar</button>
            </form>
            <p class="mt-3 mb-0 small">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection