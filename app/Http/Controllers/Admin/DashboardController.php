<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Film;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalBookings = Booking::count();
        $totalTicketsSold = Booking::sum('total_seats');
        $totalFilms = Film::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        // Sales statistics for chart (last 7 days)
        $salesData = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_bookings'),
            DB::raw('SUM(total_seats) as tickets_sold'),
            DB::raw('SUM(CASE WHEN status = "confirmed" THEN total_price ELSE 0 END) as revenue')
        )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing dates
        $dates = [];
        $bookingsChart = [];
        $ticketsChart = [];
        $revenueChart = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = now()->subDays($i)->format('d M');
            $dayData = $salesData->firstWhere('date', $date);
            $bookingsChart[] = $dayData ? $dayData->total_bookings : 0;
            $ticketsChart[] = $dayData ? $dayData->tickets_sold : 0;
            $revenueChart[] = $dayData ? (float) $dayData->revenue : 0;
        }

        // Top films by bookings
        $topFilms = Film::withCount(['schedules' => function ($query) {
            $query->join('bookings', 'schedules.id', '=', 'bookings.schedule_id')
                   ->select('schedules.id');
        }])->orderBy('schedules_count', 'desc')->take(5)->get();

        // Recent bookings
        $recentBookings = Booking::with(['schedule.film', 'seats'])
            ->latest()
            ->take(10)
            ->get();

        // Monthly revenue for last 6 months
        $monthlyRevenue = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(CASE WHEN status = "confirmed" THEN total_price ELSE 0 END) as revenue')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $months = [];
        $monthlyRevenueData = [];
        $monthlyTicketsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            $monthData = $monthlyRevenue->firstWhere(function ($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });
            $monthlyRevenueData[] = $monthData ? (float) $monthData->revenue : 0;
            
            $tickets = Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_seats');
            $monthlyTicketsData[] = $tickets;
        }

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalTicketsSold',
            'totalFilms',
            'totalCustomers',
            'totalRevenue',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'dates',
            'bookingsChart',
            'ticketsChart',
            'revenueChart',
            'topFilms',
            'recentBookings',
            'months',
            'monthlyRevenueData',
            'monthlyTicketsData'
        ));
    }
}