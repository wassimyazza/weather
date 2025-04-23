<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide.');
        }
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('checkout', compact('total'));
    }
    
    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'note' => 'nullable|string'
        ]);
        
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('cart')->with('error', 'Votre panier est vide.');
        }
        
        // Calculate total
        $total = 0;
        $tableauIds = [];
        
        foreach($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
            for($i = 0; $i < $item['quantity']; $i++) {
                $tableauIds[] = $id;
            }
        }
        
        // Generate a unique confirmation token
        $confirmationToken = Str::random(40);
        
        // Create reservation
        $reservation = Reservation::create([
            'tableau_ids' => json_encode($tableauIds),
            'total_price' => $total,
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address,
            'customer_note' => $request->note,
            'status' => 'pending',
            'confirmation_token' => $confirmationToken
        ]);
        
        // Clear cart
        session()->forget('cart');
        
        // Redirect to the confirmation page with both ID and token
        return redirect()->route('checkout.confirmation', [
            'id' => $reservation->id,
            'token' => $confirmationToken
        ]);
    }
    
    public function confirmation($id, Request $request)
    {
        $token = $request->query('token');
        
        // Trouver la réservation par ID et token pour assurer la sécurité
        $reservation = Reservation::where('id', $id)
                                ->where('confirmation_token', $token)
                                ->first();
        
        // Si aucune réservation correspondante n'est trouvée, rediriger vers l'accueil avec une erreur
        if (!$reservation) {
            return redirect()->route('home')
                           ->with('error', 'La page de confirmation demandée n\'existe pas ou n\'est plus accessible.');
        }
        
        return view('checkout.confirmation', compact('reservation'));
    }
}