@extends('layouts.admin')

@section('title', 'Tableaux - Admin')
@section('header', 'Gestion des Tableaux')

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Liste des Tableaux</h2>
            <p class="text-sm text-gray-500 mt-1">Gérez votre collection de tableaux</p>
        </div>
        <a href="{{ route('admin.tableaux.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un Tableau
        </a>
    </div>

    <div class="overflow-x-auto bg-white border border-gray-100 rounded-lg">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peintre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tableaux as $tableau)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="h-16 w-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                            <img src="{{ asset($tableau->image) }}" alt="{{ $tableau->title }}" class="h-16 w-16 object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $tableau->title }}</div>
                        <div class="text-xs text-gray-500 mt-1">ID: #{{ $tableau->id }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700">
                            {{ $tableau->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($tableau->painter)
                            <a href="{{ route('admin.painters.show', $tableau->painter) }}" class="flex items-center">
                                <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-100 border border-gray-200 mr-2">
                                    <img src="{{ asset($tableau->painter->image_profile) }}" alt="{{ $tableau->painter->name }}" class="h-8 w-8 object-cover">
                                </div>
                                <span class="text-sm text-gray-900">{{ $tableau->painter->name }}</span>
                            </a>
                        @else
                            <span class="text-sm text-gray-500">Aucun peintre</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($tableau->price, 2) }} MAD</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.tableaux.show', $tableau) }}" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir
                            </a>
                            <a href="{{ route('admin.tableaux.edit', $tableau) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier
                            </a>
                            <form action="{{ route('admin.tableaux.destroy', $tableau) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-900 flex items-center" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tableau ?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if(count($tableaux) == 0)
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 text-sm">Aucun tableau trouvé</p>
                            <a href="{{ route('admin.tableaux.create') }}" class="mt-3 text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Ajouter votre premier tableau
                            </a>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $tableaux->links() }}
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-indigo-800">Total Tableaux</div>
                    <div class="text-2xl font-bold text-indigo-900">{{ $tableaux->total() }}</div>
                </div>
            </div>
        </div>
        
        <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-emerald-800">Valeur Totale</div>
                    <div class="text-2xl font-bold text-emerald-900">{{ number_format($tableaux->sum('price'), 2) }} MAD</div>
                </div>
            </div>
        </div>
        
        <div class="bg-amber-50 rounded-lg p-4 border border-amber-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-amber-800">Peintres</div>
                    <div class="text-2xl font-bold text-amber-900">{{ \App\Models\Painter::count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection