@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Tableaux Card -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-50 p-6 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Tableaux</h3>
                <div class="p-2 bg-indigo-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900 mt-auto mb-4">{{ $tableauxCount }}</p>
            <div class="pt-4 mt-auto border-t border-gray-100">
                <a href="{{ route('admin.tableaux.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors flex items-center group-hover:translate-x-1 duration-300">
                    Voir tous
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-50 p-6 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-50 to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Catégories</h3>
                <div class="p-2 bg-emerald-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900 mt-auto mb-4">{{ $categoriesCount }}</p>
            <div class="pt-4 mt-auto border-t border-gray-100">
                <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-800 transition-colors flex items-center group-hover:translate-x-1 duration-300">
                    Voir toutes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-50 p-6 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-50 to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Commandes</h3>
                <div class="p-2 bg-amber-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900 mt-auto mb-4">{{ $ordersCount }}</p>
            <div class="pt-4 mt-auto border-t border-gray-100">
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-800 transition-colors flex items-center group-hover:translate-x-1 duration-300">
                    Voir toutes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Custom Orders Card -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-50 p-6 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Commandes Personnalisées</h3>
                <div class="p-2 bg-rose-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900 mt-auto mb-4">{{ $customOrdersCount }}</p>
            <div class="pt-4 mt-auto border-t border-gray-100">
                <a href="{{ route('admin.custom-orders.index') }}" class="text-sm font-medium text-rose-600 hover:text-rose-800 transition-colors flex items-center group-hover:translate-x-1 duration-300">
                    Voir toutes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection