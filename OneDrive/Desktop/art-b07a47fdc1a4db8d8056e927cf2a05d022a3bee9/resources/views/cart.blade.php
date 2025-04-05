@extends('layouts.app')

@section('title', 'Panier - Tableaux Maroc')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <h1 class="font-amiri text-3xl font-bold text-deep-blue mb-10 text-center">Votre Panier</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-8" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-8">
            @php
                $cart = session()->get('cart', []);
                $total = 0;
            @endphp

            @if(count($cart) > 0)
                <ul>
                    @foreach($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <li class="flex items-center justify-between py-6 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-md overflow-hidden mr-6">
                                    <img src="{{ asset($item['image']) }}"
                                         alt="{{ $item['title'] }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://placehold.co/200x200?text={{ urlencode($item['title']) }}'">
                                </div>
                                <div>
                                    <h3 class="font-semibold text-deep-blue">{{ $item['title'] }}</h3>
                                    <p class="text-muted-gray">{{ number_format($item['price'], 2) }} EURO</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center border border-gray-300 rounded-full overflow-hidden">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                                                class="px-3 py-2 text-muted-gray hover:bg-gray-100 focus:outline-none">-
                                        </button>
                                    </form>
                                    <span class="px-4 py-2 text-gray-800">{{ $item['quantity'] }}</span>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                                class="px-3 py-2 text-muted-gray hover:bg-gray-100 focus:outline-none">+
                                        </button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                        <svg data-feather="trash-2" class="w-5 h-5"></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 py-4 border-t border-gray-200">
                    <div class="flex justify-between font-semibold text-gray-800 mb-3">
                        <span>Sous-total</span>
                        <span>{{ number_format($total, 2) }} EURO</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-800 mb-3">
                        <span>Livraison</span>
                        <span>50.00 EURO</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-deep-blue">
                        <span>Total</span>
                        <span>{{ number_format($total + 50, 2) }} EURO</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="block bg-rich-gold text-white font-semibold py-3 px-6 rounded-full mt-6 hover:bg-light-gold transition-all text-center">
                        Procéder au Paiement
                    </a>
                </div>
            @else
                <div class="text-center py-16">
                    <svg data-feather="shopping-cart" class="w-16 h-16 text-muted-gray mx-auto mb-4"></svg>
                    <p class="font-jost text-lg text-muted-gray mb-6">Votre panier est vide.</p>
                    <a href="{{ route('home') }}" class="bg-deep-blue text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-700 transition-all font-jost">
                        Continuer vos achats
                    </a>
                </div>
            @endif
        </div>
    </div>
    <script>
        feather.replace();
    </script>
@endsection