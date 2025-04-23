<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Painter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminPainterController extends Controller
{
    public function index()
    {
        $painters = Painter::latest()->paginate(10);
        return view('admin.painters.index', compact('painters'));
    }

    public function create()
    {
        return view('admin.painters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'required|string',
            'born_in' => 'required|date',
            'image_profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_profile')) {
            $image = $request->file('image_profile');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/painters');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $validated['image_profile'] = 'uploads/painters/' . $filename;
        }

        Painter::create($validated);

        return redirect()->route('admin.painters.index')
            ->with('success', 'Peintre ajouté avec succès.');
    }

    public function show(Painter $painter)
    {
        $painter->load('tableaux');
        return view('admin.painters.show', compact('painter'));
    }

    public function edit(Painter $painter)
    {
        return view('admin.painters.edit', compact('painter'));
    }

    public function update(Request $request, Painter $painter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'required|string',
            'born_in' => 'required|date',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_profile')) {
            // Delete old image
            $oldPath = public_path($painter->image_profile);
            if ($painter->image_profile && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $image = $request->file('image_profile');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/painters');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $validated['image_profile'] = 'uploads/painters/' . $filename;
        }

        $painter->update($validated);

        return redirect()->route('admin.painters.index')
            ->with('success', 'Peintre mis à jour avec succès.');
    }

    public function destroy(Painter $painter)
    {
        // Delete the painter's image
        $imagePath = public_path($painter->image_profile);
        if ($painter->image_profile && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $painter->delete();

        return redirect()->route('admin.painters.index')
            ->with('success', 'Peintre supprimé avec succès.');
    }
}
