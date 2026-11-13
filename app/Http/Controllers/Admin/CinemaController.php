<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function index()
    {
        $cinemas = Cinema::latest()->paginate(12);
        return view('admin.cinemas.index', compact('cinemas'));
    }

    public function create()
    {
        return view('admin.cinemas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
        ]);

        Cinema::create($validated);

        return redirect()->route('admin.cinemas.index')
            ->with('success', 'Bioskop "' . $validated['name'] . '" telah ditambahkan.');
    }

    public function edit(Cinema $cinema)
    {
        return view('admin.cinemas.edit', compact('cinema'));
    }

    public function update(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
        ]);

        $cinema->update($validated);

        return redirect()->route('admin.cinemas.index')
            ->with('success', 'Bioskop "' . $cinema->name . '" telah diperbarui.');
    }

    public function destroy(Cinema $cinema)
    {
        $name = $cinema->name;
        $cinema->delete();

        return redirect()->route('admin.cinemas.index')
            ->with('success', 'Bioskop "' . $name . '" telah dihapus.');
    }
}