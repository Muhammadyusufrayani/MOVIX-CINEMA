@extends('layouts.customer')
@section('title', 'Detail Pesanan - MOVIX CINEMA')
@section('content')
<div class="container">
    <p><a href="{{ route('customer.dashboard') }}">← Kembali ke dashboard</a></p>
    <section class="panel" style="max-width:720px">
        <h1>Detail Pemesanan</h1>
        <p class="muted">Simpan kode booking ini sebagai referensi pemesanan Anda.</p>
        <p><strong>Kode Booking:</strong> {{ $pemesanan->kode_booking ?? ('MOVIX-'.$pemesanan->id) }}</p>
        <p><strong>Film:</strong> {{ $pemesanan->jadwal?->film?->judul ?? 'Film tidak tersedia' }}</p>
        <p><strong>Studio:</strong> {{ $pemesanan->jadwal?->studio ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $pemesanan->jadwal?->tanggal ?? '-' }}</p>
        <p><strong>Jam:</strong> {{ $pemesanan->jadwal?->jam_mulai ?? '-' }}</p>
        <p><strong>Jumlah tiket:</strong> {{ $pemesanan->jumlah_tiket }}</p>
        <p><strong>Total harga:</strong> Rp {{ number_format((float) $pemesanan->total_harga, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> <span class="pill">{{ ucfirst(str_replace('_', ' ', $pemesanan->status ?? 'diproses')) }}</span></p>
    </section>
</div>
@endsection
