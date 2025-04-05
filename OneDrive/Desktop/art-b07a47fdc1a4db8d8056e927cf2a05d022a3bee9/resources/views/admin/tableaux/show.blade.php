@extends('layouts.admin')

@section('title', $tableau->title . ' - Admin')
@section('header', 'Détails du Tableau')

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">{{ $tableau->title }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.tableaux.edit', $tableau) }}" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200 transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            <a href="{{ route('admin.tableaux.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="md:col-span-1">
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 flex flex-col items-center">
                <!-- Main Image -->
                <div class="w-full h-64 rounded-lg overflow-hidden mb-4 border border-gray-200">
                    <img id="main-image" src="{{ asset($tableau->primaryImage ? $tableau->primaryImage->image_path : $tableau->image) }}" alt="{{ $tableau->title }}" class="w-full h-full object-cover">
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($tableau->images && $tableau->images->count() > 0)
                <div class="w-full grid grid-cols-4 gap-2 mb-4">
                    @foreach($tableau->images as $image)
                        <div class="cursor-pointer rounded-lg overflow-hidden border {{ $image->is_primary ? 'border-amber-500' : 'border-gray-200' }}" onclick="changeMainImage('{{ asset($image->image_path) }}')">
                            <img src="{{ asset($image->image_path) }}" alt="{{ $tableau->title }}" class="w-full h-16 object-cover">
                        </div>
                    @endforeach
                </div>
                @endif
                
                <div class="w-full space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Prix:</span>
                        <span class="font-semibold text-gray-900">{{ number_format($tableau->price, 2) }} EURO</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Catégorie:</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700">
                            {{ $tableau->category->name ?? 'Non catégorisé' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">ID:</span>
                        <span class="text-sm text-gray-700">#{{ $tableau->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Créé le:</span>
                        <span class="text-sm text-gray-700">{{ $tableau->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 h-full">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Description</h3>
                    <p class="text-gray-700">{{ $tableau->description }}</p>
                </div>

                @if($tableau->painter)
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Peintre</h3>
                    <a href="{{ route('admin.painters.show', $tableau->painter) }}" class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-100 border border-gray-200 mr-4">
                            <img src="{{ asset($tableau->painter->image_profile) }}" alt="{{ $tableau->painter->name }}" class="h-16 w-16 object-cover">
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $tableau->painter->name }}</h4>
                            <p class="text-sm text-gray-500">Né le {{ $tableau->painter->born_in->format('d/m/Y') }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs text-indigo-600">Voir le profil du peintre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Peintre</h3>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <p class="text-gray-500">Aucun peintre associé à ce tableau</p>
                        <a href="{{ route('admin.tableaux.edit', $tableau) }}" class="text-sm text-indigo-600 mt-2 inline-flex items-center">
                            <span>Associer un peintre</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <div class="flex justify-between items-center">
            <div>
                <form action="{{ route('admin.tableaux.destroy', $tableau) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tableau ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-100 text-rose-700 px-4 py-2 rounded-lg hover:bg-rose-200 transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer ce tableau
                    </button>
                </form>
            </div>
            <div>
                <a href="{{ route('admin.tableaux.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste des tableaux
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(src) {
        document.getElementById('main-image').src = src;
    }
</script>
@endsection