@extends('layouts.admin')

@section('title', 'Commandes Personnalisées - Admin')
@section('header', 'Gestion des Commandes Personnalisées')

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Liste des Commandes Personnalisées</h2>
        <p class="text-sm text-gray-500 mt-1">Gérez les demandes de tableaux personnalisés de vos clients</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taille</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($customOrders as $customOrder)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">CO-{{ $customOrder->id }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $customOrder->customer_name }}</div>
                        <div class="text-sm text-gray-500">{{ $customOrder->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $customOrder->title }}</td>
                    <td class="px-6 py-4">
                        @if($customOrder->reference_image)
                            <a href="{{ asset($customOrder->reference_image) }}" target="_blank" class="group relative">
                                <div class="w-16 h-16 rounded-md bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset($customOrder->reference_image) }}" alt="Image de référence" class="object-cover w-full h-full">
                                </div>
                                <div class="hidden group-hover:block absolute z-10 p-2 bg-black bg-opacity-80 text-white text-xs rounded bottom-full left-1/2 transform -translate-x-1/2 mb-2 whitespace-nowrap">
                                    Voir en taille réelle
                                </div>
                            </a>
                        @else
                            <span class="text-gray-400 text-sm italic">Aucune image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($customOrder->size == 'custom')
                            {{ $customOrder->custom_size ?? 'Personnalisée' }}
                        @else
                            {{ App\Models\CustomOrder::$sizes[$customOrder->size] ?? $customOrder->size }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ App\Models\CustomOrder::$paintTypes[$customOrder->paint_type] ?? $customOrder->paint_type ?? 'Non spécifié' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.custom-orders.update-status', $customOrder) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="rounded-md border border-gray-300 py-1 px-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="pending" {{ $customOrder->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmed" {{ $customOrder->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                <option value="completed" {{ $customOrder->status == 'completed' ? 'selected' : '' }}>Complétée</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customOrder->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                        <form action="{{ route('admin.custom-orders.destroy', $customOrder) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-900 flex items-center" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $customOrders->links() }}
    </div>
</div>

<!-- Modal for image preview -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-lg max-w-4xl max-h-screen overflow-auto">
        <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" onclick="closeImageModal()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="p-4">
            <img id="modalImage" src="" alt="Image en pleine taille" class="max-w-full max-h-[80vh]">
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Add click event listeners to all image thumbnails
    document.addEventListener('DOMContentLoaded', function() {
        const imageThumbnails = document.querySelectorAll('[data-image-src]');
        imageThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function(e) {
                e.preventDefault();
                openImageModal(this.getAttribute('data-image-src'));
            });
        });
    });
</script>
@endsection