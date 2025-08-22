@extends('layouts.tailwind')

@section('title', 'Modifier un Livre')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Modifier le Livre</h1>

        <!-- Formulaire de modification -->
        <form method="POST" action="{{ route('livres.update', $livre->id_livre) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Titre -->
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre du livre</label>
                <input type="text" name="titre" id="titre" value="{{ old('titre', $livre->titre) }}"
                       class="mt-2 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Ex: Les Misérables" required>
                @error('titre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-2 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="Résumé du livre...">{{ old('description', $livre->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700">Image (URL ou Upload)</label>
                @if($livre->image_url)
                    <img src="{{ asset('storage/'.$livre->image_url) }}" alt="Image du livre" class="w-32 h-32 object-cover mb-2 rounded">
                @endif
                <input type="file" name="image_url" id="image_url"
                       class="mt-2 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock disponible</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $livre->stock) }}"
                       class="mt-2 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Ex: 10" required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">Note (0 - 5)</label>
                <input type="number" name="rating" id="rating" step="0.1" min="0" max="5" value="{{ old('rating', $livre->rating ?? 2) }}"
                       class="mt-2 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Ex: 4.5">
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('livresindex') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
                    Mettre à jour le Livre
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
