<?php

namespace App\Http\Controllers;

use App\Models\Tableau;
use App\Models\Category;
use App\Models\Painter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Tableau::with('category')
                        ->whereNull('user_id'); // Only get tableaux without a painter

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $tableaux = $query->paginate(6);
        $categories = Category::all(); // Get all categories for the dropdown
        
        // Find a painter with at least one tableau
        $featuredPainter = $this->findPainterWithTableaux();

        return view('home', compact('tableaux', 'categories', 'featuredPainter'));
    }

    /**
     * Find a painter who has at least one tableau.
     * Returns null if no painters have tableaux.
     */
    private function findPainterWithTableaux()
    {
        // Get all painters ordered by latest first
        $painters = Painter::latest()->get();
        
        foreach ($painters as $painter) {
            // For each painter, check if they have tableaux
            $painter->load(['tableaux' => function ($query) {
                $query->take(3); // Only get up to 3 tableaux
            }]);
            
            // If this painter has at least one tableau, return them
            if ($painter->tableaux->count() > 0) {
                return $painter;
            }
        }
        
        // If we reach here, no painters have tableaux
        return null;
    }
}