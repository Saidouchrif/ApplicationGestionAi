@extends('layouts.tailwind')

@section('title', 'Ajouter un Adhérent')

@section('content')
<div class="max-w-3xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-12">

    <h1 class="text-3xl font-bold mb-8 text-gray-800 text-center">➕ Ajouter un Adhérent</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md flex justify-between items-center">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">✖</button>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('adherents.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nom -->
        <div>
            <label for="nom" class="block text-gray-700 font-semibold mb-1">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="Entrez le nom complet"
                   value="{{ old('nom') }}"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="exemple@domaine.com"
                   value="{{ old('email') }}"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password_hash" class="block text-gray-700 font-semibold mb-1">Mot de passe</label>
            <input type="password" name="password_hash" id="password_hash" placeholder="Entrez un mot de passe sécurisé"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('password_hash')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="password_hash_confirmation" class="block text-gray-700 font-semibold mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_hash_confirmation" id="password_hash_confirmation" placeholder="Confirmez le mot de passe"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
        </div>
        

        <!-- Date inscription -->
        <div>
            <label for="date_inscription" class="block text-gray-700 font-semibold mb-1">Date d'inscription</label>
            <!-- Champ affiché mais désactivé -->
            <input type="date" name="date_inscription_display" id="date_inscription" 
                   value="{{ now()->format('Y-m-d') }}" disabled
                   class="w-full px-5 py-3 border rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed focus:outline-none placeholder-gray-400">
            
            <!-- Champ hidden pour envoyer la date via request -->
            <input type="hidden" name="date_inscription" value="{{ now()->format('Y-m-d') }}">
        </div>
        

        <!-- Boutons -->
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('adherentindex') }}" 
               class="px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white rounded-lg shadow font-semibold transition duration-300">
                🔙 Retour
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow font-semibold transition duration-300">
                ✅ Ajouter
            </button>
        </div>
    </form>
</div>
@endsection
