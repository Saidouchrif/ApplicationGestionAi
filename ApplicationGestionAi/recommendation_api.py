#!/usr/bin/env python3
"""
API FastAPI pour le système de recommandation de livres
"""

from fastapi import FastAPI, HTTPException, BackgroundTasks
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from typing import List, Optional
import uvicorn
import logging
from recommendation_model import BookRecommendationModel
import os

# Configuration du logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Création de l'application FastAPI
app = FastAPI(
    title="API de Recommandation de Livres",
    description="API pour recommander des livres basée sur TF-IDF et similarité cosinus",
    version="1.0.0"
)

# Configuration CORS pour permettre les requêtes depuis Laravel
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # En production, spécifiez les domaines autorisés
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Modèles Pydantic pour les requêtes et réponses
class RecommendationRequest(BaseModel):
    book_id: int
    n_recommendations: int = 5

class PersonalRecommendationRequest(BaseModel):
    books: List[dict]  # Liste de livres avec titre et description

class BookInfo(BaseModel):
    id_livre: int
    titre: str
    description: str
    image_url: Optional[str] = None
    stock: int
    rating: int
    price: float
    similarity_score: float

class RecommendationResponse(BaseModel):
    success: bool
    message: str
    recommendations: List[BookInfo]
    total_recommendations: int

class HealthResponse(BaseModel):
    status: str
    message: str
    model_info: dict

# Instance globale du modèle
model = None

def load_model():
    """Charge le modèle au démarrage de l'API"""
    global model
    try:
        model = BookRecommendationModel()
        if os.path.exists('book_recommendation_model.pkl'):
            model.load_model('book_recommendation_model.pkl')
            logger.info("Modèle chargé avec succès")
        else:
            logger.warning("Fichier de modèle non trouvé, entraînement nécessaire")
            model = None
    except Exception as e:
        logger.error(f"Erreur lors du chargement du modèle: {e}")
        model = None

@app.on_event("startup")
async def startup_event():
    """Événement de démarrage de l'API"""
    logger.info("🚀 Démarrage de l'API de recommandation...")
    load_model()

@app.get("/", response_model=dict)
async def root():
    """Point d'entrée principal de l'API"""
    return {
        "message": "API de Recommandation de Livres",
        "version": "1.0.0",
        "status": "active",
        "endpoints": {
            "health": "/health",
            "recommendations": "/recommendations",
            "personal": "/personal",
            "books": "/books",
            "docs": "/docs"
        }
    }

@app.get("/health", response_model=HealthResponse)
async def health_check():
    """Vérification de l'état de l'API et du modèle"""
    try:
        if model is None or model.similarity_matrix is None:
            return HealthResponse(
                status="warning",
                message="Modèle non disponible",
                model_info={"is_loaded": False}
            )
        
        info = model.get_model_info()
        return HealthResponse(
            status="healthy",
            message="API et modèle opérationnels",
            model_info=info
        )
    except Exception as e:
        logger.error(f"Erreur lors de la vérification de santé: {e}")
        return HealthResponse(
            status="error",
            message=f"Erreur: {str(e)}",
            model_info={"is_loaded": False}
        )

@app.get("/books", response_model=dict)
async def get_all_books():
    """Récupère tous les livres disponibles"""
    try:
        if model is None or model.books_data is None:
            raise HTTPException(
                status_code=503,
                detail="Modèle non disponible"
            )
        
        books = model.books_data.to_dict('records')
        return {
            "success": True,
            "total_books": len(books),
            "books": books[:50]  # Limiter à 50 livres pour éviter les réponses trop grandes
        }
    except Exception as e:
        logger.error(f"Erreur lors de la récupération des livres: {e}")
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de la récupération des livres: {str(e)}"
        )

@app.get("/books/{book_id}", response_model=dict)
async def get_book(book_id: int):
    """Récupère un livre spécifique par son ID"""
    try:
        if model is None or model.books_data is None:
            raise HTTPException(
                status_code=503,
                detail="Modèle non disponible"
            )
        
        book = model.books_data[model.books_data['id_livre'] == book_id]
        if book.empty:
            raise HTTPException(
                status_code=404,
                detail=f"Livre avec l'ID {book_id} non trouvé"
            )
        
        return {
            "success": True,
            "book": book.iloc[0].to_dict()
        }
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Erreur lors de la récupération du livre {book_id}: {e}")
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de la récupération du livre: {str(e)}"
        )

@app.post("/recommendations", response_model=RecommendationResponse)
async def get_recommendations(request: RecommendationRequest):
    """Obtient des recommandations pour un livre spécifique"""
    try:
        if model is None or model.similarity_matrix is None:
            raise HTTPException(
                status_code=503,
                detail="Modèle de recommandation non disponible"
            )
        
        recommendations = model.get_recommendations(
            request.book_id, 
            request.n_recommendations
        )
        
        return RecommendationResponse(
            success=True,
            message=f"Recommandations trouvées pour le livre ID {request.book_id}",
            recommendations=recommendations,
            total_recommendations=len(recommendations)
        )
        
    except ValueError as e:
        raise HTTPException(
            status_code=404,
            detail=str(e)
        )
    except Exception as e:
        logger.error(f"Erreur lors de l'obtention des recommandations: {e}")
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'obtention des recommandations: {str(e)}"
        )

@app.post("/personal", response_model=RecommendationResponse)
async def get_personal_recommendations(request: PersonalRecommendationRequest):
    """Obtient des recommandations personnalisées basées sur les livres saisis"""
    try:
        if model is None or model.similarity_matrix is None:
            raise HTTPException(
                status_code=503,
                detail="Modèle de recommandation non disponible"
            )
        
        # Logique pour les recommandations personnalisées
        # Pour l'instant, on retourne les livres les plus populaires
        # Cette logique peut être améliorée selon vos besoins
        
        # Trier par rating et stock
        popular_books = model.books_data.sort_values(
            by=['rating', 'stock'], 
            ascending=[False, False]
        ).head(8)
        
        recommendations = []
        for _, book in popular_books.iterrows():
            book_dict = book.to_dict()
            book_dict['similarity_score'] = 0.5  # Score par défaut pour les recommandations populaires
            recommendations.append(book_dict)
        
        return RecommendationResponse(
            success=True,
            message="Recommandations personnalisées générées",
            recommendations=recommendations,
            total_recommendations=len(recommendations)
        )
        
    except Exception as e:
        logger.error(f"Erreur lors de l'obtention des recommandations personnalisées: {e}")
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors de l'obtention des recommandations personnalisées: {str(e)}"
        )

@app.post("/reload-model")
async def reload_model(background_tasks: BackgroundTasks):
    """Recharge le modèle (utile après mise à jour des données)"""
    try:
        background_tasks.add_task(load_model)
        return {
            "success": True,
            "message": "Rechargement du modèle en cours..."
        }
    except Exception as e:
        logger.error(f"Erreur lors du rechargement du modèle: {e}")
        raise HTTPException(
            status_code=500,
            detail=f"Erreur lors du rechargement du modèle: {str(e)}"
        )

if __name__ == "__main__":
    # Démarrage du serveur
    print("🚀 Démarrage de l'API de recommandation...")
    print("📖 Documentation disponible sur: http://localhost:5000/docs")
    print("🔍 Test de santé sur: http://localhost:5000/health")
    
    uvicorn.run(
        "recommendation_api:app",
        host="0.0.0.0",
        port=5000,
        reload=True,
        log_level="info"
    )
