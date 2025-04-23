<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tableau;
use App\Models\Category;
use App\Models\Painter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminTableauController extends Controller
{
    public function index()
    {
        $tableaux = Tableau::with(['category', 'painter'])->paginate(10);
        $categoriesCount = Category::count();
        return view('admin.tableaux.index', compact('tableaux', 'categoriesCount'));
    }

    public function create()
    {
        $categories = Category::all();
        $painters = Painter::all();
        return view('admin.tableaux.create', compact('categories', 'painters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:painters,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/tableaux');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $validated['image'] = 'uploads/tableaux/' . $filename;
        }

        Tableau::create($validated);

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau créé avec succès.');
    }

    public function show(Tableau $tableau)
    {
        $tableau->load(['category', 'painter']);
        return view('admin.tableaux.show', compact('tableau'));
    }

    public function edit(Tableau $tableau)
    {
        $categories = Category::all();
        $painters = Painter::all();
        return view('admin.tableaux.edit', compact('tableau', 'categories', 'painters'));
    }

    public function update(Request $request, Tableau $tableau)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:painters,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($tableau->image && file_exists(public_path($tableau->image))) {
                unlink(public_path($tableau->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/tableaux');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $validated['image'] = 'uploads/tableaux/' . $filename;
        }

        $tableau->update($validated);

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau mis à jour avec succès.');
    }

    public function destroy(Tableau $tableau)
    {
        if ($tableau->image && file_exists(public_path($tableau->image))) {
            unlink(public_path($tableau->image));
        }

        $tableau->delete();

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau supprimé avec succès.');
    }
}