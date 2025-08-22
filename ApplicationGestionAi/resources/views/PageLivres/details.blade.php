@extends('layouts.tailwind')

@section('title', $livre->titre . ' - Bib Readers')

@section('content')
<div class="min-h-screen bg-gray-100">

    <!-- Section Hero -->
    <div class="relative bg-gradient-to-r from-indigo-700 via-purple-700 to-pink-600 text-white">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative max-w-7xl mx-auto px-6 py-16">
            <h1 class="text-4xl sm:text-5xl font-extrabold drop-shadow-lg">
                {{ $livre->titre }}
            </h1>
            <p class="mt-3 text-lg text-gray-200">
                Auteur : <span class="font-semibold">{{ $livre->auteur ?? 'Auteur inconnu' }}</span>
            </p>
        </div>
    </div>

    <!-- Contenu -->
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Colonne image -->
        <div class="flex justify-center">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                <img src="{{ $livre->image_url ? asset('storage/'.$livre->image_url) : 'https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?auto=format&fit=crop&w=800&q=80' }}"
                     alt="{{ $livre->titre }}"
                     class="w-full h-[450px] object-cover">
            </div>
        </div>
        

        <!-- Colonne infos -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">📖 À propos du livre</h2>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                {{ $livre->description ?? 'Aucune description disponible pour ce livre.' }}
            </p>

            <!-- Détails -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                    <span class="text-sm font-semibold text-gray-500">Auteur</span>
                    <p class="text-gray-900 font-medium">{{ $livre->auteur ?? 'Auteur inconnu' }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                    <span class="text-sm font-semibold text-gray-500">Disponibilité</span>
                    @php $disponible = (int)($livre->stock ?? 0) > 0; @endphp
                    <p class="{{ $disponible ? 'text-green-600' : 'text-red-600' }} font-semibold">
                        {{ $disponible ? '✅ Disponible' : '❌ Emprunté' }}
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                    <span class="text-sm font-semibold text-gray-500">Note</span>
                    <p class="text-yellow-500 font-semibold">
                        @if($livre->rating)
                            ⭐ {{ number_format((float)$livre->rating, 1) }}/5
                        @else
                            Non noté
                        @endif
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                    <span class="text-sm font-semibold text-gray-500">Stock restant</span>
                    <p class="text-gray-900 font-medium">{{ $livre->stock ?? 0 }} exemplaire(s)</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-wrap gap-4">
                @if($disponible)
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                            📚 Emprunter ce livre
                        </button>
                    </form>
                @else
                    <button disabled
                        class="px-6 py-3 bg-gray-400 text-gray-100 font-semibold rounded-xl shadow-md cursor-not-allowed">
                        Indisponible
                    </button>
                @endif

                <a href="{{ route('livres.index') }}"
                   class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                    🔙 Retour au catalogue
                </a>
            </div>
        </div>
    </div>

    <!-- Section Livres similaires -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">📌 Livres similaires</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($similaires ?? [] as $similar)
                <a href="{{ route('livres.show', $similar->id_livre) }}"
                   class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:scale-105 transition duration-300">
                   <img src="{{ $similar->image_url ? asset('storage/'.$similar->image_url) : 'https://images.unsplash.com/photo-1512820790803-83ca734da794' }}"
                   alt="{{ $similar->titre }}"
                   class="w-full h-56 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $similar->titre }}</h4>
                        <p class="text-sm text-gray-600">{{ $similar->auteur ?? 'Auteur inconnu' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Script pour les interactions supplémentaires si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        // Exemple : Afficher une alerte si le livre est emprunté
        @if(!$disponible)
            alert('Ce livre est actuellement emprunté.');
        @endif
    });
</script>
@endsection