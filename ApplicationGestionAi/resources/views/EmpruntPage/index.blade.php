@extends('layouts.tailwind')

@section('title', 'Mes Emprunts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h2 class="text-2xl font-semibold mb-6">Mes Emprunts</h2>

    @if($emprunts->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
            Vous n'avez aucun emprunt en cours.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="text-left px-6 py-3 text-sm font-medium">Livre</th>
                        <th class="text-left px-6 py-3 text-sm font-medium">Date d'emprunt</th>
                        <th class="text-left px-6 py-3 text-sm font-medium">Date retour prévue</th>
                        <th class="text-left px-6 py-3 text-sm font-medium">Date retour effectif</th>
                        <th class="text-left px-6 py-3 text-sm font-medium">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprunts as $emprunt)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $emprunt->livre->titre ?? 'Livre supprimé' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $emprunt->date_retour_prevue ? \Carbon\Carbon::parse($emprunt->date_retour_prevu)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $emprunt->date_retour_effectif ? \Carbon\Carbon::parse($emprunt->date_retour_effectif)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($emprunt->statut === 'en_cours')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">En cours</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Retourné</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('livres.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
            Retour au catalogue
        </a>
    </div>
</div>
@endsection
