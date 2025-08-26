<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Livre;

class PersonalRecommendationController extends Controller
{
    private $apiBaseUrl = 'http://localhost:5000';

    /**
     * Afficher le formulaire de recommandations personnalisées
     */
    public function showForm()
    {
        return view('recommendations.personal-form');
    }

    /**
     * Traiter les livres saisis et obtenir des recommandations
     */
    public function getRecommendations(Request $request)
    {
        $request->validate([
            'books' => 'required|array|min:1',
            'books.*.title' => 'required|string|max:255',
            'books.*.description' => 'required|string|max:1000'
        ]);

        try {
            $userBooks = $request->input('books');
            
            // Appeler l'API FastAPI pour les recommandations personnalisées
            $response = Http::timeout(10)->post($this->apiBaseUrl . '/personal', [
                'books' => $userBooks
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                // Fallback: utiliser la logique locale si l'API n'est pas disponible
                Log::warning('API FastAPI non disponible, utilisation du fallback local');
                
                $recommendations = [];
                foreach ($userBooks as $userBook) {
                    $similarBooks = $this->findSimilarBooks($userBook['title'], $userBook['description']);
                    $recommendations = array_merge($recommendations, $similarBooks);
                }

                $recommendations = $this->sortAndDeduplicate($recommendations);
                $recommendations = array_slice($recommendations, 0, 8);

                return response()->json([
                    'success' => true,
                    'recommendations' => $recommendations,
                    'message' => 'Recommandations trouvées ! (Mode fallback)'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Erreur recommandations personnalisées', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération des recommandations'
            ], 500);
        }
    }

    /**
     * Chercher des livres similaires dans notre base
     */
    private function findSimilarBooks($title, $description)
    {
        try {
            // Recherche par mots-clés dans le titre et la description
            $keywords = $this->extractKeywords($title . ' ' . $description);
            
            $similarBooks = Livre::where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('titre', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%");
                }
            })
            ->where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->limit(4)
            ->get()
            ->toArray();

            // Ajouter un score de similarité basé sur les mots-clés communs
            foreach ($similarBooks as &$book) {
                $book['similarity_score'] = $this->calculateSimilarityScore($keywords, $book);
            }

            // Trier par score de similarité
            usort($similarBooks, function($a, $b) {
                return $b['similarity_score'] <=> $a['similarity_score'];
            });

            return $similarBooks;

        } catch (\Exception $e) {
            Log::error('Erreur recherche livres similaires', [
                'error' => $e->getMessage(),
                'title' => $title
            ]);
            return [];
        }
    }

    /**
     * Extraire les mots-clés du texte
     */
    private function extractKeywords($text)
    {
        // Nettoyer le texte
        $text = strtolower($text);
        $text = preg_replace('/[^a-zà-ÿ\s]/', ' ', $text);
        
        // Mots à ignorer
        $stopWords = ['le', 'la', 'les', 'un', 'une', 'des', 'et', 'ou', 'mais', 'pour', 'avec', 'sur', 'dans', 'par', 'de', 'du', 'ce', 'ces', 'cette', 'son', 'sa', 'ses', 'mon', 'ma', 'mes', 'ton', 'ta', 'tes', 'notre', 'votre', 'leur', 'leurs', 'qui', 'que', 'quoi', 'où', 'quand', 'comment', 'pourquoi', 'est', 'sont', 'était', 'étaient', 'être', 'avoir', 'faire', 'aller', 'voir', 'dire', 'pouvoir', 'vouloir', 'devoir', 'savoir', 'venir', 'prendre', 'donner', 'mettre', 'passer', 'rester', 'partir', 'arriver', 'entrer', 'sortir', 'monter', 'descendre', 'ouvrir', 'fermer', 'commencer', 'finir', 'trouver', 'chercher', 'regarder', 'écouter', 'parler', 'écrire', 'lire', 'comprendre', 'penser', 'croire', 'aimer', 'vouloir', 'pouvoir', 'devoir', 'falloir', 'sembler', 'paraître', 'devenir', 'rester', 'rester', 'rester'];
        
        // Diviser en mots
        $words = preg_split('/\s+/', $text);
        
        // Filtrer les mots courts et les mots vides
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
        
        // Retourner les mots uniques
        return array_unique(array_values($keywords));
    }

    /**
     * Calculer un score de similarité
     */
    private function calculateSimilarityScore($keywords, $book)
    {
        $bookText = strtolower($book['titre'] . ' ' . $book['description']);
        $bookText = preg_replace('/[^a-zà-ÿ\s]/', ' ', $bookText);
        
        $commonWords = 0;
        foreach ($keywords as $keyword) {
            if (strpos($bookText, $keyword) !== false) {
                $commonWords++;
            }
        }
        
        return $commonWords / max(count($keywords), 1);
    }

    /**
     * Trier et dédupliquer les recommandations
     */
    private function sortAndDeduplicate($recommendations)
    {
        // Supprimer les doublons basés sur l'ID du livre
        $uniqueBooks = [];
        foreach ($recommendations as $book) {
            $uniqueBooks[$book['id_livre']] = $book;
        }
        
        // Trier par score de similarité
        usort($uniqueBooks, function($a, $b) {
            return $b['similarity_score'] <=> $a['similarity_score'];
        });
        
        return array_values($uniqueBooks);
    }
}
