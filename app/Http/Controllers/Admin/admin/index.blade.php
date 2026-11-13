<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request; 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Movix Cinema</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            background: #181818;
            min-height: 100vh;
            color: white;
            padding: 25px 18px;
        }

        .brand {
            color: #e50914;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #e50914;
            color: white;
        }

        .content {
            padding: 30px;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 3px 12px #0000000d;
        }

        .stat-card h3 {
            font-weight: bold;
        }

        .table-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0000000d;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar">

            <div class="brand">
                MOVIX CINEMA
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="active">
                Dashboard
            </a>

            <a href="{{ route('admin.bookings.index') }}">
                Data Pemesanan
            </a>

            <a href="#">
                Data Film
            </a>

            <a href="#">
                Jadwal Film
            </a>

            <a href="#">
                Laporan Penjualan
            </a>

        </div>

        <!-- CONTENT -->
        <div class="col-md-10 content">

            <h2 class="fw-bold">
                Dashboard Admin
            </h2>

            <p class="text-muted">
                Selamat datang di panel Admin Movix Cinema.
            </p>

            <!-- STATISTIK -->
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="card stat-card">
                        <p>Total Pemesanan</p>
                        <h3>{{ $totalBooking }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <p class="text-success">
                            Pemesanan Confirmed
                        </p>
                        <h3>{{ $totalConfirmed }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <p class="text-warning">
                            Status Lainnya
                        </p>
                        <h3>{{ $totalOther }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <p>Total Pendapatan Confirmed</p>
                        <h3 style="font-size: 19px">
                            Rp {{ number_format(
                                $totalRevenue, 0, ',', '.'
                            ) }}
                        </h3>
                    </div>
                </div>

            </div>

            <!-- DATA PEMESANAN -->
            <div class="table-card">

                <h4 class="fw-bold mb-3">
                    Data Pemesanan Tiket
                </h4>

                <form method="GET"
                      action="{{ route('admin.bookings.index') }}"
                      class="row g-2 mb-4">

                    <div class="col-md-6">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari nama atau kode booking..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>

                            @foreach(
                                \App\Models\Booking::query()
                                ->select('status')
                                ->distinct()
                                ->pluck('status') as $status
                            )
                                <option value="{{ $status }}"
                                    @selected(request('status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-danger w-100">
                            Cari Data
                        </button>
                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode Booking</th>
                                <th>Nama Pelanggan</th>
                                <th>Film</th>
                                <th>Kursi</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($bookings as $booking)

                                <tr>
                                    <td>
                                        {{ $bookings->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        {{ $booking->booking_code }}
                                    </td>

                                    <td>
                                        {{ $booking->customer_name }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $booking->customer_email }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $booking->schedule?->film?->title ?? '-' }}
                                    </td>

                                    <td>
                                        @forelse($booking->seats as $seat)
                                            <span class="badge bg-secondary">
                                                {{ $seat->seat_number }}
                                            </span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>

                                    <td>
                                        Rp {{ number_format(
                                            $booking->total_price,
                                            0, ',', '.'
                                        ) }}
                                    </td>

                                    <td>
                                        <span class="badge
                                            {{ $booking->status == 'confirmed'
                                                ? 'bg-success'
                                                : 'bg-warning text-dark' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="text-center py-4">
                                        Belum ada pemesanan tiket.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{ $bookings->links() }}

            </div>

        </div>

    </div>
</div>

</body>
</html>