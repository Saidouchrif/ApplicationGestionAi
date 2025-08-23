@extends('layouts.tailwind')

@section('title', 'Mes Réservations - Bib Readers')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center hover:opacity-80 transition-opacity duration-200">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h1 class="ml-2 text-2xl font-bold text-purple-600">Bib Readers</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Accueil</a>
                    <a href="{{ route('livres.index') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Catalogue</a>
                    <a href="{{route('contact')}}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Contact</a>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Menu - Logged In -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <a href="{{route('emprunts.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Mes Emprunts
                                    </div>
                                </a>
                                <a href="{{route('reservations.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
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
                        <a href="{{route('login')}}" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{route('register')}}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    Mes Réservations
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-purple-100">
                    Gérez vos réservations de livres et suivez leur statut
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header with Stats -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        @if(Auth::user()->role === 'admin')
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Gestion des réservations
                        @else
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Vos réservations
                        @endif
                    </h2>
                    <p class="text-gray-600 mt-1">
                        @if(Auth::user()->role === 'admin')
                            Consultez et gérez toutes les réservations de la bibliothèque
                        @else
                            Consultez et gérez toutes vos réservations
                        @endif
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('livres.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Voir le catalogue
                    </a>
                </div>
            </div>
        </div>

        <!-- Reservations List -->
        @if($reservations->count() > 0)
            <div class="grid gap-6">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Book Info -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- Book Image -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ filter_var($reservation->livre->image_url, FILTER_VALIDATE_URL) ? $reservation->livre->image_url : asset('storage/'.$reservation->livre->image_url) }}" 
                                             alt="{{ $reservation->livre->titre }}" 
                                             class="w-16 h-20 object-cover rounded-lg shadow-md"
                                             onerror="this.src='{{ asset('images/default-book.jpg') }}'">
                                    </div>
                                    
                                    <!-- Book Details -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $reservation->livre->titre }}</h3>
                                        <p class="text-gray-600 mb-2">{{ $reservation->livre->auteur }}</p>
                                        
                                        <!-- Reservation Details -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500">Date de réservation :</span>
                                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Statut :</span>
                                                @if($reservation->status === 'en_attente')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        En attente
                                                    </span>
                                                @elseif($reservation->status === 'confirmee')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Confirmée
                                                    </span>
                                                @elseif($reservation->status === 'annulee')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293-4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Annulée
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if(Auth::user()->role === 'admin')
                                            <div>
                                                <span class="text-gray-500">Adhérent :</span>
                                                <div class="flex items-center mt-1">
                                                    <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                                                        <svg class="w-3 h-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $reservation->adherent->nom ?? 'Adhérent inconnu' }}</span>
                                                    <span class="text-xs text-gray-500 ml-2">(ID: {{ $reservation->id_adherent }})</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                                                 <!-- Actions -->
                                 <div class="flex flex-col sm:flex-row gap-2 mt-4 lg:mt-0 lg:ml-6">
                                     <a href="{{ route('livres.show', $reservation->livre->id_livre) }}" 
                                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                         <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                         </svg>
                                         Voir détails
                                     </a>
                                     
                                     @if(Auth::user()->role === 'admin')
                                         <!-- Actions pour les admins -->
                                         @if($reservation->status === 'en_attente')
                                             <!-- Bouton Accepter -->
                                             <div x-data="{ showConfirmAccept: false }" class="inline">
                                                 <button type="button" 
                                                         @click="showConfirmAccept = true"
                                                         class="inline-flex items-center justify-center px-4 py-2 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-white hover:bg-green-50 transition-colors duration-200">
                                                     <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                     </svg>
                                                     Accepter
                                                 </button>
                                                 
                                                 <!-- Modal de confirmation pour accepter -->
                                                 <div x-show="showConfirmAccept" 
                                                      x-transition:enter="transition ease-out duration-300"
                                                      x-transition:enter-start="opacity-0"
                                                      x-transition:enter-end="opacity-100"
                                                      x-transition:leave="transition ease-in duration-200"
                                                      x-transition:leave-start="opacity-100"
                                                      x-transition:leave-end="opacity-0"
                                                      class="fixed inset-0 z-50 overflow-y-auto" 
                                                      style="display: none;">
                                                     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                         <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showConfirmAccept = false"></div>
                                                         
                                                         <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                             <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                 <div class="sm:flex sm:items-start">
                                                                     <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                         <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                         </svg>
                                                                     </div>
                                                                     <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                         <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                             Confirmer l'acceptation
                                                                         </h3>
                                                                         <div class="mt-2">
                                                                             <p class="text-sm text-gray-500">
                                                                                 Êtes-vous sûr de vouloir accepter cette réservation ? 
                                                                                 Le livre sera réservé pour cet adhérent.
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                 <form action="{{ route('reservations.status', $reservation->livre->id_livre) }}" method="POST" class="inline">
                                                                     @csrf
                                                                     @method('PUT')
                                                                     <input type="hidden" name="status" value="confirmee">
                                                                     <button type="submit" 
                                                                             class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                         Confirmer
                                                                     </button>
                                                                 </form>
                                                                 <button type="button" 
                                                                         @click="showConfirmAccept = false"
                                                                         class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                     Annuler
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                         
                                         @if($reservation->status === 'confirmee')
                                             <!-- Bouton Remettre en attente -->
                                             <div x-data="{ showConfirmRemettre: false }" class="inline">
                                                 <button type="button" 
                                                         @click="showConfirmRemettre = true"
                                                         class="inline-flex items-center justify-center px-4 py-2 border border-yellow-300 rounded-lg text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 transition-colors duration-200">
                                                     <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                     </svg>
                                                     Remettre en attente
                                                 </button>
                                                 
                                                 <!-- Modal de confirmation pour remettre en attente -->
                                                 <div x-show="showConfirmRemettre" 
                                                      x-transition:enter="transition ease-out duration-300"
                                                      x-transition:enter-start="opacity-0"
                                                      x-transition:enter-end="opacity-100"
                                                      x-transition:leave="transition ease-in duration-200"
                                                      x-transition:leave-start="opacity-100"
                                                      x-transition:leave-end="opacity-0"
                                                      class="fixed inset-0 z-50 overflow-y-auto" 
                                                      style="display: none;">
                                                     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                         <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showConfirmRemettre = false"></div>
                                                         
                                                         <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                             <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                 <div class="sm:flex sm:items-start">
                                                                     <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                         <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                         </svg>
                                                                     </div>
                                                                     <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                         <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                             Remettre en attente
                                                                         </h3>
                                                                         <div class="mt-2">
                                                                             <p class="text-sm text-gray-500">
                                                                                 Êtes-vous sûr de vouloir remettre cette réservation en attente ? 
                                                                                 L'adhérent devra attendre que le livre soit disponible.
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                 <form action="{{ route('reservations.status', $reservation->livre->id_livre) }}" method="POST" class="inline">
                                                                     @csrf
                                                                     @method('PUT')
                                                                     <input type="hidden" name="status" value="en_attente">
                                                                     <button type="submit" 
                                                                             class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                         Confirmer
                                                                     </button>
                                                                 </form>
                                                                 <button type="button" 
                                                                         @click="showConfirmRemettre = false"
                                                                         class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                     Annuler
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                         
                                         @if($reservation->status !== 'annulee')
                                             <!-- Bouton Annuler -->
                                             <div x-data="{ showConfirmAnnuler: false }" class="inline">
                                                 <button type="button" 
                                                         @click="showConfirmAnnuler = true"
                                                         class="inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors duration-200">
                                                     <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                     </svg>
                                                     Annuler
                                                 </button>
                                                 
                                                 <!-- Modal de confirmation pour annuler -->
                                                 <div x-show="showConfirmAnnuler" 
                                                      x-transition:enter="transition ease-out duration-300"
                                                      x-transition:enter-start="opacity-0"
                                                      x-transition:enter-end="opacity-100"
                                                      x-transition:leave="transition ease-in duration-200"
                                                      x-transition:leave-start="opacity-100"
                                                      x-transition:leave-end="opacity-0"
                                                      class="fixed inset-0 z-50 overflow-y-auto" 
                                                      style="display: none;">
                                                     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                         <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showConfirmAnnuler = false"></div>
                                                         
                                                         <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                             <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                 <div class="sm:flex sm:items-start">
                                                                     <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                         <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                         </svg>
                                                                     </div>
                                                                     <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                         <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                             Confirmer l'annulation
                                                                         </h3>
                                                                         <div class="mt-2">
                                                                             <p class="text-sm text-gray-500">
                                                                                 Êtes-vous sûr de vouloir annuler cette réservation ? 
                                                                                 Cette action peut être réversible.
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                 <form action="{{ route('reservations.status', $reservation->livre->id_livre) }}" method="POST" class="inline">
                                                                     @csrf
                                                                     @method('PUT')
                                                                     <input type="hidden" name="status" value="annulee">
                                                                     <button type="submit" 
                                                                             class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                         Confirmer
                                                                     </button>
                                                                 </form>
                                                                 <button type="button" 
                                                                         @click="showConfirmAnnuler = false"
                                                                         class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                     Annuler
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                         

                                     @else
                                         <!-- Actions pour les adhérents - seulement annuler -->
                                         @if($reservation->status !== 'annulee')
                                             <!-- Bouton Annuler (changer le statut) -->
                                             <div x-data="{ showConfirmAnnulerAdherent: false }" class="inline">
                                                 <button type="button" 
                                                         @click="showConfirmAnnulerAdherent = true"
                                                         class="inline-flex items-center justify-center px-4 py-2 border border-orange-300 rounded-lg text-sm font-medium text-orange-700 bg-white hover:bg-orange-50 transition-colors duration-200">
                                                     <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                     </svg>
                                                     Annuler
                                                 </button>
                                                 
                                                 <!-- Modal de confirmation pour annuler (adhérent) -->
                                                 <div x-show="showConfirmAnnulerAdherent" 
                                                      x-transition:enter="transition ease-out duration-300"
                                                      x-transition:enter-start="opacity-0"
                                                      x-transition:enter-end="opacity-100"
                                                      x-transition:leave="transition ease-in duration-200"
                                                      x-transition:leave-start="opacity-100"
                                                      x-transition:leave-end="opacity-0"
                                                      class="fixed inset-0 z-50 overflow-y-auto" 
                                                      style="display: none;">
                                                     <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                         <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showConfirmAnnulerAdherent = false"></div>
                                                         
                                                         <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                             <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                 <div class="sm:flex sm:items-start">
                                                                     <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                         <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                         </svg>
                                                                     </div>
                                                                     <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                         <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                             Confirmer l'annulation
                                                                         </h3>
                                                                         <div class="mt-2">
                                                                             <p class="text-sm text-gray-500">
                                                                                 Êtes-vous sûr de vouloir annuler cette réservation ? 
                                                                                 Vous pourrez la réactiver plus tard si nécessaire.
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                 <form action="{{ route('reservations.status', $reservation->livre->id_livre) }}" method="POST" class="inline">
                                                                     @csrf
                                                                     @method('PUT')
                                                                     <input type="hidden" name="status" value="annulee">
                                                                     <button type="submit" 
                                                                             class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                         Confirmer
                                                                     </button>
                                                                 </form>
                                                                 <button type="button" 
                                                                         @click="showConfirmAnnulerAdherent = false"
                                                                         class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                     Annuler
                                                                 </button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                     @endif
                                     
                                 </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reservations->hasPages())
                <div class="mt-8">
                    <div class="flex items-center justify-between">
                        <!-- Informations sur les résultats -->
                        <div class="text-sm text-gray-700">
                            Affichage de 
                            <span class="font-medium">{{ $reservations->firstItem() ?? 0 }}</span>
                            à 
                            <span class="font-medium">{{ $reservations->lastItem() ?? 0 }}</span>
                            sur 
                            <span class="font-medium">{{ $reservations->total() }}</span>
                            réservation(s)
                        </div>
                        
                        <!-- Navigation de pagination -->
                        <div class="flex items-center space-x-2">
                            <!-- Bouton Précédent -->
                            @if($reservations->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Précédent
                                </span>
                            @else
                                <a href="{{ $reservations->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Précédent
                                </a>
                            @endif
                            
                            <!-- Numéros de pages -->
                            <div class="flex items-center space-x-1">
                                @foreach($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                                    @if($page == $reservations->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-purple-600 rounded-lg">
                                            {{ $page }}
                                        </span>
                                    @elseif($page == 1 || $page == $reservations->lastPage() || ($page >= $reservations->currentPage() - 2 && $page <= $reservations->currentPage() + 2))
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                            {{ $page }}
                                        </a>
                                    @elseif($page == $reservations->currentPage() - 3 || $page == $reservations->currentPage() + 3)
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400">
                                            ...
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                            
                            <!-- Bouton Suivant -->
                            @if($reservations->hasMorePages())
                                <a href="{{ $reservations->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    Suivant
                                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                    Suivant
                                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune réservation</h3>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore de réservations. Parcourez notre catalogue pour réserver des livres !</p>
                <a href="{{ route('livres.index') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Parcourir le catalogue
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Accueil</a></li>
                        <li><a href="{{ route('livres.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Catalogue</a></li>
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
