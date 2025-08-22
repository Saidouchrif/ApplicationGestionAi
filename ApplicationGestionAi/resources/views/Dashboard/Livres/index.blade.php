@extends('layouts.tailwind')

@section('title', 'Gestion des livres - Bib Readers')

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-extrabold">📚 Gestion des Livres</h1>
            <p class="mt-4 text-blue-100 text-lg">Ajouter, modifier ou supprimer des livres de la bibliothèque.</p>
        </div>
    </div>

    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- ✅ Message de succès -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md flex justify-between items-center">
                <span>✅ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">✖</button>
            </div>
        @endif

        <!-- Actions Header -->
        <div class="flex justify-between items-center mb-6 space-x-2">
            <form method="GET" action="{{ route('livresindex') }}" class="flex">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un livre..."
                       class="flex-1 px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-md">Rechercher</button>
            </form>

            <div class="flex space-x-2">
                <a href="{{ route('livres.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                    ➕ Ajouter un Livre
                </a>

                <!-- 🔙 Retour Accueil -->
                <a href="{{ route('home') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow">
                    ⬅️ Retour à l'accueil
                </a>
            </div>
        </div>

        @if($livres->count() === 0)
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
                Aucun livre trouvé.
            </div>
        @else
            <!-- Table CRUD -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse bg-white rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700 text-left">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Titre</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3">Image</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3">Prix</th> <!-- جديد -->
                            <th class="px-4 py-3">Rating</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($livres as $livre)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $livre->id_livre }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $livre->titre }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ Str::limit($livre->description, 50) }}</td>
                                <td class="px-4 py-3">
                                    @if($livre->image_url)
                                        <img src="{{ asset('storage/'.$livre->image_url) }}" class="h-12 w-12 rounded object-cover">
                                    @else
                                        <span class="text-gray-400">Pas d'image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($livre->stock > 0)
                                        <span class="text-green-600 font-medium">{{ $livre->stock }} dispo</span>
                                    @else
                                        <span class="text-red-600 font-medium">Épuisé</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3"> <!-- جديد -->
                                    {{ number_format($livre->price, 2, ',', ' ') }} MAD
                                </td>
                                <td class="px-4 py-3">
                                    ⭐ {{ $livre->rating }}/5
                                </td>
                                <td class="px-4 py-3 text-center flex justify-center space-x-2">
                                    <a href="{{ route('livres.show', $livre->id_livre) }}"
                                       class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                        👁️ Voir
                                    </a>
                                    <a href="{{route('livres.edit',$livre->id_livre)}}"
                                       class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
                                        ✏️ Modifier
                                    </a>
                                    <button onclick="openModal({{ $livre->id_livre }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                        🗑️ Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $livres->appends(['q' => request('q')])->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmation Suppression -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-96 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">⚠️ Confirmation</h2>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer ce livre ?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="px-3 py-1 bg-gray-400 hover:bg-gray-500 text-white rounded text-sm">Annuler</button>
                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                    🗑️ Supprimer
                </button>
            </div>
        </form>        
    </div>
</div>

<script>
function openModal(id) {
    let form = document.getElementById('deleteForm');
    form.action = "/Books/delete/" + id; // conforme à Route::resource
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
