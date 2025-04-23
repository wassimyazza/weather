@extends('layouts.app')

@section('title', 'Confirmation - Tableaux Maroc')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <div class="max-w-3xl mx-auto text-center bg-white rounded-xl shadow-md p-10">
            <div class="mb-8">
                <svg data-feather="check-circle" class="w-16 h-16 text-green-500 mx-auto"></svg>
            </div>

            <h1 class="font-amiri text-3xl font-bold text-deep-blue mb-4">Merci pour votre demande!</h1>
            <p class="font-jost text-lg text-muted-gray mb-8">Votre demande de tableau personnalisé a été reçue. Notre équipe artistique va l'examiner et vous contactera bientôt pour discuter des détails et du prix.</p>

            <div class="bg-gray-50 rounded-xl p-6 text-left">
                <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Détails de votre demande</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Numéro de demande</span>
                        <span class="font-jost text-sm text-gray-800">CO-{{ $customOrder->id }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Titre</span>
                        <span class="font-jost text-sm text-gray-800">{{ $customOrder->title }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Taille</span>
                        <span class="font-jost text-sm text-gray-800">
                            @if($customOrder->size == 'custom')
                                {{ $customOrder->custom_size ?? 'Personnalisée' }}
                            @else
                                {{ App\Models\CustomOrder::$sizes[$customOrder->size] ?? $customOrder->size }}
                            @endif
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Type de peinture</span>
                        <span class="font-jost text-sm text-gray-800">
                            {{ App\Models\CustomOrder::$paintTypes[$customOrder->paint_type] ?? $customOrder->paint_type ?? 'Non spécifié' }}
                        </span>
                    </div>
                    @if($customOrder->colors)
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-jost text-sm font-medium text-muted-gray">Couleurs préférées</span>
                            <span class="font-jost text-sm text-gray-800">{{ $customOrder->colors }}</span>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Nom</span>
                        <span class="font-jost text-sm text-gray-800">{{ $customOrder->customer_name }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="font-jost text-sm font-medium text-muted-gray">Téléphone</span>
                        <span class="font-jost text-sm text-gray-800">{{ $customOrder->customer_phone }}</span>
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

            @if($customOrder->reference_image)
                <div class="mt-8">
                    <h3 class="font-amiri text-lg font-semibold text-deep-blue mb-3">Image de référence</h3>
                    <div class="w-full max-w-md mx-auto bg-gray-200 rounded-xl overflow-hidden">
                        <img src="{{ asset($customOrder->reference_image) }}"
                             alt="Image de référence"
                             class="w-full h-auto object-cover">
                    </div>
                </div>
            @endif

            <a href="{{ route('home') }}" class="inline-block mt-8 bg-deep-blue text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-700 transition-all font-jost">
                Retour à l'accueil
            </a>
        </div>
    </div>
    <script>
        feather.replace();
    </script>
@endsection