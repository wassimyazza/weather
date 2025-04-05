@extends('layouts.app')

@section('title', $tableau->title . ' - Tableaux Maroc')

@section('content')
<div class="container mx-auto px-6 py-16">
    <div class="mb-10">
        <a href="{{ route('home') }}" class="inline-flex items-center text-deep-blue hover:text-blue-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour aux tableaux
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Image Gallery -->
        <div>
            <!-- Main Image -->
            <div class="relative w-full h-96 mb-4 rounded-xl overflow-hidden shadow-lg">
                <img 
                    id="main-image" 
                    src="{{ asset($tableau->primaryImage ? $tableau->primaryImage->image_path : $tableau->image) }}" 
                    alt="{{ $tableau->title }}" 
                    class="w-full h-full object-cover" 
                    onerror="this.src='https://placehold.co/600x400?text={{ urlencode($tableau->title) }}'">
                
                <!-- Zoom controls -->
                <div class="absolute bottom-4 right-4 flex space-x-2">
                    <button onclick="openFullscreenGallery(0)" class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-deep-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Thumbnails -->
            @if($tableau->images && $tableau->images->count() > 0)
            <div class="grid grid-cols-5 gap-2">
                @foreach($tableau->images as $index => $image)
                <div 
                    class="cursor-pointer h-20 rounded-md overflow-hidden border-2 transition-all hover:opacity-90 hover:shadow-md {{ $image->is_primary ? 'border-rich-gold' : 'border-transparent' }}"
                    onclick="changeMainImage('{{ asset($image->image_path) }}', {{ $index }})"
                >
                    <img 
                        src="{{ asset($image->image_path) }}" 
                        alt="{{ $tableau->title }}" 
                        class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Tableau Details -->
        <div>
            <h1 class="font-amiri text-4xl font-bold text-deep-blue mb-3">{{ $tableau->title }}</h1>
            
            <div class="flex items-center mb-5">
                @if($tableau->category)
                <span class="inline-block bg-gray-200 text-deep-blue text-sm px-3 py-1 rounded-full font-jost mr-3">
                    {{ $tableau->category->name }}
                </span>
                @endif
                
                @if($tableau->painter)
                <a href="{{ route('painters.show', $tableau->painter) }}" class="inline-flex items-center text-muted-gray hover:text-deep-blue transition-colors">
                    <span class="mr-1">Par</span>
                    <span class="font-medium">{{ $tableau->painter->name }}</span>
                </a>
                @endif
            </div>
            
            <div class="mb-6">
                <div class="text-3xl font-bold text-deep-blue font-jost mb-4">
                    {{ number_format($tableau->price, 2) }} MAD
                </div>
                
                <button 
                    type="button"
                    class="add-to-cart bg-rich-gold text-white px-8 py-3 rounded-lg hover:bg-amber-600 transition-all flex items-center font-jost"
                    data-id="{{ $tableau->id }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Ajouter au Panier
                </button>
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <h2 class="font-amiri text-2xl font-semibold text-deep-blue mb-3">Description</h2>
                <div class="prose font-jost text-gray-700">
                    <p>{{ $tableau->description }}</p>
                </div>
            </div>
            
            @if($tableau->painter)
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h2 class="font-amiri text-2xl font-semibold text-deep-blue mb-3">À propos de l'artiste</h2>
                <div class="flex items-center">
                    <div class="mr-4">
                        <img 
                            src="{{ asset($tableau->painter->image_profile) }}" 
                            alt="{{ $tableau->painter->name }}" 
                            class="w-16 h-16 rounded-full object-cover border border-gray-200"
                            onerror="this.src='https://placehold.co/200x200?text={{ urlencode($tableau->painter->name) }}'">
                    </div>
                    <div>
                        <h3 class="font-jost font-medium text-deep-blue">{{ $tableau->painter->name }}</h3>
                        <p class="text-sm text-muted-gray">Né le {{ $tableau->painter->born_in->format('d/m/Y') }}</p>
                        <a href="{{ route('painters.show', $tableau->painter) }}" class="text-sm text-rich-gold hover:underline mt-1 inline-block">
                            Voir le profil complet
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Related Tableaux -->
    @if($relatedTableaux->count() > 0)
    <div class="mt-20">
        <h2 class="font-amiri text-3xl font-bold text-deep-blue mb-8">Œuvres similaires</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedTableaux as $relatedTableau)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:scale-102">
                <div class="relative h-64 bg-gray-100">
                    <img src="{{ asset($relatedTableau->primaryImage ? $relatedTableau->primaryImage->image_path : $relatedTableau->image) }}" 
                         alt="{{ $relatedTableau->title }}"
                         class="w-full h-full object-cover transition-all duration-300 ease-in-out"
                         onerror="this.src='https://placehold.co/600x400?text={{ urlencode($relatedTableau->title) }}'">
                </div>
                <div class="p-6">
                    <h3 class="font-amiri text-xl font-semibold text-deep-blue mb-2">{{ $relatedTableau->title }}</h3>
                    <p class="font-jost text-gray-600 mb-4">{{ Str::limit($relatedTableau->description, 70) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-jost text-xl font-bold text-deep-blue">{{ number_format($relatedTableau->price, 2) }} MAD</span>
                        <a href="{{ route('tableaux.show', $relatedTableau) }}" class="bg-indigo-100 text-indigo-800 px-4 py-2 rounded hover:bg-indigo-200 transition-all">
                            Voir
                        </a>
                    </div>
                    @if($relatedTableau->category)
                        <span class="inline-block bg-gray-200 text-muted-gray text-sm px-3 py-1 rounded-full mt-3 font-jost">
                            {{ $relatedTableau->category->name }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Fullscreen Gallery Modal -->
<div id="gallery-modal" class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center hidden">
    <div class="relative w-full h-full flex flex-col">
        <!-- Close button -->
        <button onclick="closeFullscreenGallery()" class="absolute top-4 right-4 bg-white p-2 rounded-full z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <!-- Image counter -->
        <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full z-10 font-jost text-sm">
            <span id="current-index">1</span> / <span id="total-count">{{ $tableau->images->count() }}</span>
        </div>
        
        <!-- Main image container -->
        <div class="flex-1 flex items-center justify-center p-10">
            <img id="fullscreen-image" src="" alt="{{ $tableau->title }}" class="max-h-full max-w-full object-contain">
        </div>
        
        <!-- Navigation controls -->
        <div class="flex justify-between items-center p-4">
            <button onclick="prevImage()" class="bg-white p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <!-- Thumbnails -->
            <div class="flex-1 px-8 overflow-x-auto">
                <div class="flex space-x-2">
                    @foreach($tableau->images as $index => $image)
                    <div 
                        class="cursor-pointer h-16 w-16 rounded-md overflow-hidden border-2 hover:border-white transition-all gallery-thumb"
                        onclick="showFullscreenImage({{ $index }})"
                        data-index="{{ $index }}"
                    >
                        <img 
                            src="{{ asset($image->image_path) }}" 
                            alt="{{ $tableau->title }}" 
                            class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <button onclick="nextImage()" class="bg-white p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    // Variables for the gallery
    const images = [
        @foreach($tableau->images as $image)
            "{{ asset($image->image_path) }}",
        @endforeach
    ];
    let currentImageIndex = 0;
    
    // Change the main image
    function changeMainImage(src, index) {
        document.getElementById('main-image').src = src;
        currentImageIndex = index;
    }
    
    // Open fullscreen gallery
    function openFullscreenGallery(index) {
        currentImageIndex = index;
        showFullscreenImage(index);
        document.getElementById('gallery-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Close fullscreen gallery
    function closeFullscreenGallery() {
        document.getElementById('gallery-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Show image in fullscreen mode
    function showFullscreenImage(index) {
        if (index < 0) index = images.length - 1;
        if (index >= images.length) index = 0;
        
        currentImageIndex = index;
        document.getElementById('fullscreen-image').src = images[index];
        document.getElementById('current-index').textContent = index + 1;
        
        // Update active thumbnail
        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            if (parseInt(thumb.dataset.index) === index) {
                thumb.classList.add('border-white');
            } else {
                thumb.classList.remove('border-white');
            }
        });
    }
    
    // Navigate to previous image
    function prevImage() {
        showFullscreenImage(currentImageIndex - 1);
    }
    
    // Navigate to next image
    function nextImage() {
        showFullscreenImage(currentImageIndex + 1);
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('gallery-modal').classList.contains('hidden')) return;
        
        if (e.key === 'ArrowLeft') {
            prevImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        } else if (e.key === 'Escape') {
            closeFullscreenGallery();
        }
    });
</script>
@endsection