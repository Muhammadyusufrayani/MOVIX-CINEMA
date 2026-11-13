<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Film;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $filmId = $request->input('film_id');
        $status = $request->input('status');

        $query = Booking::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->with(['schedule.film', 'seats']);

        if ($filmId) {
            $query->whereHas('schedule', function ($q) use ($filmId) {
                $q->where('film_id', $filmId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        // Summary statistics
        $totalBookings = (clone $query)->count();
        $totalTicketsSold = (clone $query)->sum('total_seats');
        $totalRevenue = (clone $query)->where('status', 'confirmed')->sum('total_price');
        $pendingBookings = (clone $query)->where('status', 'pending')->count();
        $confirmedBookings = (clone $query)->where('status', 'confirmed')->count();
        $cancelledBookings = (clone $query)->where('status', 'cancelled')->count();

        // Daily sales data for chart
        $dailySales = (clone $query)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as bookings'),
                DB::raw('SUM(CASE WHEN status = "confirmed" THEN total_price ELSE 0 END) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $films = Film::all();

        return view('admin.reports.index', compact(
            'bookings',
            'dateFrom',
            'dateTo',
            'filmId',
            'status',
            'totalBookings',
            'totalTicketsSold',
            'totalRevenue',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'dailySales',
            'films'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $filmId = $request->input('film_id');
        $status = $request->input('status');

        $query = Booking::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->with(['schedule.film', 'seats']);

        if ($filmId) {
            $query->whereHas('schedule', function ($q) use ($filmId) {
                $q->where('film_id', $filmId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        $totalRevenue = $bookings->where('status', 'confirmed')->sum('total_price');
        $totalTickets = $bookings->sum('total_seats');

        return view('admin.reports.pdf', compact('bookings', 'dateFrom', 'dateTo', 'totalRevenue', 'totalTickets'));
    }

    public function exportExcel(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $filmId = $request->input('film_id');
        $status = $request->input('status');

        $query = Booking::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->with(['schedule.film', 'seats']);

        if ($filmId) {
            $query->whereHas('schedule', function ($q) use ($filmId) {
                $q->where('film_id', $filmId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        $filename = 'laporan_movix_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['Kode Booking', 'Nama Pelanggan', 'Email', 'No. Telepon', 'Film', 'Studio', 'Tgl Tayang', 'Jam Tayang', 'Kursi', 'Jumlah Tiket', 'Harga Tiket', 'Total Harga', 'Metode', 'Status', 'Tgl Transaksi'];

        $callback = function () use ($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $seats = $booking->seats->pluck('seat_number')->implode(', ');
                $row = [
                    $booking->booking_code,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->customer_phone,
                    $booking->schedule->film->title ?? '-',
                    $booking->schedule->studio_name ?? '-',
                    $booking->schedule->date ?? '-',
                    $booking->schedule->time ?? '-',
                    $seats,
                    $booking->total_seats,
                    $booking->schedule->price ?? 0,
                    $booking->total_price,
                    $booking->payment_method ?? '-',
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s'),
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}