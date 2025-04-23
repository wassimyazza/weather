<?php

namespace App\Http\Controllers;

use App\Models\Painter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PainterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all painters with all their tableaux
        $painters = Painter::with('tableaux.category')->latest()->paginate(5);
        
        return view('painters.index', compact('painters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('painters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'required|string',
            'born_in' => 'required|date',
            'image_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_profile')) {
            $imagePath = $request->file('image_profile')->store('painters', 'public');
            $validated['image_profile'] = $imagePath;
        }

        Painter::create($validated);

        return redirect()->route('painters.index')
            ->with('success', 'Peintre ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Painter $painter)
    {
        // Load all tableaux for this painter with their categories
        $painter->load('tableaux.category');
        
        return view('painters.show', compact('painter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Painter $painter)
    {
        return view('painters.edit', compact('painter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Painter $painter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'required|string',
            'born_in' => 'required|date',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_profile')) {
            // Delete the old image
            if ($painter->image_profile) {
                Storage::disk('public')->delete($painter->image_profile);
            }
            
            $imagePath = $request->file('image_profile')->store('painters', 'public');
            $validated['image_profile'] = $imagePath;
        }

        $painter->update($validated);

        return redirect()->route('painters.index')
            ->with('success', 'Peintre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Painter $painter)
    {
        // Delete the image
        if ($painter->image_profile) {
            Storage::disk('public')->delete($painter->image_profile);
        }
        
        $painter->delete();

        return redirect()->route('painters.index')
            ->with('success', 'Peintre supprimé avec succès.');
    }
}