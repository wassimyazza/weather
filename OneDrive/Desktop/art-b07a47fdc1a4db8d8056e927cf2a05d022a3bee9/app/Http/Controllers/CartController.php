<?php

namespace App\Http\Controllers;

use App\Models\Tableau;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($id, Request $request)
    {
        $tableau = \App\Models\Tableau::findOrFail($id);
        
        $cart = session()->get('cart', []);
    
        // Fix: Only increment if already in cart
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $tableau->title,
                "price" => $tableau->price,
                "image" => $tableau->image,
                "quantity" => 1
            ];
        }
    
        session()->put('cart', $cart);
    
        // Calculate total for JSON response
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Handle AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ajouté au panier',
                'cartCount' => count($cart),
                'cart' => [
                    'items' => $cart,
                    'total' => $total
                ]
            ]);
        }
    
        return redirect()->back()->with('success', 'Tableau ajouté au panier avec succès!');
    }
    
    public function removeFromCart($id, Request $request)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        // Calculate total for JSON response
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Handle AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit retiré du panier',
                'cartCount' => count($cart),
                'cart' => [
                    'items' => $cart,
                    'total' => $total
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Tableau retiré du panier.');
    }
    
    public function showCart()
    {
        return view('cart');
    }
    
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        // Calculate total for JSON response
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Handle AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Panier mis à jour avec succès',
                'cartCount' => count($cart),
                'cart' => [
                    'items' => $cart,
                    'total' => $total
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Panier mis à jour avec succès.');
    }
}