@extends('layouts.customer')
@section('title', 'Daftar Pelanggan - MOVIX CINEMA')
@section('content')
<div class="auth-wrap"><div class="auth-card">
    <h1>Buat Akun MOVIX</h1><p class="muted">Daftar sebagai pelanggan untuk memesan tiket.</p>
    @if ($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('customer.register.submit') }}">
        @csrf
        <label for="name">Nama lengkap</label><input class="field" id="name" name="name" value="{{ old('name') }}" required>
        <label for="email">Email</label><input class="field" id="email" type="email" name="email" value="{{ old('email') }}" required>
        <label for="password">Password (minimal 8 karakter)</label><input class="field" id="password" type="password" name="password" required>
        <label for="password_confirmation">Ulangi password</label><input class="field" id="password_confirmation" type="password" name="password_confirmation" required>
        <button class="btn" type="submit">Daftar sebagai Pelanggan</button>
    </form>
    <p class="muted">Sudah punya akun? <a href="{{ route('customer.login') }}">Login</a></p>
</div></div>
@endsection
