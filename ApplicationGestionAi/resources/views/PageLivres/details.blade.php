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
            <div class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300 relative">
                @if($livre->image_url)
                    @if(filter_var($livre->image_url, FILTER_VALIDATE_URL))
                        <!-- Image externe (URL) -->
                        <img src="{{ $livre->image_url }}" 
                             alt="{{ $livre->titre }}"
                             class="w-full h-[450px] object-cover">
                    @else
                        <!-- Image uploadée localement -->
                        <img src="{{ asset('storage/'.$livre->image_url) }}" 
                             alt="{{ $livre->titre }}"
                             class="w-full h-[450px] object-cover">
                    @endif
                @else
                    <!-- Image par défaut -->
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=698&q=80" 
                         alt="Image par défaut"
                         class="w-full h-[450px] object-cover">
                @endif
                
                <!-- Prix sur l'image -->
                @if(!is_null($livre->price) && $livre->price > 0)
                    <div class="absolute bottom-4 left-4 bg-green-500 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow-lg">
                        💰 {{ number_format((float)$livre->price, 2) }} (MAD)
                    </div>
                @elseif(!is_null($livre->price) && $livre->price == 0)
                    <div class="absolute bottom-4 left-4 bg-blue-500 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow-lg">
                        🆓 Gratuit
                    </div>
                @endif
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
                        </p>
                    @else
                        Non noté
                    </p>
                @endif
                </div>
                <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                    <span class="text-sm font-semibold text-gray-500">Prix</span>
                    <p class="font-semibold">
                        @if(!is_null($livre->price) && $livre->price > 0)
                            <span class="text-green-600">💰 {{ number_format((float)$livre->price, 2) }} (MAD)</span>
                        @elseif(!is_null($livre->price) && $livre->price == 0)
                            <span class="text-blue-600">🆓 Gratuit</span>
                        @else
                            <span class="text-gray-500">Non spécifié</span>
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
                <a href="{{ route('emprunts.create', $livre->id_livre) }}"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 inline-block">
                    📚 Emprunter ce livre
                 </a>
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
                   <div class="relative">
                       @if($similar->image_url)
                           @if(filter_var($similar->image_url, FILTER_VALIDATE_URL))
                               <!-- Image externe (URL) -->
                               <img src="{{ $similar->image_url }}" 
                                    alt="{{ $similar->titre }}"
                                    class="w-full h-56 object-cover">
                           @else
                               <!-- Image uploadée localement -->
                               <img src="{{ asset('storage/'.$similar->image_url) }}" 
                                    alt="{{ $similar->titre }}"
                                    class="w-full h-56 object-cover">
                           @endif
                       @else
                           <!-- Image par défaut -->
                           <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=698&q=80" 
                                alt="Image par défaut"
                                class="w-full h-56 object-cover">
                       @endif
                       
                       <!-- Prix sur l'image -->
                       @if(!is_null($similar->price) && $similar->price > 0)
                           <div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                               💰 {{ number_format((float)$similar->price, 2) }} (MAD)
                           </div>
                       @elseif(!is_null($similar->price) && $similar->price == 0)
                           <div class="absolute bottom-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                               🆓 Gratuit
                           </div>
                       @endif
                   </div>
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