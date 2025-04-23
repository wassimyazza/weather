@extends('layouts.app')

@section('title', 'Paiement - Tableaux Maroc')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <h1 class="font-amiri text-3xl font-bold text-deep-blue mb-10 text-center">Finaliser la Commande</h1>

        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-10">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Vos informations</h2>
                <div class="mb-6">
                    <label for="name" class="block font-jost text-muted-gray font-semibold mb-2">Nom Complet</label>
                    <input type="text" id="name" name="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="phone" class="block font-jost text-muted-gray font-semibold mb-2">Téléphone</label>
                    <input type="tel" id="phone" name="phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('phone') border-red-500 @enderror"
                           value="{{ old('phone') }}" required>
                    @error('phone')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="address" class="block font-jost text-muted-gray font-semibold mb-2">Adresse</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-rich-gold font-jost @error('address') border-red-500 @enderror"
                              required>{{ old('address') }}</textarea>
                    @error('address')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="note" class="block font-jost text-muted-gray font-semibold mb-2">Message/Note (optionnel)</label>
                    <textarea id="note" name="note" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-rich-gold font-jost">{{ old('note') }}</textarea>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Résumé de la Commande</h2>
                    <div class="flex justify-between mb-3">
                        <span class="font-jost text-muted-gray">Sous-total</span>
                        <span class="font-jost font-semibold text-gray-800">{{ number_format($total, 2) }} MAD</span>
                    </div>
                    <div class="flex justify-between mb-3">
                        <span class="font-jost text-muted-gray">Livraison</span>
                        <span class="font-jost font-semibold text-gray-800">50.00 MAD</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between text-xl font-bold text-deep-blue">
                            <span class="font-jost">Total</span>
                            <span class="font-jost">{{ number_format($total + 50, 2) }} MAD</span>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <button type="submit" class="bg-rich-gold text-white font-semibold py-3 px-8 rounded-full hover:bg-light-gold transition-all font-jost">
                        Confirmer la Réservation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
