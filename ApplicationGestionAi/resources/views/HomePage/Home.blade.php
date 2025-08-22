@extends('layouts.tailwind')

@section('title', 'Bib Readers - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center hover:opacity-80 transition-opacity duration-200">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h1 class="ml-2 text-2xl font-bold text-blue-600">Bib Readers</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{route('home')}}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Accueil</a>
                    <a href="{{ route('livres.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Catalogue</a>
                    <a href="{{route('contact')}}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Contact</a>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Menu - Logged In -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        <!-- Icône livre -->
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9-5-9-5-9 5 9 5z" />
                                        </svg>
                                        Gestion livre
                                    </div>
                                </a>
                                
                                <a href="{{ route('adherentindex') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <!-- Icône utilisateur -->
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Gestion adherent
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
                                <a href="{{route('emprunts.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Mes Emprunts
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
                        <a href="{{route('login')}}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{route('register')}}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Inscription
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('info') }}</span>
                    <button @click="show = false" class="ml-auto text-blue-600 hover:text-blue-800">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    Découvrez notre collection de livres
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                    Explorez des milliers de livres dans tous les genres. Empruntez, lisez et partagez votre passion pour la lecture.
                </p>
                <div class="mt-10">
                    <div class="relative max-w-lg mx-auto">
                        <input type="text" placeholder="Rechercher un livre..." class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <button class="absolute right-2 top-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-md transition-colors duration-200">
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Books Section - TOUJOURS VISIBLE -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Livres populaires</h2>
            <p class="text-lg text-gray-600">Découvrez nos livres les plus appréciés par nos lecteurs</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Book Card 1 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Livre 1" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.8
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Le Petit Prince</h3>
                    <p class="text-sm text-gray-600 mb-3">Antoine de Saint-Exupéry</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        Un conte poétique et philosophique qui aborde les thèmes de l'amour, de l'amitié et du sens de la vie.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 2 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=698&q=80" alt="Livre 2" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.6
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">1984</h3>
                    <p class="text-sm text-gray-600 mb-3">George Orwell</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        Une dystopie visionnaire qui dépeint une société totalitaire sous surveillance constante.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 3 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 3" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.9
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Harry Potter</h3>
                    <p class="text-sm text-gray-600 mb-3">J.K. Rowling</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        L'histoire épique d'un jeune sorcier découvrant un monde magique et combattant le mal.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-red-600 text-sm font-medium">Emprunté</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-gray-400 text-gray-600 px-3 py-1 rounded text-sm cursor-not-allowed" disabled>
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 4 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 4" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.7
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Le Seigneur des Anneaux</h3>
                    <p class="text-sm text-gray-600 mb-3">J.R.R. Tolkien</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        Une épopée fantastique dans un monde médiéval où le destin de la Terre du Milieu est en jeu.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 5 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 5" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.5
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Don Quichotte</h3>
                    <p class="text-sm text-gray-600 mb-3">Miguel de Cervantes</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        L'histoire d'un gentilhomme qui perd la raison en lisant trop de romans de chevalerie.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 6 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 6" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.4
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Madame Bovary</h3>
                    <p class="text-sm text-gray-600 mb-3">Gustave Flaubert</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        Le portrait d'une femme bourgeoise insatisfaite de sa vie et cherchant l'évasion dans l'amour.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 7 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1541963463532-d68292c34b19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 7" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.3
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">L'Étranger</h3>
                    <p class="text-sm text-gray-600 mb-3">Albert Camus</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        L'histoire d'un homme confronté à l'absurdité de l'existence après la mort de sa mère.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Card 8 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Livre 8" class="w-full h-64 object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                        ⭐ 4.6
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Les Misérables</h3>
                    <p class="text-sm text-gray-600 mb-3">Victor Hugo</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        Une fresque sociale sur la misère et la rédemption dans le Paris du XIXe siècle.
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 text-sm font-medium">Disponible</span>
                        <div class="flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Détails
                            </button>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors duration-200">
                                Emprunter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <a href="{{ route('livres.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition-colors duration-200">
                Voir plus de livres
            </a>
        </div>
    </div>



    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="ml-2 text-xl font-bold">Bib Readers</h3>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Votre bibliothèque en ligne pour découvrir, emprunter et partager votre passion pour la lecture. 
                        Des milliers de livres disponibles pour tous les goûts et tous les âges.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Catalogue</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Nouveautés</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Confidentialité</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700">
                <p class="text-gray-400 text-sm text-center">
                    &copy; {{ date('Y') }} Bib Readers. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>
</div>
@endsection
