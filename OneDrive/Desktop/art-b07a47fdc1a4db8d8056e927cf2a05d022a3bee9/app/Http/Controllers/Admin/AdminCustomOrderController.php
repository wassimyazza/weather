<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCustomOrderController extends Controller
{
    public function index()
    {
        $customOrders = CustomOrder::latest()->paginate(10);
        return view('admin.custom-orders.index', compact('customOrders'));
    }

    public function updateStatus(Request $request, CustomOrder $customOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed'
        ]);

        $customOrder->update($validated);

        return redirect()->route('admin.custom-orders.index')
            ->with('success', 'Statut de la commande personnalisée mis à jour avec succès.');
    }

    public function destroy(CustomOrder $customOrder)
    {
        if ($customOrder->reference_image) {
            Storage::disk('public')->delete($customOrder->reference_image);
        }

        $customOrder->delete();

        return redirect()->route('admin.custom-orders.index')
            ->with('success', 'Commande personnalisée supprimée avec succès.');
    }
}