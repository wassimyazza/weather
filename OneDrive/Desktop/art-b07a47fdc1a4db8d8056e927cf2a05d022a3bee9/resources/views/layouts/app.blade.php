<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tableaux Maroc - L\'Artisanat Marocain d\'Excellence')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rich-gold': '#D4AF37',
                        'deep-blue': '#2C3E50',
                        'earthy-sand': '#F4A460',
                        'muted-gray': '#7F8C8D',
                        'light-gold': '#FFD700',
                    },
                    fontFamily: {
                        'amiri': ['Amiri', 'serif'],
                        'jost': ['Jost', 'sans-serif'],
                    },
                    transitionProperty: {
                        'all': 'all',
                    },
                    transitionTimingFunction: {
                        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
                    },
                },
            },
        }
    </script>
    <style>
        .scale-102 {
            transform: scale(1.02);
        }
        .cart-dropdown {
            display: none;
        }
        .cart-dropdown.open {
            display: block;
        }

        #bg-home{
            background-repeat: no-repeat;
            background-size: 100% 120%;
            background-position: center;
        }
        #logo{
            max-height: 60px;
        }
        
        /* Cart Alert Styles */
        /* Add these styles to your <style> section in layouts/app.blade.php */

        .cart-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background-color: #D4AF37;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateX(200%);
            transition: transform 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-alert.show {
            transform: translateX(0);
        }

        .cart-alert-icon {
            font-size: 20px;
        }

        .cart-alert-content {
            flex-grow: 1;
        }

        .cart-alert-title {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .cart-alert-message {
            font-size: 14px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-jost text-gray-800 antialiased">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="font-amiri text-3xl font-bold text-deep-blue">
                    <img id="logo" src="{{ asset('img/logoenadfi.svg') }}" alt="Gallery Enadfy">
                </a>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-muted-gray hover:text-deep-blue transition-all {{ request()->routeIs('home') ? 'font-semibold text-deep-blue' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('custom-order') }}" class="text-muted-gray hover:text-deep-blue transition-all {{ request()->routeIs('custom-order') ? 'font-semibold text-deep-blue' : '' }}">
                        Sur Mesure
                    </a>
                    <div class="relative">
                        <button id="cart-button" class="relative hover:text-deep-blue transition-all focus:outline-none">
                            <svg data-feather="shopping-cart" class="w-6 h-6 text-muted-gray"></svg>
                            @php
                                $cartItems = session()->get('cart', []);
                                $cartCount = count($cartItems);
                            @endphp
                            @if ($cartCount > 0)
                                <span class="absolute top-[-8px] right-[-8px] bg-rich-gold text-white text-xs rounded-full px-2 py-0.5">{{ $cartCount }}</span>
                            @endif
                        </button>

                        <div id="cart-dropdown" class="cart-dropdown absolute top-full right-0 mt-2 bg-white shadow-xl rounded-md overflow-hidden w-80">
                            <div class="py-4 px-6">
                                @php $total = 0; @endphp
                                @if (count(session()->get('cart', [])) > 0)
                                    <ul>
                                        @foreach (session()->get('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity']; @endphp
                                            <li class="flex items-center py-3 border-b border-gray-200">
                                                <img src="{{ asset($details['image']) }}" alt="{{ $details['title'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                                <div class="flex-grow">
                                                    <h6 class="font-semibold text-gray-800">{{ Str::limit($details['title'], 20) }}</h6>
                                                    <p class="text-sm text-gray-600">Quantité: {{ $details['quantity'] }}</p>
                                                    <p class="text-sm text-gray-700">{{ number_format($details['price'], 2) }} MAD</p>
                                                </div>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-item-form" data-id="{{ $id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-red-500 hover:text-red-700 focus:outline-none remove-cart-item" data-id="{{ $id }}">
                                                        <svg data-feather="trash-2" class="w-4 h-4"></svg>
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-4 border-t border-gray-200 pt-4">
                                        <div class="flex justify-between font-semibold text-gray-800 mb-2">
                                            <span>Total:</span>
                                            <span>{{ number_format($total, 2) }} MAD</span>
                                        </div>
                                        <a href="{{ route('cart') }}" class="block bg-deep-blue text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition-all text-center">
                                            Voir le Panier
                                        </a>
                                    </div>
                                @else
                                    <p class="text-gray-700">Votre panier est vide.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-deep-blue text-gray-300 py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="font-amiri text-lg font-semibold text-white">Tableaux Maroc</h3>
                    <p class="text-sm">L'artisanat marocain à portée de main.</p>
                </div>
                <div class="text-center md:text-right text-sm">
                    <p>&copy; {{ date('Y') }} Tableaux Maroc. Tous droits réservés.</p>
                    <p class="mt-2">Sidi Ghouzia, Maroc</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
    // Function to create beautiful cart alert
    // Paste this in the <script> tags at the bottom of your layouts/app.blade.php file
// Replace the existing JavaScript code

// Function to create beautiful cart alert
function createCartAlert(title, message) {
    // Remove existing alert if any
    const existingAlert = document.querySelector('.cart-alert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    // Create alert element
    const alertEl = document.createElement('div');
    alertEl.className = 'cart-alert';
    alertEl.innerHTML = `
        <div class="cart-alert-icon">✅</div>
        <div class="cart-alert-content">
            <div class="cart-alert-title">${title}</div>
            <div class="cart-alert-message">${message}</div>
        </div>
    `;
    
    // Add to body
    document.body.appendChild(alertEl);
    
    // Show alert with animation
    setTimeout(() => alertEl.classList.add('show'), 10);
    
    // Auto-hide after 3 seconds
    setTimeout(() => {
        alertEl.classList.remove('show');
        setTimeout(() => alertEl.remove(), 300);
    }, 3000);
}

// Function to update cart dropdown content
function updateCartDropdown(cartData) {
    const cartDropdown = document.getElementById('cart-dropdown');
    
    // If we don't have the cart data structure, just return
    if (!cartData || !cartData.items) return;
    
    const cartItems = cartData.items;
    const total = cartData.total || 0;
    
    let cartHtml = `<div class="py-4 px-6">`;
    
    if (Object.keys(cartItems).length > 0) {
        cartHtml += `<ul>`;
        
        for (const [id, details] of Object.entries(cartItems)) {
            cartHtml += `
                <li class="flex items-center py-3 border-b border-gray-200">
                    <img src="/${details.image}" alt="${details.title}" class="w-16 h-16 object-cover rounded mr-4">
                    <div class="flex-grow">
                        <h6 class="font-semibold text-gray-800">${details.title.length > 20 ? details.title.substring(0, 20) + '...' : details.title}</h6>
                        <p class="text-sm text-gray-600">Quantité: ${details.quantity}</p>
                        <p class="text-sm text-gray-700">${Number(details.price).toFixed(2)} MAD</p>
                    </div>
                    <form action="/cart/remove/${id}" method="POST" class="remove-item-form" data-id="${id}">
                        <button type="button" class="text-red-500 hover:text-red-700 focus:outline-none remove-cart-item" data-id="${id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </form>
                </li>
            `;
        }
        
        cartHtml += `</ul>
            <div class="mt-4 border-t border-gray-200 pt-4">
                <div class="flex justify-between font-semibold text-gray-800 mb-2">
                    <span>Total:</span>
                    <span>${Number(total).toFixed(2)} MAD</span>
                </div>
                <a href="/cart" class="block bg-deep-blue text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition-all text-center">
                    Voir le Panier
                </a>
            </div>
        `;
    } else {
        cartHtml += `<p class="text-gray-700">Votre panier est vide.</p>`;
    }
    
    cartHtml += `</div>`;
    
    cartDropdown.innerHTML = cartHtml;
    
    // Re-attach event listeners for remove buttons
    document.querySelectorAll('.remove-cart-item').forEach(button => {
        button.addEventListener('click', handleRemoveItem);
    });
}

// Function to update cart badge count
function updateCartBadge(count) {
    const cartButton = document.querySelector('#cart-button');
    let badge = cartButton.querySelector('span');
    
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = "absolute top-[-8px] right-[-8px] bg-rich-gold text-white text-xs rounded-full px-2 py-0.5";
            cartButton.appendChild(badge);
        }
        badge.textContent = count;
    } else {
        if (badge) {
            badge.remove();
        }
    }
}

// Function to handle removing items from cart
function handleRemoveItem() {
    const productId = this.dataset.id;
    
    fetch(`/cart/remove/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart badge
            updateCartBadge(data.cartCount);
            
            // Update dropdown
            updateCartDropdown(data.cart);
            
            // Show alert
            createCartAlert("Produit retiré", "L'article a été retiré de votre panier");
        }
    })
    .catch(err => console.error(err));
}

document.addEventListener('DOMContentLoaded', function() {
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.dataset.id;
            const productName = "this.closest('.bg-white').querySelector('h3').textContent";

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge
                    updateCartBadge(data.cartCount);
                    
                    // Update cart dropdown content
                    updateCartDropdown(data.cart);
                    
                    // Show alert
                    createCartAlert("Ajouté au panier", `${productName} a été ajouté à votre panier`);
                    
                    // Button feedback
                    const originalText = this.textContent;
                    this.innerHTML = `<span class="flex items-center justify-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Ajouté</span>`;
                    this.classList.add('bg-green-600');
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-600');
                    }, 1500);
                }
            })
            .catch(err => console.error(err));
        });
    });
    
    // Cart dropdown toggle
    const cartButton = document.getElementById('cart-button');
    const cartDropdown = document.getElementById('cart-dropdown');

    cartButton.addEventListener('click', () => {
        cartDropdown.classList.toggle('open');
    });

    document.addEventListener('click', (event) => {
        if (!cartButton.contains(event.target) && !cartDropdown.contains(event.target)) {
            cartDropdown.classList.remove('open');
        }
    });
    
    // Initialize remove buttons
    document.querySelectorAll('.remove-cart-item').forEach(button => {
        button.addEventListener('click', handleRemoveItem);
    });
    
    // Initialize feather icons
    feather.replace();
});
    </script>
    @stack('scripts')
</body>
</html>