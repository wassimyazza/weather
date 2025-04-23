@extends('layouts.admin')

@section('title', 'Détails de la Commande #' . $order->id . ' - Admin')
@section('header', 'Détails de la Commande #' . $order->id)

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Commande #{{ $order->id }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="md:col-span-1">
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations Client</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Nom:</span>
                        <span class="font-semibold text-gray-900">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Téléphone:</span>
                        <span class="text-gray-900">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Adresse:</span>
                        <span class="text-gray-900">{{ $order->customer_address }}</span>
                    </div>
                    @if($order->customer_note)
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-sm text-gray-500 block mb-1">Note client:</span>
                        <p class="text-gray-900 text-sm">{{ $order->customer_note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Détails de la Commande</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Date:</span>
                        <span class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Statut:</span>
                        <span class="px-3 py-1 text-xs rounded-full font-medium
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                            @if($order->status == 'confirmed') bg-blue-100 text-blue-800 @endif
                            @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                        ">
                            @if($order->status == 'pending') En attente @endif
                            @if($order->status == 'confirmed') Confirmée @endif
                            @if($order->status == 'completed') Complétée @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center font-bold">
                        <span class="text-sm text-gray-500">Total:</span>
                        <span class="text-indigo-700">{{ number_format($order->total_price, 2) }} MAD</span>
                    </div>
                </div>

                <div class="mt-6">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mettre à jour le statut:</label>
                        <div class="flex space-x-2">
                            <select name="status" class="rounded-md border border-gray-300 py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm flex-grow">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Complétée</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm transition-colors duration-200">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 h-full">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Articles Commandés</h3>
                
                @if(count($tableaux) > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tableau</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tableaux as $tableau)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-16 w-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                            <img src="{{ asset($tableau->image) }}" alt="{{ $tableau->title }}" class="h-16 w-16 object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $tableau->title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($tableau->description, 100) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-indigo-700">{{ number_format($tableau->price, 2) }} MAD</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10 bg-white rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">Aucun détail sur les tableaux commandés n'est disponible</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <div class="flex justify-between items-center">
            <div>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-100 text-rose-700 px-4 py-2 rounded-lg hover:bg-rose-200 transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer cette commande
                    </button>
                </form>
            </div>
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste des commandes
                </a>
            </div>
        </div>
    </div>
</div>
@endsection