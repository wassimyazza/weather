@extends('layouts.app')

@section('title', 'Nos Artistes - Tableaux Maroc')

@section('content')
    <!-- Hero Banner -->
    <section class="relative py-32 bg-gradient-to-r from-deep-blue to-blue-700 overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-pattern-moroccan"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="font-amiri text-5xl md:text-6xl font-bold text-white mb-6">Artistes Marocains</h1>
                <p class="font-jost text-xl text-gray-200 leading-relaxed">Découvrez les talents exceptionnels qui perpétuent la riche tradition artistique du Maroc. Chaque créateur raconte une histoire unique à travers ses œuvres.</p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-16 overflow-hidden">
        @forelse($painters as $painter)
            <section class="mb-32 relative px-4">
                <!-- Background Decorative Element (contained within the section) -->
                <div class="absolute top-20 left-0 w-48 h-48 rounded-full bg-rich-gold opacity-5 -z-10"></div>
                <div class="absolute bottom-20 right-0 w-48 h-48 rounded-full bg-deep-blue opacity-5 -z-10"></div>
                
                <!-- Painter Header -->
                <div class="relative mb-16">
                    <!-- Decorative Line -->
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-gray-200 to-transparent -z-10"></div>
                    
                    <!-- Painter Name Badge -->
                    <div class="flex justify-center">
                        <div class="bg-white px-8 py-3 rounded-full shadow-md inline-block">
                            <h2 class="font-amiri text-3xl md:text-4xl font-bold text-deep-blue">{{ $painter->name }}</h2>
                        </div>
                    </div>
                </div>
                
                <!-- Painter Profile and Intro -->
                <div class="flex flex-col md:flex-row items-center gap-12 mb-16">
                    <!-- Left Side - Profile Image -->
                    <div class="md:w-2/5 relative">
                        <div class="relative w-64 h-64 mx-auto md:mx-0">
                            <!-- Border Decoration -->
                            <div class="absolute inset-0 rounded-full border-2 border-rich-gold p-2">
                                <div class="w-full h-full rounded-full overflow-hidden shadow-xl">
                                    <img 
                                        src="{{ asset($painter->image_profile) }}" 
                                        alt="{{ $painter->name }}" 
                                        class="w-full h-full object-cover"
                                        onerror="this.src='https://placehold.co/600x600?text={{ urlencode($painter->name) }}'"
                                    >
                                </div>
                            </div>
                            
                            <!-- Year Badge -->
                            <div class="absolute -bottom-4 right-0 w-20 h-20 bg-rich-gold rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                                <div class="text-center">
                                    <span class="font-amiri text-white text-xs block">Né en</span>
                                    <span class="font-amiri text-white text-xl font-bold block">{{ $painter->born_in->format('Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Bio -->
                    <div class="md:w-3/5">
                        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border-t-4 border-rich-gold">
                            <p class="font-jost text-sm text-muted-gray uppercase tracking-wider mb-2">Biographie</p>
                            <p class="font-jost text-gray-700 leading-relaxed mb-6">
                                {{ $painter->info }}
                            </p>
                            <p class="font-jost text-sm text-muted-gray">
                                Artiste marocain · Né le {{ $painter->born_in->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Tableaux Section -->
                <div>
                    <div class="flex items-center mb-10">
                        <div class="h-px bg-gray-200 flex-grow"></div>
                        <h3 class="font-amiri text-2xl font-bold text-deep-blue px-6">Collection d'Œuvres</h3>
                        <div class="h-px bg-gray-200 flex-grow"></div>
                    </div>
                    
                    @if($painter->tableaux->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($painter->tableaux as $tableau)
                                <div class="group bg-white rounded-xl shadow-md overflow-hidden transition-all hover:shadow-xl hover:translate-y-[-5px] duration-300">
                                    <!-- Image Container with Overlay -->
                                    <div class="relative h-64 bg-gray-100 overflow-hidden">
                                        <img 
                                            src="{{ asset($tableau->image) }}" 
                                            alt="{{ $tableau->title }}"
                                            class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110"
                                            onerror="this.src='https://placehold.co/600x400?text={{ urlencode($tableau->title) }}'"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="p-6">
                                        <h3 class="font-amiri text-xl font-semibold text-deep-blue mb-2 group-hover:text-rich-gold transition-colors">{{ $tableau->title }}</h3>
                                        <p class="font-jost text-gray-600 mb-4">{{ Str::limit($tableau->description, 70) }}</p>
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="font-jost text-xl font-bold text-deep-blue">{{ number_format($tableau->price, 2) }} MAD</span>
                                            <button 
                                                type="button"
                                                class="add-to-cart bg-rich-gold text-white px-4 py-2 rounded-md hover:bg-amber-600 transition-all flex items-center gap-2"
                                                data-id="{{ $tableau->id }}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Ajouter
                                            </button>
                                        </div>
                                        
                                        @if(isset($tableau->category))
                                            <span class="inline-block bg-gray-100 text-muted-gray text-sm px-3 py-1 rounded-full mt-4 font-jost">
                                                {{ $tableau->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-12 text-center border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="font-jost text-lg text-muted-gray">Aucune œuvre disponible pour cet artiste pour le moment.</p>
                        </div>
                    @endif
                </div>
            </section>
        @empty
            <div class="py-24 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="font-jost text-2xl text-muted-gray">Aucun artiste trouvé.</p>
            </div>
        @endforelse
        
        <!-- Pagination -->
        <div class="mt-16">
            {{ $painters->links() }}
        </div>
    </div>
    
    <!-- Call to Action -->
    <section class="py-24 bg-gradient-to-br from-deep-blue to-blue-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-pattern-moroccan opacity-10"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="font-amiri text-4xl md:text-5xl font-bold text-white mb-6">Inspirez-vous de l'Art Marocain</h2>
                <p class="font-jost text-xl text-gray-200 mb-10 leading-relaxed">Chaque tableau raconte une histoire unique, capturant l'essence et la beauté du Maroc. Commandez une œuvre d'art personnalisée qui reflète votre vision.</p>
                <a href="{{ route('custom-order') }}" class="inline-block bg-white text-deep-blue font-semibold text-lg py-4 px-10 rounded-full hover:bg-gray-100 transition-all shadow-lg">
                    Commandez Votre Toile Personnalisée
                </a>
            </div>
        </div>
        
        <!-- Decorative elements (contained within the section) -->
        <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full bg-rich-gold opacity-20"></div>
        <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-rich-gold opacity-10"></div>
    </section>
@endsection

@push('styles')
<style>
    .bg-pattern-moroccan {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush