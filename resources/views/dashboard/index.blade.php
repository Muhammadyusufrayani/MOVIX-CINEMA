@extends('layouts.customer')
@section('title', 'Dashboard Pelanggan - MOVIX CINEMA')
@section('content')
<div class="container">
    <h1>Halo, {{ auth()->user()->name }}!</h1>
    <p class="muted">Selamat datang di dashboard pelanggan MOVIX CINEMA. Berikut ringkasan pemesanan tiket Anda.</p>

    <section class="stats">
        <div class="stat"><span class="muted">Total Pemesanan</span><strong>{{ $totalPesanan }}</strong></div>
        <div class="stat"><span class="muted">Menunggu Pembayaran</span><strong>{{ $menungguPembayaran }}</strong></div>
        <div class="stat"><span class="muted">Tiket Berhasil</span><strong>{{ $pesananBerhasil }}</strong></div>
    </section>

    <section class="panel">
        <h2>Riwayat Pemesanan</h2>
        <p class="muted">Daftar pesanan yang tercatat pada akun Anda.</p>
        <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Kode Booking</th><th>Film</th><th>Jadwal</th><th>Tiket</th><th>Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @forelse ($pesanan as $item)
                    <tr>
                        <td>{{ $item->kode_booking ?? ('MOVIX-'.$item->id) }}</td>
                        <td>{{ $item->jadwal?->film?->judul ?? 'Film tidak tersedia' }}</td>
                        <td>{{ $item->jadwal?->tanggal ?? '-' }} {{ $item->jadwal?->jam_mulai ?? '' }}</td>
                        <td>{{ $item->jumlah_tiket }}</td>
                        <td>Rp {{ number_format((float) $item->total_harga, 0, ',', '.') }}</td>
                        <td><span class="pill">{{ ucfirst(str_replace('_', ' ', $item->status ?? 'diproses')) }}</span></td>
                        <td><a class="btn" href="{{ route('customer.orders.show', $item->id) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;padding:28px">Belum ada pemesanan. Silakan pilih film dari halaman beranda.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px">{{ $pesanan->links() }}</div>
    </section>
</div>
@endsection
