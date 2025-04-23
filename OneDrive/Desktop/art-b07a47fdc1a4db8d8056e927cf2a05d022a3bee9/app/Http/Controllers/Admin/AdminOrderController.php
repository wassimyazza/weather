<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Tableau;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Reservation::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Reservation $order)
    {
        // Décoder les IDs des tableaux commandés
        $tableauIds = json_decode($order->tableau_ids, true);
        
        // Récupérer les tableaux correspondants
        $tableaux = [];
        if (is_array($tableauIds)) {
            // Compter les occurrences de chaque ID
            $countedIds = array_count_values($tableauIds);
            
            // Récupérer les tableaux uniques
            $uniqueTableaux = Tableau::whereIn('id', array_keys($countedIds))->get();
            
            // Ajouter la quantité à chaque tableau
            foreach ($uniqueTableaux as $tableau) {
                $tableau->quantity = $countedIds[$tableau->id] ?? 0;
                $tableaux[] = $tableau;
            }
        }
        
        return view('admin.orders.show', compact('order', 'tableaux'));
    }

    public function updateStatus(Request $request, Reservation $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed'
        ]);

        $order->update($validated);

        return redirect()->back()
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function destroy(Reservation $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée avec succès.');
    }
}