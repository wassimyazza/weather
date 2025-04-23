@extends('layouts.admin')

@section('title', 'Ajouter une Catégorie - Admin')
@section('header', 'Ajouter une Catégorie')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                   required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Annuler
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Créer
            </button>
        </div>
    </form>
</div>
@endsection