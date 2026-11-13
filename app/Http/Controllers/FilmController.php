<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display the home/catalog page with featured banner, now showing, upcoming, and search.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $searchResults = Film::search($search)->get();
            $nowShowing = Film::nowShowing()->search($search)->get();
            $upcoming = Film::upcoming()->search($search)->get();
        } else {
            $searchResults = null;
            $nowShowing = Film::nowShowing()->with('schedules')->get();
            $upcoming = Film::upcoming()->get();
        }

        // Featured films for hero banner
        $featuredFilms = Film::nowShowing()->take(3)->get();

        return view('films.index', compact('nowShowing', 'upcoming', 'featuredFilms', 'search', 'searchResults'));
    }

    /**
     * Display the film detail page with synopsis, info, and schedules by studio & date.
     */
    public function show($id)
    {
        $film = Film::with(['schedules' => function ($query) {
            $query->orderBy('date', 'asc')->orderBy('time', 'asc');
        }])->findOrFail($id);

        // Group schedules by date for easy tab selection
        $schedulesByDate = $film->schedules->groupBy(function ($schedule) {
            return $schedule->date->format('Y-m-d');
        });

        // Recommended / other now showing films
        $otherFilms = Film::nowShowing()
            ->where('id', '!=', $film->id)
            ->take(4)
            ->get();

        return view('films.show', compact('film', 'schedulesByDate', 'otherFilms'));
    }
}

