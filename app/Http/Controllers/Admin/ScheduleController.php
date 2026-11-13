<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('film')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(15);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $films = Film::nowShowing()->get();
        return view('admin.schedules.create', compact('films'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'studio_name' => 'required|string|max:100',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1|max:999',
        ]);

        // Check for schedule conflict in same studio on same date and time
        $conflict = Schedule::where('studio_name', $validated['studio_name'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Jadwal bentrok: Studio "' . $validated['studio_name'] . '" sudah ada jadwal pada tanggal ' . $validated['date'] . ' pukul ' . $validated['time'] . '.');
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal tayang telah ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $films = Film::nowShowing()->get();
        return view('admin.schedules.edit', compact('schedule', 'films'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'studio_name' => 'required|string|max:100',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1|max:999',
        ]);

        // Check for conflict (excluding current schedule)
        $conflict = Schedule::where('studio_name', $validated['studio_name'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Jadwal bentrok: Studio "' . $validated['studio_name'] . '" sudah ada jadwal pada tanggal ' . $validated['date'] . ' pukul ' . $validated['time'] . '.');
        }

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal tayang telah diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal tayang telah dihapus.');
    }

    public function bookings(Schedule $schedule)
    {
        $bookings = $schedule->bookings()
            ->with(['seats', 'schedule.film'])
            ->latest()
            ->paginate(10);

        return view('admin.schedules.bookings', compact('schedule', 'bookings'));
    }
}