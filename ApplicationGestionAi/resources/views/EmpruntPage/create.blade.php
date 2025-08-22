@extends('layouts.tailwind')

@section('title', 'Nouvel Emprunt')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded mt-6">
    <h2 class="text-2xl font-semibold mb-4">Créer un nouvel emprunt</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('emprunts.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Livre (affiché mais non modifiable) -->
        <div>
            <label for="id_livre_display" class="block text-gray-700 font-medium mb-2">Livre</label>
            <input type="text" 
                   id="id_livre_display"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                   value="{{ $livre->titre }}"
                   disabled>
            <!-- Champ caché envoyé -->
            <input type="hidden" name="id_livre" value="{{ $livre->id_livre }}">
        </div>

        <!-- Date d'emprunt (affichée mais non modifiable) -->
        <div>
            <label for="date_emprunt_display" class="block text-gray-700 font-medium mb-2">Date d'emprunt</label>
            <input type="text" 
                   id="date_emprunt_display"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                   value="{{ date('Y-m-d') }}"
                   disabled>
            <!-- Champ caché envoyé -->
            <input type="hidden" name="date_emprunt" value="{{ date('Y-m-d') }}">
        </div>

        <!-- Date retour prévu -->
        <div>
            <label for="date_retour_prevue" class="block text-gray-700 font-medium mb-2">Date de retour prévue</label>
            <input type="date" 
                   name="date_retour_prevue" 
                   id="date_retour_prevue" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>

        <!-- Date retour effectif -->
        <div>
            <label for="date_retour_effectif" class="block text-gray-700 font-medium mb-2">Date de retour effectif</label>
            <input type="date" 
                   name="date_retour_effectif" 
                   id="date_retour_effectif" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>

        <!-- Champs cachés : utilisateur et statut -->
        <input type="hidden" name="id_adherent" value="{{ Auth::id() }}">
        <input type="hidden" name="statut" value="en_cours">

        <div class="flex space-x-4 mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                Emprunter
            </button>
            <a href="{{ route('livres.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                Retour aux livres
            </a>
        </div>
    </form>
</div>
@endsection
