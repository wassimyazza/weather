<?php

namespace App\Http\Controllers;

use App\Models\Tableau;
use Illuminate\Http\Request;

class TableauController extends Controller
{
    public function show(Tableau $tableau)
    {
        $tableau->load(['category', 'painter', 'images']);
        $relatedTableaux = Tableau::where('category_id', $tableau->category_id)
                                  ->where('id', '!=', $tableau->id)
                                  ->limit(3)
                                  ->get();
                                  
        return view('tableaux.show', compact('tableau', 'relatedTableaux'));
    }
}