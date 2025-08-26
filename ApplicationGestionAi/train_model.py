#!/usr/bin/env python3
"""
Script pour entraîner et sauvegarder le modèle de recommandation de livres
"""

import sys
import os

# Ajouter le répertoire courant au path Python
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from recommendation_model import BookRecommendationModel

def main():
    print("🚀 Démarrage de l'entraînement du modèle de recommandation...")
    
    # Créer une instance du modèle
    model = BookRecommendationModel()
    
    # Charger les données depuis la base de données
    print("📚 Chargement des données depuis la base de données...")
    if not model.load_books_data():
        print("❌ Erreur: Impossible de charger les données depuis la base de données")
        print("   Vérifiez que:")
        print("   - MySQL est démarré")
        print("   - La base de données 'application_gestion_ai' existe")
        print("   - Les paramètres de connexion sont corrects")
        return False
    
    # Entraîner le modèle
    print("🤖 Entraînement du modèle TF-IDF et calcul de la similarité...")
    if not model.train_model():
        print("❌ Erreur: Impossible d'entraîner le modèle")
        return False
    
    # Sauvegarder le modèle
    print("💾 Sauvegarde du modèle...")
    model_path = 'book_recommendation_model.pkl'
    if model.save_model(model_path):
        print(f"✅ Modèle sauvegardé avec succès dans {model_path}")
        
        # Test des recommandations
        if len(model.books_data) > 0:
            first_book_id = model.books_data.iloc[0]['id_livre']
            first_book_title = model.books_data.iloc[0]['titre']
            print(f"\n🧪 Test des recommandations pour '{first_book_title}' (ID: {first_book_id}):")
            
            recommendations = model.get_recommendations(first_book_id, 3)
            
            if recommendations:
                for i, rec in enumerate(recommendations, 1):
                    print(f"   {i}. {rec['titre']} (Score: {rec['similarity_score']:.3f})")
            else:
                print("   Aucune recommandation trouvée")
        
        print(f"\n📊 Statistiques du modèle:")
        print(f"   - Nombre total de livres: {len(model.books_data)}")
        print(f"   - Features TF-IDF: {model.tfidf_matrix.shape[1]}")
        print(f"   - Taille de la matrice de similarité: {model.similarity_matrix.shape[0]}x{model.similarity_matrix.shape[1]}")
        
        return True
    else:
        print("❌ Erreur: Impossible de sauvegarder le modèle")
        return False

if __name__ == "__main__":
    success = main()
    if success:
        print("\n🎉 Entraînement terminé avec succès!")
        print("   Vous pouvez maintenant démarrer l'API FastAPI avec:")
        print("   python recommendation_api.py")
    else:
        print("\n💥 Entraînement échoué!")
        sys.exit(1)
