@extends('layouts.tailwind')

@section('title', 'Gestion des adhérents')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">📋 Liste des Adhérents</h1>

        <a href="{{ route('adherents.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
            ➕ Ajouter un Adhérent
        </a>
    </div>

    <!-- Barre de recherche -->
    <form method="GET" action="{{ route('adherentindex') }}" class="mb-6 flex">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Rechercher un adhérent..."
               class="flex-1 px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-md">Rechercher</button>
    </form>

    <!-- Message succès -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md flex justify-between items-center">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">✖</button>
        </div>
    @endif

    @if($adherent->count() === 0)
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
            Aucun adhérent trouvé.
        </div>
    @else
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Date inscription</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($adherent as $a)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $a->id_adherent }}</td>
                            <td class="px-4 py-2 border">{{ $a->nom }}</td>
                            <td class="px-4 py-2 border">{{ $a->email }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($a->date_inscription)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-2 border text-center flex justify-center space-x-2">
                                <a href="{{ route('adherent.edit', $a->id_adherent) }}"
                                   class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
                                   ✏️ Modifier
                                </a>
                                <form action="{{ route('adherent.destroy', $a->id_adherent) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet adhérent ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $adherent->appends(['q' => request('q')])->links() }}
        </div>
    @endif
</div>
@endsection
