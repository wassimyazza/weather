<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Tableaux Maroc')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-0 left-0 z-30 w-full bg-white shadow-sm">
            <div class="px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="font-semibold text-gray-800">Admin Dashboard</span>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-600 mr-2">{{ Auth::guard('admin')->user()->name }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar Overlay -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"
            x-cloak
        ></div>

        <!-- Sidebar -->
        <div 
            x-cloak
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="fixed md:static inset-y-0 left-0 z-30 w-64 transform md:translate-x-0 transition-transform duration-300 ease-in-out bg-gradient-to-b from-indigo-900 to-indigo-800 text-white flex-shrink-0 overflow-y-auto"
        >
            <div class="p-6 flex items-center space-x-3">
                <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-lg font-bold">Admin Dashboard</h1>
            </div>
            
            <nav class="mt-6 px-4">
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-indigo-300 uppercase tracking-wider mb-2">Principal</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.painters.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.painters.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Peintres</span>
                    </a>
                    <a href="{{ route('admin.tableaux.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.tableaux.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Tableaux</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Catégories</span>
                    </a>
                </div>
                
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-indigo-300 uppercase tracking-wider mb-2">Commandes</p>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Commandes</span>
                    </a>
                    <a href="{{ route('admin.custom-orders.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('admin.custom-orders.*') ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-700 hover:text-white' }} transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Commandes Personnalisées</span>
                    </a>
                </div>
            </nav>
            
            <div class="mt-auto p-4 border-t border-indigo-700">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-700 rounded-lg hover:bg-indigo-600 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar - Desktop Only -->
            <header class="bg-white shadow-sm hidden md:block">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 border-r pr-4 border-gray-200">
                            <span class="text-sm text-gray-500">Aujourd'hui</span>
                            <span class="text-sm font-medium">{{ now()->format('d M, Y') }}</span>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
                                    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ Auth::guard('admin')->user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div 
                                x-show="open" 
                                @click.away="open = false" 
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                                x-cloak
                            >
                                <form action="{{ route('admin.logout') }}" method="POST" class="py-1">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8 mt-14 md:mt-0 overflow-y-auto">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm mb-6 flex items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-lg shadow-sm mb-6 flex items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-100 p-4 text-center text-sm text-gray-500">
                <p>&copy; 2025 Tableaux Maroc - Admin Panel</p>
            </footer>
        </div>
    </div>
</body>
</html>