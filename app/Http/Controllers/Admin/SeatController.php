<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Seat;
use App\Models\BookingSeat;
use App\Models\Schedule;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()
    {
        $studios = Studio::all();
        return view('admin.seats.index', compact('studios'));
    }

    public function show(Studio $studio)
    {
        $schedules = $studio->schedules()->with('film')->latest()->take(10)->get();
        $bookedSeats = [];
        
        foreach ($schedules as $schedule) {
            $booked = BookingSeat::where('schedule_id', $schedule->id)
                ->pluck('seat_number')
                ->toArray();
            $bookedSeats[$schedule->id] = $booked;
        }

        return view('admin.seats.show', compact('studio', 'schedules', 'bookedSeats'));
    }
}