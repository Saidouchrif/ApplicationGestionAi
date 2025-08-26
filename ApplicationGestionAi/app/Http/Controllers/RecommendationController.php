<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Livre;

class RecommendationController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8000';

    /**
     * Obtenir les recommandations pour un livre donné
     */
    public function getRecommendations(Request $request, $bookId)
    {
        try {
            $nRecommendations = $request->get('limit', 5);
            
            // Vérifier que le livre existe
            $book = Livre::find($bookId);
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Livre non trouvé'
                ], 404);
            }

            // Appeler l'API FastAPI
            $response = Http::timeout(10)->post($this->apiBaseUrl . '/recommendations', [
                'book_id' => (int) $bookId,
                'n_recommendations' => (int) $nRecommendations
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                Log::error('Erreur API recommandation', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la récupération des recommandations'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Exception dans getRecommendations', [
                'error' => $e->getMessage(),
                'book_id' => $bookId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur'
            ], 500);
        }
    }

    /**
     * Obtenir les recommandations populaires (basées sur les livres les plus empruntés)
     */
    public function getPopularRecommendations(Request $request)
    {
        try {
            $limit = $request->get('limit', 5);
            
            // Obtenir les livres les plus populaires (avec le plus d'emprunts)
            $popularBooks = Livre::withCount('emprunts')
                ->orderBy('emprunts_count', 'desc')
                ->limit($limit)
                ->get();

            if ($popularBooks->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun livre populaire trouvé'
                ], 404);
            }

            // Obtenir les recommandations pour le premier livre populaire
            $firstBook = $popularBooks->first();
            $recommendations = $this->getRecommendationsForBook($firstBook->id_livre, $limit);

            return response()->json([
                'success' => true,
                'message' => 'Recommandations populaires récupérées',
                'popular_books' => $popularBooks,
                'recommendations' => $recommendations
            ]);

        } catch (\Exception $e) {
            Log::error('Exception dans getPopularRecommendations', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur'
            ], 500);
        }
    }

    /**
     * Obtenir les recommandations basées sur l'historique d'un utilisateur
     */
    public function getUserRecommendations(Request $request)
    {
        try {
            $userId = $request->user()->id ?? null;
            $limit = $request->get('limit', 5);

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Obtenir l'historique d'emprunts de l'utilisateur
            $userEmprunts = \App\Models\Emprunt::where('id_adherent', $userId)
                ->with('livre')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            if ($userEmprunts->isEmpty()) {
                // Si pas d'historique, retourner des recommandations populaires
                return $this->getPopularRecommendations($request);
            }

            // Obtenir les recommandations basées sur le dernier livre emprunté
            $lastEmprunt = $userEmprunts->first();
            $recommendations = $this->getRecommendationsForBook($lastEmprunt->livre->id_livre, $limit);

            return response()->json([
                'success' => true,
                'message' => 'Recommandations personnalisées récupérées',
                'user_history' => $userEmprunts,
                'recommendations' => $recommendations
            ]);

        } catch (\Exception $e) {
            Log::error('Exception dans getUserRecommendations', [
                'error' => $e->getMessage(),
                'user_id' => $userId ?? 'non défini'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur'
            ], 500);
        }
    }

    /**
     * Vérifier l'état de l'API de recommandation
     */
    public function checkApiHealth()
    {
        try {
            $response = Http::timeout(5)->get($this->apiBaseUrl . '/health');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'api_status' => 'healthy',
                    'model_loaded' => $data['model_loaded'] ?? false,
                    'total_books' => $data['total_books'] ?? 0
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'api_status' => 'unhealthy',
                    'message' => 'API de recommandation non disponible'
                ], 503);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'api_status' => 'unreachable',
                'message' => 'Impossible de contacter l\'API de recommandation'
            ], 503);
        }
    }

    /**
     * Méthode privée pour obtenir les recommandations d'un livre
     */
    private function getRecommendationsForBook($bookId, $limit)
    {
        try {
            $response = Http::timeout(10)->post($this->apiBaseUrl . '/recommendations', [
                'book_id' => (int) $bookId,
                'n_recommendations' => (int) $limit
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['recommendations'] ?? [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Erreur dans getRecommendationsForBook', [
                'error' => $e->getMessage(),
                'book_id' => $bookId
            ]);
            return [];
        }
    }

    /**
     * Obtenir les détails d'un livre avec ses recommandations
     */
    public function getBookWithRecommendations($bookId)
    {
        try {
            $book = Livre::find($bookId);
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Livre non trouvé'
                ], 404);
            }

            // Obtenir les recommandations
            $recommendations = $this->getRecommendationsForBook($bookId, 5);

            return response()->json([
                'success' => true,
                'book' => $book,
                'recommendations' => $recommendations
            ]);

        } catch (\Exception $e) {
            Log::error('Exception dans getBookWithRecommendations', [
                'error' => $e->getMessage(),
                'book_id' => $bookId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur'
            ], 500);
        }
    }
}
