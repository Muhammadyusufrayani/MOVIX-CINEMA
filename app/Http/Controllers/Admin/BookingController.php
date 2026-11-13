<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with([
            'schedule.film',
            'seats'
        ])->latest();

        // Pencarian pemesanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter film
        if ($request->filled('film_id')) {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->where('film_id', $request->film_id);
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Statistics
        $totalBooking = Booking::count();
        $totalConfirmed = Booking::where('status', 'confirmed')->count();
        $totalPending = Booking::where('status', 'pending')->count();
        $totalCancelled = Booking::where('status', 'cancelled')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
        $totalTicketsSold = Booking::sum('total_seats');

        $films = \App\Models\Film::all();

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBooking',
            'totalConfirmed',
            'totalPending',
            'totalCancelled',
            'totalRevenue',
            'totalTicketsSold',
            'films'
        ));
    }

    public function show(Booking $booking)
    {
        $booking->load(['schedule.film', 'seats']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($validated);

        return back()->with('success', 'Status pemesanan telah diperbarui.');
    }

    public function qrCode(Booking $booking)
    {
        $booking->load(['schedule.film', 'seats']);
        return view('admin.bookings.qr', compact('booking'));
    }
}