
@extends('layouts.app')

@section('title', 'Admin Login - Tableaux Maroc')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Administration</h2>
            <p class="text-gray-600 mt-2">Connectez-vous pour accéder au tableau de bord</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-8">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" 
                           required autofocus>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" 
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox">
                        <span class="ml-2 text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection