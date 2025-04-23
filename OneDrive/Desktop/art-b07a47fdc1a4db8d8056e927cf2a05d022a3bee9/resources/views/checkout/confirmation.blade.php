@extends('layouts.app')

@section('title', 'Confirmation - Tableaux Maroc')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <div class="max-w-3xl mx-auto text-center bg-white rounded-xl shadow-md p-10">
            <div class="mb-8">
                <svg data-feather="check-circle" class="w-16 h-16 text-green-500 mx-auto"></svg>
            </div>

            <h1 class="font-amiri text-3xl font-bold text-deep-blue mb-4">Merci pour votre réservation!</h1>
            <p class="font-jost text-lg text-muted-gray mb-8">Votre commande a été enregistrée avec succès. Nous vous contacterons bientôt pour confirmer la livraison.</p>

            <div class="bg-gray-50 rounded-xl p-6 text-left">
                <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Détails de la Réservation</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Numéro de réservation</span>
                        <span class="font-jost text-sm text-gray-800">{{ $reservation->id }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Nom</span>
                        <span class="font-jost text-sm text-gray-800">{{ $reservation->customer_name }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Téléphone</span>
                        <span class="font-jost text-sm text-gray-800">{{ $reservation->customer_phone }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Adresse</span>
                        <span class="font-jost text-sm text-gray-800">{{ $reservation->customer_address }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Total</span>
                        <span class="font-jost text-sm font-bold text-deep-blue">{{ number_format($reservation->total_price, 2) }} MAD</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Statut</span>
                        <span class="font-jost text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                En attente
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="mt-8 bg-deep-blue text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-700 transition-all font-jost">
                Continuer vos achats
            </a>
        </div>
    </div>
    <script>
      feather.replace();
    </script>
@endsection
