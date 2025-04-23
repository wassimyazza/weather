@extends('layouts.admin')

@section('title', 'Modifier un Peintre - Admin')
@section('header', 'Modifier un Peintre')

@section('content')
<div class="bg-white rounded-xl shadow-sm hover:shadow p-6 transition-all duration-300">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Modifier le Peintre</h2>
        <p class="text-sm text-gray-500 mt-1">Mettez à jour les informations ci-dessous pour modifier ce peintre</p>
    </div>
    
    <form action="{{ route('admin.painters.update', $painter) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $painter->name) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                       placeholder="Nom du peintre" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="born_in" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance <span class="text-rose-500">*</span></label>
                <input type="date" id="born_in" name="born_in" value="{{ old('born_in', $painter->born_in->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('born_in') border-red-500 @enderror"
                       required>
                @error('born_in')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="info" class="block text-sm font-medium text-gray-700 mb-1">Information biographique <span class="text-rose-500">*</span></label>
            <textarea id="info" name="info" rows="4" 
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('info') border-red-500 @enderror"
                      placeholder="Décrivez ce peintre, son histoire, son style..." required>{{ old('info', $painter->info) }}</textarea>
            @error('info')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="image_profile" class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
            <div class="mb-3">
                <div class="w-32 h-32 rounded-full overflow-hidden border border-gray-200">
                    <img src="{{ asset($painter->image_profile) }}" alt="{{ $painter->name }}" class="w-full h-full object-cover">
                </div>
                <p class="text-sm text-gray-500 mt-2">Image actuelle</p>
            </div>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <div class="mt-4 text-center">
                    <label for="image_profile" class="cursor-pointer bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Choisir une nouvelle image
                    </label>
                    <input type="file" id="image_profile" name="image_profile" accept="image/*" class="hidden">
                </div>
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                <p class="text-sm text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
                <p id="file-name" class="mt-2 text-sm text-gray-600"></p>
            </div>
            <div id="file-preview"></div>
            @error('image_profile')
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
                        Mettre à jour le peintre
                    </button>
                    <a href="{{ route('admin.painters.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
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
    document.getElementById('image_profile').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameDisplay = document.getElementById('file-name');
        const previewContainer = document.getElementById('file-preview');

        if (file) {
            fileNameDisplay.textContent = `Fichier sélectionné: ${file.name}`;
            const reader = new FileReader();
            reader.onload = function (event) {
                previewContainer.innerHTML = `
                    <div class="mt-4 flex justify-center">
                        <div class="relative w-32 h-32 rounded-full overflow-hidden border border-gray-200">
                            <img src="${event.target.result}" alt="Aperçu" class="w-full h-full object-cover">
                        </div>
                    </div>`;
            };
            reader.readAsDataURL(file);
        } else {
            fileNameDisplay.textContent = '';
            previewContainer.innerHTML = '';
        }
    });
</script>
@endsection