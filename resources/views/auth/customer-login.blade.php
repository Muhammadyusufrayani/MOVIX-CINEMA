@extends('layouts.customer')
@section('title', 'Login Pelanggan - MOVIX CINEMA')
@section('content')
<div class="auth-wrap"><div class="auth-card">
    <h1>Masuk ke MOVIX</h1><p class="muted">Login untuk melihat dan mengelola tiket bioskop Anda.</p>
    @if ($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        <label for="email">Email</label><input class="field" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        <label for="password">Password</label><input class="field" id="password" type="password" name="password" required>
        <label style="font-weight:normal"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
        <p><button class="btn" type="submit">Masuk</button></p>
    </form>
    <p class="muted">Belum punya akun? <a href="{{ route('customer.register') }}">Daftar sekarang</a></p>
</div></div>
@endsection
