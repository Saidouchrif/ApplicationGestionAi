@extends('layouts.tailwind')

@section('title', 'Modifier Adhérent')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg mt-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Modifier Adhérent</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md flex justify-between items-center">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">✖</button>
        </div>
    @endif

    <form action="{{ route('adherent.update', $adherent->id_adherent) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Nom -->
        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-semibold mb-1">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $adherent->nom) }}" placeholder="Nom de l'adhérent"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $adherent->email) }}" placeholder="Email de l'adhérent"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password_hash" class="block text-gray-700 font-semibold mb-1">Mot de passe (laisser vide si inchangé)</label>
            <input type="password" name="password_hash" id="password_hash" placeholder="Entrez un mot de passe sécurisé"
                   class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
            @error('password_hash')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Confirmation -->
<!-- Password Confirmation -->
<div class="mb-6">
    <label for="password_hash_confirmation" class="block text-gray-700 font-semibold mb-1">Confirmer le mot de passe</label>
    <input type="password" name="password_hash_confirmation" id="password_hash_confirmation" placeholder="Confirmez le mot de passe"
           class="w-full px-5 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400">
</div>


        <div class="flex justify-between items-center">
            <a href="{{ route('adherentindex') }}" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg shadow">↩ Retour</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">💾 Enregistrer</button>
        </div>
    </form>
</div>
@endsection
