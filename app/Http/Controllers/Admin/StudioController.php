<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Cinema;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('cinema')
            ->latest()
            ->paginate(15);
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        $cinemas = Cinema::all();
        return view('admin.studios.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:999',
        ]);

        Studio::create($validated);

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio "' . $validated['name'] . '" telah ditambahkan.');
    }

    public function edit(Studio $studio)
    {
        $cinemas = Cinema::all();
        return view('admin.studios.edit', compact('studio', 'cinemas'));
    }

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:100',
            'type' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:999',
        ]);

        $studio->update($validated);

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio "' . $studio->name . '" telah diperbarui.');
    }

    public function destroy(Studio $studio)
    {
        $name = $studio->name;
        $studio->delete();

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio "' . $name . '" telah dihapus.');
    }

    public function seats(Studio $studio)
    {
        $studio->load('seats');
        return view('admin.studios.seats', compact('studio'));
    }
}