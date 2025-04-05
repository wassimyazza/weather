<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tableau;
use App\Models\TableauImage;
use App\Models\Category;
use App\Models\Painter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminTableauController extends Controller
{
    public function index()
    {
        $tableaux = Tableau::with(['category', 'painter', 'images'])->paginate(10);
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
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create tableau record
        $tableau = Tableau::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'user_id' => $validated['user_id'],
            'image' => '' // Legacy field, we'll update it when processing images
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $this->handleImageUploads($tableau, $request->file('images'));
        }

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau créé avec succès.');
    }

    public function show(Tableau $tableau)
    {
        $tableau->load(['category', 'painter', 'images']);
        return view('admin.tableaux.show', compact('tableau'));
    }

    public function edit(Tableau $tableau)
    {
        $tableau->load('images');
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update tableau
        $tableau->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'user_id' => $validated['user_id'],
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $this->handleImageUploads($tableau, $request->file('images'));
        }

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau mis à jour avec succès.');
    }

    public function destroy(Tableau $tableau)
    {
        // Delete all related images
        foreach ($tableau->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }
        
        // Delete the legacy image if it exists
        if ($tableau->image && file_exists(public_path($tableau->image))) {
            unlink(public_path($tableau->image));
        }

        // Delete the tableau (and its related images due to cascade)
        $tableau->delete();

        return redirect()->route('admin.tableaux.index')
            ->with('success', 'Tableau supprimé avec succès.');
    }

    /**
     * Handle multiple image uploads for a tableau
     */
    private function handleImageUploads(Tableau $tableau, array $images)
    {
        $destinationPath = public_path('uploads/tableaux');

        // Create directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Count existing images to determine order
        $orderCounter = $tableau->images()->count();

        foreach ($images as $index => $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/tableaux/' . $filename;

            // Create image record
            $tableau->images()->create([
                'image_path' => $imagePath,
                'is_primary' => ($index === 0 && $orderCounter === 0), // First image of first upload is primary
                'display_order' => $orderCounter + $index
            ]);

            // If this is the first image and there are no existing images,
            // update the legacy image field on the tableau
            if ($index === 0 && $orderCounter === 0) {
                $tableau->update(['image' => $imagePath]);
            }
        }
    }

    /**
     * Delete an image from a tableau
     */
    public function deleteImage($imageId)
    {
        $image = TableauImage::findOrFail($imageId);
        $tableau = $image->tableau;
        
        // Delete the file
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
        
        // If it's the primary image, set another one as primary
        if ($image->is_primary) {
            $nextImage = $tableau->images()->where('id', '!=', $imageId)->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
                $tableau->update(['image' => $nextImage->image_path]); // Update legacy field
            } else {
                $tableau->update(['image' => '']); // No images left
            }
        }
        
        // Delete the record
        $image->delete();
        
        return redirect()->back()->with('success', 'Image supprimée avec succès.');
    }

    /**
     * Set an image as the primary image for a tableau
     */
    public function setPrimaryImage($imageId)
    {
        $image = TableauImage::findOrFail($imageId);
        $tableau = $image->tableau;
        
        // Reset all images to non-primary
        $tableau->images()->update(['is_primary' => false]);
        
        // Set this one as primary
        $image->update(['is_primary' => true]);
        
        // Update the legacy image field
        $tableau->update(['image' => $image->image_path]);
        
        return redirect()->back()->with('success', 'Image principale définie avec succès.');
    }
}