<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(12);
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'duration' => 'required|integer|min:1|max:999',
            'rating' => 'nullable|numeric|min:0|max:10',
            'age_rating' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'synopsis' => 'required|string',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_url' => 'nullable|url|max:500',
            'status' => 'required|in:now_showing,upcoming',
            'release_date' => 'nullable|date',
        ]);

        // Handle poster upload
        if ($request->hasFile('poster_url')) {
            $validated['poster_url'] = $request->file('poster_url')->store('films/posters', 'public');
        } else {
            $validated['poster_url'] = 'films/posters/default.jpg';
        }

        // Handle banner upload
        if ($request->hasFile('banner_url')) {
            $validated['banner_url'] = $request->file('banner_url')->store('films/banners', 'public');
        } else {
            $validated['banner_url'] = 'films/banners/default.jpg';
        }

        Film::create($validated);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $validated['title'] . '" telah ditambahkan.');
    }

    public function edit(Film $film)
    {
        return view('admin.films.edit', compact('film'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'duration' => 'required|integer|min:1|max:999',
            'rating' => 'nullable|numeric|min:0|max:10',
            'age_rating' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'synopsis' => 'required|string',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_url' => 'nullable|url|max:500',
            'status' => 'required|in:now_showing,upcoming',
            'release_date' => 'nullable|date',
        ]);

        if ($request->hasFile('poster_url')) {
            $validated['poster_url'] = $request->file('poster_url')->store('films/posters', 'public');
        }

        if ($request->hasFile('banner_url')) {
            $validated['banner_url'] = $request->file('banner_url')->store('films/banners', 'public');
        }

        $film->update($validated);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $film->title . '" telah diperbarui.');
    }

    public function destroy(Film $film)
    {
        $title = $film->title;
        $film->delete();

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $title . '" telah dihapus.');
    }
}