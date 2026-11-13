<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Halaman pemilihan kursi
    public function create($schedule_id)
    {
        $schedule = Schedule::with('film')->findOrFail($schedule_id);

        $bookedSeats = BookingSeat::where(
            'schedule_id',
            $schedule->id
        )->pluck('seat_number')->toArray();

        // Denah kursi A sampai H, masing-masing 8 kursi
        $rows = range('A', 'H');

        return view('bookings.create', compact(
            'schedule',
            'bookedSeats',
            'rows'
        ));
    }

    // Simpan pemesanan pelanggan
    public function store(Request $request, $schedule_id)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'selected_seats' => 'nullable|string',
        ]);

        $rawSelectedSeats = isset($validated['selected_seats']) ? (string) $validated['selected_seats'] : '';
        $seats = array_values(array_unique(array_filter(
            array_map('trim', explode(',', $rawSelectedSeats))
        )));

        if (count($seats) < 1 || count($seats) > 8) {
            throw ValidationException::withMessages([
                'seats_count' => 'Pilih minimal 1 dan maksimal 8 kursi.',
            ]);
        }

        foreach ($seats as $seat) {
            if (!preg_match('/^[A-H][1-8]$/', $seat)) {
                throw ValidationException::withMessages([
                    'seats_error' => 'Nomor kursi tidak valid.',
                ]);
            }
        }

        $booking = DB::transaction(function () use (
            $schedule_id,
            $validated,
            $seats
        ) {
            $schedule = Schedule::whereKey($schedule_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Periksa apakah kursi sudah dipesan
            $alreadyBooked = BookingSeat::where(
                'schedule_id',
                $schedule->id
            )
                ->whereIn('seat_number', $seats)
                ->lockForUpdate()
                ->pluck('seat_number')
                ->toArray();

            if (count($alreadyBooked) > 0) {
                throw ValidationException::withMessages([
                    'seats_error' =>
                        'Kursi berikut sudah dipesan: ' .
                        implode(', ', $alreadyBooked),
                ]);
            }

            // Buat kode booking unik
            do {
                $bookingCode = 'MVX-' . strtoupper(Str::random(8));
            } while (Booking::where(
                'booking_code',
                $bookingCode
            )->exists());

            $totalSeats = count($seats);
            $totalPrice = $totalSeats * $schedule->price;

            // Simpan data utama pemesanan
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'schedule_id' => $schedule->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_seats' => $totalSeats,
                'total_price' => $totalPrice,
                'status' => 'confirmed',
            ]);

            // Simpan setiap kursi yang dipilih
            foreach ($seats as $seat) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'schedule_id' => $schedule->id,
                    'seat_number' => $seat,
                ]);
            }

            return $booking;
        });

        return redirect()->route(
            'booking.ticket',
            ['kode_booking' => $booking->booking_code]
        )->with('success', 'Pemesanan tiket berhasil!');
    }

    // Halaman e-ticket pelanggan
    public function ticket($kode_booking)
    {
        $booking = Booking::with([
            'schedule.film',
            'seats'
        ])
            ->where('booking_code', $kode_booking)
            ->firstOrFail();

        return view('bookings.ticket', compact('booking'));
    }
}
