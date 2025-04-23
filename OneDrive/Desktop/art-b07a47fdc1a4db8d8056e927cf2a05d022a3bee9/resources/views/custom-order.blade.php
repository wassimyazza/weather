@extends('layouts.app')

@section('title', 'Commande Personnalisée - Tableaux Maroc')

@section('content')
    <div class="container mx-auto px-6 py-16">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-10">
            <h1 class="font-amiri text-3xl font-bold text-deep-blue mb-10 text-center">Commander un Tableau Personnalisé</h1>

            <form action="{{ route('custom-order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Détails de votre œuvre</h2>

                <div class="mb-6">
                    <label for="title" class="block font-jost text-muted-gray font-semibold mb-2">Titre de l'œuvre</label>
                    <input type="text" id="title" name="title"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('title') border-red-500 @enderror"
                           value="{{ old('title') }}" required>
                    @error('title')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block font-jost text-muted-gray font-semibold mb-2">Description détaillée</label>
                    <textarea id="description" name="description" rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-rich-gold font-jost @error('description') border-red-500 @enderror"
                              required>{{ old('description') }}</textarea>
                    <p class="font-jost text-sm text-gray-500 mt-1">Décrivez en détail ce que vous souhaitez voir dans votre tableau.</p>
                    @error('description')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="size" class="block font-jost text-muted-gray font-semibold mb-2">Taille souhaitée</label>
                    <select id="size" name="size"
                            class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('size') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionnez une taille</option>
                        @foreach(App\Models\CustomOrder::$sizes as $key => $label)
                            <option value="{{ $key }}" {{ old('size') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('size')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6" id="custom-size-container" style="display: none;">
                    <label for="custom_size" class="block font-jost text-muted-gray font-semibold mb-2">Dimensions personnalisées</label>
                    <input type="text" id="custom_size" name="custom_size"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('custom_size') border-red-500 @enderror"
                           value="{{ old('custom_size') }}" placeholder="Ex: 80x120 cm">
                    <p class="font-jost text-sm text-gray-500 mt-1">Veuillez spécifier les dimensions en centimètres (largeur x hauteur).</p>
                    @error('custom_size')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="paint_type" class="block font-jost text-muted-gray font-semibold mb-2">Type de peinture/média</label>
                    <select id="paint_type" name="paint_type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('paint_type') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionnez un type</option>
                        @foreach(App\Models\CustomOrder::$paintTypes as $key => $label)
                            <option value="{{ $key }}" {{ old('paint_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="font-jost text-sm text-gray-500 mt-1">Choisissez le type de peinture ou média que vous préférez pour votre œuvre.</p>
                    @error('paint_type')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="colors" class="block font-jost text-muted-gray font-semibold mb-2">Couleurs préférées (optionnel)</label>
                    <input type="text" id="colors" name="colors"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('colors') border-red-500 @enderror"
                           value="{{ old('colors') }}" placeholder="Ex: bleu, rouge, doré">
                    <p class="font-jost text-sm text-gray-500 mt-1">Indiquez les couleurs dominantes que vous souhaitez dans votre tableau.</p>
                    @error('colors')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="reference_image" class="block font-jost text-muted-gray font-semibold mb-2">Image de référence (optionnel)</label>
                    <input type="file" id="reference_image" name="reference_image"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('reference_image') border-red-500 @enderror"
                           accept="image/*">
                    <p class="font-jost text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF. Taille maximale: 2MB.</p>
                    @error('reference_image')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-8 border-t border-gray-200">

                <h2 class="font-amiri text-xl font-semibold text-deep-blue mb-6">Vos informations</h2>

                <div class="mb-6">
                    <label for="customer_name" class="block font-jost text-muted-gray font-semibold mb-2">Nom complet</label>
                    <input type="text" id="customer_name" name="customer_name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('customer_name') border-red-500 @enderror"
                           value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="customer_phone" class="block font-jost text-muted-gray font-semibold mb-2">Téléphone</label>
                    <input type="tel" id="customer_phone" name="customer_phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:border-rich-gold font-jost @error('customer_phone') border-red-500 @enderror"
                           value="{{ old('customer_phone') }}" required>
                    @error('customer_phone')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="customer_address" class="block font-jost text-muted-gray font-semibold mb-2">Adresse</label>
                    <textarea id="customer_address" name="customer_address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-rich-gold font-jost @error('customer_address') border-red-500 @enderror"
                              required>{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                    <p class="font-jost text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-deep-blue text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-700 transition-all font-jost">
                        Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('size').addEventListener('change', function() {
            const customSizeContainer = document.getElementById('custom-size-container');
            const customSizeInput = document.getElementById('custom_size');

            if (this.value === 'custom') {
                customSizeContainer.style.display = 'block';
                customSizeInput.required = true;
            } else {
                customSizeContainer.style.display = 'none';
                customSizeInput.required = false;
            }
        });

        // Initial check on page load
        if (document.getElementById('size').value === 'custom') {
            document.getElementById('custom-size-container').style.display = 'block';
        }
    </script>
@endsection