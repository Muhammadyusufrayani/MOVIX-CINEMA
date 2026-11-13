<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Film;
use App\Models\Schedule;
use Tests\TestCase;

class MovixBookingTest extends TestCase
{
    public function test_home_page_displays_now_showing_and_upcoming_films(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('MOVIX');
        $response->assertSee('CINEMA');
        $response->assertSee('Sedang Tayang');
        $response->assertSee('Segera Hadir');
        $response->assertSee('Gladiator II');
    }

    public function test_search_films_works(): void
    {
        $response = $this->get('/?search=Wicked');

        $response->assertStatus(200);
        $response->assertSee('Wicked');
        $response->assertSee('Hasil Pencarian untuk:');
    }

    public function test_film_detail_page_loads_with_schedules(): void
    {
        $film = Film::where('status', 'now_showing')->first();

        $response = $this->get('/film/' . $film->id);

        $response->assertStatus(200);
        $response->assertSee($film->title);
        $response->assertSee('Jadwal Tayang & Harga Tiket', false);
        $response->assertSee('Sinopsis Film');
    }

    public function test_booking_page_loads_with_seat_map(): void
    {
        $schedule = Schedule::first();

        $response = $this->get('/booking/' . $schedule->id);

        $response->assertStatus(200);
        $response->assertSee('LAYAR BIOSKOP');
        $response->assertSee('Data Pemesan Tiket');
        $response->assertSee($schedule->film->title);
    }

    public function test_booking_validation_requires_seats(): void
    {
        $schedule = Schedule::first();

        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
            'selected_seats' => '',
        ]);

        $response->assertSessionHasErrors(['seats_count']);
    }

    public function test_user_can_successfully_book_ticket_and_view_eticket(): void
    {
        $schedule = Schedule::first();

        // Find unbooked seat
        $bookedSeats = $schedule->bookingSeats()->pluck('seat_number')->toArray();
        $availableSeat = null;
        foreach (['E3', 'E4', 'F3', 'F4'] as $candidate) {
            if (!in_array($candidate, $bookedSeats)) {
                $availableSeat = $candidate;
                break;
            }
        }

        $this->assertNotNull($availableSeat, 'Must find an available seat to test');

        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'Sarah Connor',
            'customer_email' => 'sarah@example.com',
            'customer_phone' => '08987654321',
            'selected_seats' => $availableSeat,
        ]);

        $booking = Booking::where('customer_email', 'sarah@example.com')->latest()->first();
        $this->assertNotNull($booking);

        $response->assertRedirect('/tiket/' . $booking->booking_code);

        // Verify E-Ticket page
        $ticketResponse = $this->get('/tiket/' . $booking->booking_code);
        $ticketResponse->assertStatus(200);
        $ticketResponse->assertSee($booking->booking_code);
        $ticketResponse->assertSee('Sarah Connor');
        $ticketResponse->assertSee($availableSeat);
        $ticketResponse->assertSee('Cetak Tiket');
    }

    public function test_cannot_book_already_taken_seat(): void
    {
        $schedule = Schedule::first();

        // Get an already booked seat
        $takenSeat = $schedule->bookingSeats()->first();
        $this->assertNotNull($takenSeat);

        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'Intruder',
            'customer_email' => 'intruder@example.com',
            'customer_phone' => '08111222333',
            'selected_seats' => $takenSeat->seat_number,
        ]);

        $response->assertSessionHasErrors(['seats_error']);
    }
}
