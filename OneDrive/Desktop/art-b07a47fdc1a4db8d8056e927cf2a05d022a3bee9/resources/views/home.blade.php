@extends('layouts.app')

@section('title', 'Accueil - Tableaux Maroc')

@section('content')
    <section id="bg-home" style="background-image: url({{ asset('img/bg3.jpg') }})" class=" py-24">
        <div class="container mx-auto px-6 text-center">
            <h1 class="font-amiri text-5xl font-bold text-white mb-8">L'Art Marocain, une Âme pour Votre Intérieur</h1>
            <p class="font-jost text-xl text-gray-200 mb-10">Explorez notre collection exclusive de tableaux, où tradition et modernité se rencontrent.</p>
            <a href="{{ route('custom-order') }}" class="bg-white text-deep-blue font-semibold text-lg py-3 px-8 rounded-full hover:bg-gray-100 transition-all">
                Créez Votre Œuvre Unique
            </a>
        </div>
    </section>

    <!-- Section artiste en vedette -->
    @if($featuredPainter && $featuredPainter->tableaux->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="font-amiri text-4xl font-bold text-deep-blue mb-12 text-center">Artiste à l'Honneur</h2>
        
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-12">
            <!-- Profil de l'artiste -->
            <div class="lg:w-1/3">
                <div class="text-center lg:text-left">
                    <div class="mb-6 relative inline-block">
                        <img src="{{ asset($featuredPainter->image_profile) }}" 
                             alt="{{ $featuredPainter->name }}" 
                             class="w-64 h-64 object-cover rounded-full shadow-md mx-auto lg:mx-0"
                             onerror="this.src='https://placehold.co/400x400?text={{ urlencode($featuredPainter->name) }}'">
                        <div class="absolute bottom-0 right-0 w-20 h-20 bg-rich-gold rounded-full flex items-center justify-center border-4 border-white">
                            <span class="font-amiri text-white text-lg">{{ $featuredPainter->born_in->format('Y') }}</span>
                        </div>
                    </div>
                    <h3 class="font-amiri text-3xl font-bold text-deep-blue mb-2">{{ $featuredPainter->name }}</h3>
                    <p class="font-jost text-muted-gray mb-6">Né le {{ $featuredPainter->born_in->format('d/m/Y') }}</p>
                    <p class="font-jost text-gray-600 leading-relaxed">
                        {{ $featuredPainter->info }}
                    </p>
                </div>
            </div>
            
            <!-- Œuvres de l'artiste -->
            <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredPainter->tableaux as $tableau)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:scale-102">
                        <a href="{{ route('tableaux.show', $tableau) }}" class="block relative h-56 bg-gray-100">
                            <img src="{{ asset($tableau->primaryImage ? $tableau->primaryImage->image_path : $tableau->image) }}" 
                                 alt="{{ $tableau->title }}"
                                 class="w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                                 onerror="this.src='https://placehold.co/600x400?text={{ urlencode($tableau->title) }}'">
                            
                            <!-- Image counter badge -->
                            @if($tableau->images && $tableau->images->count() > 1)
                                <div class="absolute bottom-3 right-3 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-md flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $tableau->images->count() }}
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <a href="{{ route('tableaux.show', $tableau) }}" class="block">
                                <h3 class="font-amiri text-lg font-semibold text-deep-blue mb-2 hover:text-rich-gold transition-colors">
                                    {{ $tableau->title }}
                                </h3>
                            </a>
                            <p class="font-jost text-gray-600 mb-4 text-sm">{{ Str::limit($tableau->description, 50) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="font-jost text-lg font-bold text-deep-blue">{{ number_format($tableau->price, 2) }} EURO</span>
                                <button 
                                    type="button"
                                    class="add-to-cart bg-rich-gold text-white px-3 py-1 rounded hover:bg-amber-600 transition-all text-sm"
                                    data-id="{{ $tableau->id }}"
                                >
                                    Ajouter au Panier
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="mt-10 text-center">
            <a href="{{ route('painters.all') }}" class="inline-block bg-deep-blue text-white font-semibold py-2 px-6 rounded-full hover:bg-blue-700 transition-all font-jost">
                Découvrir tous nos artistes et leurs œuvres
            </a>
        </div>
    </div>
</section>
@endif

    <div class="container mx-auto px-6 py-16">
        <section class="mb-12">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1">
                    <input type="search"
                           name="search"
                           placeholder="Rechercher une œuvre..."
                           value="{{ request('search') }}"
                           class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost">
                </div>
                <div class="w-full md:w-64">
                    <select name="category"
                            class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-deep-blue text-white font-semibold py-3 px-6 rounded-full hover:bg-blue-700 transition-all font-jost">
                    Filtrer
                </button>
            </form>
        </section>

        <!-- Main Grid Section in home.blade.php -->
<!-- Replace the existing grid section with this -->

<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    @forelse($tableaux as $tableau)
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:scale-102">
            <a href="{{ route('tableaux.show', $tableau) }}" class="block relative h-80 bg-gray-100 overflow-hidden">
                <img src="{{ asset($tableau->primaryImage ? $tableau->primaryImage->image_path : $tableau->image) }}"
                     alt="{{ $tableau->title }}"
                     class="w-full h-full object-cover transition-all duration-300 ease-in-out hover:scale-105"
                     onerror="this.src='https://placehold.co/600x400?text={{ urlencode($tableau->title) }}'">
                     
                <!-- Image counter badge -->
                @if($tableau->images && $tableau->images->count() > 1)
                    <div class="absolute bottom-3 right-3 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $tableau->images->count() }}
                    </div>
                @endif
            </a>
            <div class="p-6">
                <a href="{{ route('tableaux.show', $tableau) }}" class="block">
                    <h3 class="font-amiri text-xl font-semibold text-deep-blue mb-2 hover:text-rich-gold transition-colors">
                        {{ $tableau->title }}
                    </h3>
                </a>
                <p class="font-jost text-gray-600 mb-4">{{ Str::limit($tableau->description, 70) }}</p>
                <div class="flex justify-between items-center">
                    <span class="font-jost text-xl font-bold text-deep-blue">{{ number_format($tableau->price, 2) }} EURO</span>
                    <button 
                        type="button"
                        class="add-to-cart bg-rich-gold text-white px-4 py-2 rounded hover:bg-amber-600 transition-all"
                        data-id="{{ $tableau->id }}"
                    >
                        Ajouter au Panier
                    </button>
                </div>
                @if($tableau->category)
                    <span class="inline-block bg-gray-200 text-muted-gray text-sm px-3 py-1 rounded-full mt-3 font-jost">
                        {{ $tableau->category->name }}
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12">
            <p class="font-jost text-lg text-muted-gray">Aucune œuvre trouvée.</p>
        </div>
    @endforelse
</section>

        <div class="mt-12">
            {{ $tableaux->links() }}
        </div>
    </div>

    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-amiri text-4xl font-bold text-deep-blue mb-6">Laissez-vous Inspirer par l'Art Marocain</h2>
            <p class="font-jost text-lg text-muted-gray mb-8">Chaque tableau raconte une histoire, capturant l'essence et la beauté du Maroc.</p>
            <a href="{{ route('custom-order') }}" class="bg-deep-blue text-white font-semibold text-lg py-3 px-8 rounded-full hover:bg-blue-700 transition-all">
                Commandez Votre Toile Personnalisée
            </a>
        </div>
    </section>
@endsection