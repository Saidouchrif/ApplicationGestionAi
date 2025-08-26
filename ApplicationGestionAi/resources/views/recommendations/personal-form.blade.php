@extends('layouts.tailwind')

@section('title', 'Recommandations Personnalisées - Bib Readers')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
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
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->nom }}</span>
                            </button>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Connexion</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-6 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                🤖 Recommandations IA Personnalisées
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Découvrez de nouveaux livres en nous parlant de ceux que vous avez aimés. 
                Notre IA analysera vos préférences pour vous proposer des suggestions pertinentes.
            </p>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <form id="recommendationForm" class="space-y-6">
                @csrf
                
                <!-- Books Container -->
                <div id="booksContainer" class="space-y-6">
                    <!-- First Book (always present) -->
                    <div class="book-entry bg-gray-50 rounded-xl p-6 border-2 border-dashed border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Livre #1</h3>
                            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeBook(this)" style="display: none;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre du livre *
                                </label>
                                <input type="text" name="books[0][title]" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                       placeholder="Ex: Le Petit Prince">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Description ou résumé *
                                </label>
                                <textarea name="books[0][description]" required rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                                          placeholder="Décrivez brièvement l'histoire, le genre, les thèmes..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Book Button -->
                <div class="text-center">
                    <button type="button" onclick="addBook()" 
                            class="inline-flex items-center px-6 py-3 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un autre livre
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-6">
                    <button type="submit" id="submitBtn"
                            class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors font-semibold text-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Obtenir mes recommandations
                    </button>
                </div>
            </form>
        </div>

        <!-- Loading Section -->
        <div id="loadingSection" class="hidden bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-4"></div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Analyse en cours...</h3>
            <p class="text-gray-600">Notre IA analyse vos préférences pour trouver les meilleures recommandations.</p>
        </div>

        <!-- Results Section -->
        <div id="resultsSection" class="hidden">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">🎯 Vos recommandations</h2>
                    <p class="text-gray-600">Basé sur vos préférences, voici ce que nous vous suggérons :</p>
                </div>

                <div id="recommendationsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Recommendations will be inserted here -->
                </div>

                <div class="text-center mt-8">
                    <button onclick="resetForm()" 
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Nouvelle recherche
                    </button>
                </div>
            </div>
        </div>

        <!-- Error Section -->
        <div id="errorSection" class="hidden bg-red-50 border border-red-200 rounded-2xl p-8 text-center">
            <div class="text-red-600 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-red-900 mb-2">Erreur</h3>
            <p id="errorMessage" class="text-red-700 mb-4"></p>
            <button onclick="resetForm()" 
                    class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                Réessayer
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let bookCount = 1;

function addBook() {
    bookCount++;
    const container = document.getElementById('booksContainer');
    const newBook = document.createElement('div');
    newBook.className = 'book-entry bg-gray-50 rounded-xl p-6 border-2 border-dashed border-gray-200';
    newBook.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Livre #${bookCount}</h3>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeBook(this)">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du livre *
                </label>
                <input type="text" name="books[${bookCount-1}][title]" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                       placeholder="Ex: Le Petit Prince">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description ou résumé *
                </label>
                <textarea name="books[${bookCount-1}][description]" required rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                          placeholder="Décrivez brièvement l'histoire, le genre, les thèmes..."></textarea>
            </div>
        </div>
    `;
    container.appendChild(newBook);
    
    // Show remove button for first book if we have more than one
    if (bookCount > 1) {
        const firstBook = container.querySelector('.book-entry');
        const firstRemoveBtn = firstBook.querySelector('button[onclick="removeBook(this)"]');
        firstRemoveBtn.style.display = 'block';
    }
}

function removeBook(button) {
    const bookEntry = button.closest('.book-entry');
    bookEntry.remove();
    bookCount--;
    
    // Renumber books
    const books = document.querySelectorAll('.book-entry');
    books.forEach((book, index) => {
        const title = book.querySelector('h3');
        title.textContent = `Livre #${index + 1}`;
        
        const inputs = book.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
        });
    });
    
    // Hide remove button for first book if only one remains
    if (bookCount === 1) {
        const firstBook = document.querySelector('.book-entry');
        const firstRemoveBtn = firstBook.querySelector('button[onclick="removeBook(this)"]');
        firstRemoveBtn.style.display = 'none';
    }
}

function resetForm() {
    // Reset form
    document.getElementById('recommendationForm').reset();
    
    // Remove extra books
    const container = document.getElementById('booksContainer');
    const books = container.querySelectorAll('.book-entry');
    for (let i = 1; i < books.length; i++) {
        books[i].remove();
    }
    bookCount = 1;
    
    // Hide remove button for first book
    const firstRemoveBtn = books[0].querySelector('button[onclick="removeBook(this)"]');
    firstRemoveBtn.style.display = 'none';
    
    // Show form, hide other sections
    document.getElementById('recommendationForm').parentElement.style.display = 'block';
    document.getElementById('loadingSection').style.display = 'none';
    document.getElementById('resultsSection').style.display = 'none';
    document.getElementById('errorSection').style.display = 'none';
}

document.getElementById('recommendationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Show loading
    document.getElementById('recommendationForm').parentElement.style.display = 'none';
    document.getElementById('loadingSection').style.display = 'block';
    document.getElementById('resultsSection').style.display = 'none';
    document.getElementById('errorSection').style.display = 'none';
    
    try {
        const formData = new FormData(this);
        const response = await fetch('{{ route("recommendations.personal.submit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayRecommendations(data.recommendations);
        } else {
            throw new Error(data.message || 'Erreur lors de la génération des recommandations');
        }
        
    } catch (error) {
        showError(error.message);
    }
});

function displayRecommendations(recommendations) {
    const grid = document.getElementById('recommendationsGrid');
    grid.innerHTML = '';
    
    if (recommendations.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full text-center py-8">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <p class="text-gray-500">Aucune recommandation trouvée pour le moment.</p>
                <p class="text-sm text-gray-400 mt-2">Essayez d'ajouter plus de détails sur vos livres préférés.</p>
            </div>
        `;
    } else {
        recommendations.forEach(book => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:scale-105 transition duration-300';
            card.innerHTML = `
                <div class="relative">
                    ${book.image_url ? 
                        `<img src="${book.image_url.startsWith('http') ? book.image_url : '/storage/' + book.image_url}" 
                              alt="${book.titre}" class="w-full h-48 object-cover">` :
                        `<div class="w-full h-48 bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>`
                    }
                    
                    <div class="absolute top-2 right-2 bg-indigo-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                        ${Math.round(book.similarity_score * 100)}% similaire
                    </div>
                    
                    ${book.price > 0 ? 
                        `<div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded-lg text-xs font-semibold shadow-lg">
                            💰 ${parseFloat(book.price).toFixed(2)} MAD
                        </div>` : ''
                    }
                </div>
                
                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-900 truncate mb-2">${book.titre}</h4>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">${book.description}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Stock: ${book.stock}</span>
                        <div class="flex items-center">
                            ${Array.from({length: 5}, (_, i) => 
                                `<svg class="w-3 h-3 ${i < book.rating ? 'text-yellow-400' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>`
                            ).join('')}
                        </div>
                    </div>
                    
                    <a href="/livres/${book.id_livre}" class="mt-3 block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
                        Voir détails
                    </a>
                </div>
            `;
            grid.appendChild(card);
        });
    }
    
    // Show results
    document.getElementById('loadingSection').style.display = 'none';
    document.getElementById('resultsSection').style.display = 'block';
}

function showError(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('loadingSection').style.display = 'none';
    document.getElementById('errorSection').style.display = 'block';
}
</script>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
