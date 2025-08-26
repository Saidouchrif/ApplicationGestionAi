@extends('layouts.tailwind')

@section('title', $livre->titre . ' - Bib Readers')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center hover:opacity-80 transition-opacity duration-200">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h1 class="ml-2 text-2xl font-bold text-indigo-600">Bib Readers</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Accueil</a>
                    <a href="{{ route('livres.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Catalogue</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Contact</a>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Menu - Logged In -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->nom }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->nom }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                                </div>
                                
                                @if(Auth::user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                        </svg>
                                        Dashboard Admin
                                    </div>
                                </a>
                                <a href="{{ route('livresindex') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9-5-9-5-9 5 9 5z" />
                                        </svg>
                                        Gestion livre
                                    </div>
                                </a>
                                
                                <a href="{{ route('adherentindex') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Gestion adherent
                                    </div>
                                </a>
                                <a href="{{ route('reservations.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Gestion des réservations
                                    </div>
                                </a>
                                <a href="{{ route('emprunts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Gestion des emprunts
                                    </div>
                                </a>
                                @endif
                                
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Mon Profil
                                    </div>
                                </a>
                                @if(Auth::user()->role === 'adherent')
                                <a href="{{ route('emprunts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Mes Emprunts
                                    </div>
                                </a>
                                <a href="{{ route('reservations.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Mes Réservations
                                    </div>
                                </a>
                                @endif
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Paramètres
                                    </div>
                                </a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Déconnexion
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Auth Buttons - Not Logged In -->
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Inscription
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

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
                    <a href="{{ route('reservation.create', $livre->id_livre) }}"
                        class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 inline-block">
                        📅 Réserver ce livre
                    </a>
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
        <h3 class="text-2xl font-bold text-gray-900 mb-6">
            🤖 Livres recommandés par IA
            @if(isset($recommendations) && count($recommendations) > 0)
                <span class="text-sm font-normal text-gray-500 ml-2">(basé sur la similarité du contenu)</span>
            @endif
        </h3>
        
        @if(isset($recommendations) && count($recommendations) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($recommendations as $rec)
                    <a href="{{ route('livres.show', $rec['id_livre']) }}"
                       class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:scale-105 transition duration-300">
                       <div class="relative">
                           @if($rec['image_url'])
                               @if(filter_var($rec['image_url'], FILTER_VALIDATE_URL))
                                   <!-- Image externe (URL) -->
                                   <img src="{{ $rec['image_url'] }}" 
                                        alt="{{ $rec['titre'] }}"
                                        class="w-full h-56 object-cover">
                               @else
                                   <!-- Image uploadée localement -->
                                   <img src="{{ asset('storage/'.$rec['image_url']) }}" 
                                        alt="{{ $rec['titre'] }}"
                                        class="w-full h-56 object-cover">
                               @endif
                           @else
                               <!-- Image par défaut -->
                               <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=698&q=80" 
                                    alt="Image par défaut"
                                    class="w-full h-56 object-cover">
                           @endif
                           
                           <!-- Score de similarité -->
                           @if(isset($rec['similarity_score']))
                               <div class="absolute top-2 right-2 bg-indigo-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                                   {{ number_format($rec['similarity_score'] * 100, 1) }}% similaire
                               </div>
                           @endif
                           
                           <!-- Prix sur l'image -->
                           @if(!is_null($rec['price']) && $rec['price'] > 0)
                               <div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                                   💰 {{ number_format((float)$rec['price'], 2) }} (MAD)
                               </div>
                           @elseif(!is_null($rec['price']) && $rec['price'] == 0)
                               <div class="absolute bottom-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                                   🆓 Gratuit
                               </div>
                           @endif
                       </div>
                        <div class="p-4">
                            <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $rec['titre'] }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($rec['description'], 80) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Stock: {{ $rec['stock'] }}</span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rec['rating'])
                                            <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <p class="text-gray-500">Aucune recommandation disponible pour le moment.</p>
                <p class="text-sm text-gray-400 mt-2">Le système de recommandation IA est en cours de chargement...</p>
            </div>
        @endif
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