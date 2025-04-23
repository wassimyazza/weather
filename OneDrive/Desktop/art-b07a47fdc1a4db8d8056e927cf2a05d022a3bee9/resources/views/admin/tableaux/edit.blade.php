@extends('layouts.admin')

@section('title', 'Modifier un Tableau - Admin')
@section('header', 'Modifier un Tableau')

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Modifier le Tableau</h2>
        <p class="text-sm text-gray-500 mt-1">Mettez à jour les informations ci-dessous pour modifier ce tableau dans votre collection</p>
    </div>
    
    <form action="{{ route('admin.tableaux.update', $tableau) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $tableau->title) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                       placeholder="Nom du tableau" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix (MAD) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">MAD</span>
                    </div>
                    <input type="number" id="price" name="price" value="{{ old('price', $tableau->price) }}" step="0.01" min="0"
                           class="w-full pl-16 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror"
                           placeholder="0.00" required>
                </div>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-rose-500">*</span></label>
            <textarea id="description" name="description" rows="4" 
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                      placeholder="Décrivez ce tableau..." required>{{ old('description', $tableau->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select id="category_id" name="category_id" 
                            class="w-full px-4 py-2 border rounded-lg appearance-none bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $tableau->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Peintre</label>
                <div class="relative">
                    <select id="user_id" name="user_id" 
                            class="w-full px-4 py-2 border rounded-lg appearance-none bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('user_id') border-red-500 @enderror">
                        <option value="">Sélectionnez un peintre (optionnel)</option>
                        @foreach($painters as $painter)
                            <option value="{{ $painter->id }}" {{ old('user_id', $tableau->user_id) == $painter->id ? 'selected' : '' }}>
                                {{ $painter->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Associez ce tableau à un peintre (laissez vide si aucun)</p>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image <span class="text-rose-500">*</span></label>
            <div class="mb-3">
                <img src="{{ asset($tableau->image) }}" alt="{{ $tableau->title }}" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500 mt-2">Image actuelle</p>
            </div>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div class="mt-4 text-center">
                    <label for="image" class="cursor-pointer bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Choisir une nouvelle image
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" class="hidden">
                </div>
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                <p class="text-sm text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
                <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
            </div>
            <div id="file-preview"></div>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 pt-6 mt-6">
            <div class="flex flex-col sm:flex-row-reverse sm:justify-between sm:items-center gap-3">
                <div class="flex items-center space-x-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mettre à jour le tableau
                    </button>
                    <a href="{{ route('admin.tableaux.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Annuler
                    </a>
                </div>
                
                <div class="text-sm text-gray-500 flex items-center">
                    <span class="text-rose-500 mr-1">*</span> Champs obligatoires
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Show selected file name and preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameDisplay = document.getElementById('file-name');
        const previewContainer = document.getElementById('file-preview');

        if (file) {
            fileNameDisplay.textContent = `Fichier sélectionné: ${file.name}`;
            const reader = new FileReader();
            reader.onload = function (event) {
                previewContainer.innerHTML = `<img src="${event.target.result}" alt="Aperçu" class="mt-4 max-w-xs rounded shadow">`;
            };
            reader.readAsDataURL(file);
        } else {
            fileNameDisplay.textContent = '';
            previewContainer.innerHTML = '';
        }
    });
</script>
@endsection