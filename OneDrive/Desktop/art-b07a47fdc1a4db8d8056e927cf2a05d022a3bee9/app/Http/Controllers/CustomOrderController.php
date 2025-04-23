<?php

namespace App\Http\Controllers;

use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomOrderController extends Controller
{
    public function showForm()
    {
        return view('custom-order');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'size' => 'required|string',
            'paint_type' => 'required|string',
            'custom_size' => 'required_if:size,custom|nullable|string|max:255',
            'colors' => 'nullable|string|max:255',
            'reference_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'required|string',
        ]);

        $data = $request->except('reference_image');
        $data['status'] = 'pending';
        
        // Generate a unique confirmation token
        $data['confirmation_token'] = Str::random(40);

        // Handle image upload to public/uploads/custom_orders
        if ($request->hasFile('reference_image')) {
            $image = $request->file('reference_image');
            $imageName = Str::slug($request->title) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/custom_orders');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $imageName);
            $data['reference_image'] = 'uploads/custom_orders/' . $imageName;
        }

        $customOrder = CustomOrder::create($data);

        // Redirect to the secure confirmation page with both ID and token
        return redirect()->route('custom-order.confirmation', [
            'id' => $customOrder->id,
            'token' => $data['confirmation_token']
        ]);
    }

    public function confirmation($id, Request $request)
    {
        $token = $request->query('token');
        
        // Trouver la commande personnalisée par ID et token pour assurer la sécurité
        $customOrder = CustomOrder::where('id', $id)
                               ->where('confirmation_token', $token)
                               ->first();
        
        // Si aucune commande correspondante n'est trouvée, rediriger vers l'accueil avec une erreur
        if (!$customOrder) {
            return redirect()->route('home')
                           ->with('error', 'La page de confirmation demandée n\'existe pas ou n\'est plus accessible.');
        }
        
        return view('custom-order.confirmation', compact('customOrder'));
    }
}