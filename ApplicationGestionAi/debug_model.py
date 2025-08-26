#!/usr/bin/env python3
"""
Script de débogage pour identifier les problèmes avec l'entraînement
"""

import traceback
import sys
from recommendation_model import BookRecommendationModel

def debug_model():
    print("🔍 Débogage du modèle de recommandation...")
    
    try:
        # Test 1: Création de l'instance
        print("\n1️⃣ Test de création de l'instance...")
        model = BookRecommendationModel()
        print("✅ Instance créée avec succès")
        
        # Test 2: Chargement des données
        print("\n2️⃣ Test de chargement des données...")
        success = model.load_books_data()
        
        if success:
            print(f"✅ Données chargées: {len(model.books_data)} livres")
            print(f"   Colonnes: {list(model.books_data.columns)}")
            
            # Afficher quelques exemples
            print("\n📖 Exemples de données:")
            for i in range(min(3, len(model.books_data))):
                book = model.books_data.iloc[i]
                print(f"   - {book['titre']}")
                print(f"     Description originale: {book['description'][:100]}...")
                print(f"     Description nettoyée: {book['description_clean'][:100]}...")
                print()
            
            # Test 3: Entraînement du modèle
            print("\n3️⃣ Test d'entraînement du modèle...")
            model.train_model()
            print("✅ Modèle entraîné avec succès")
            
            # Test 4: Informations du modèle
            info = model.get_model_info()
            print(f"\n📊 Informations du modèle:")
            print(f"   - Livres: {info['books_count']}")
            print(f"   - Features TF-IDF: {info['tfidf_features']}")
            print(f"   - Matrice: {info['similarity_matrix_shape']}")
            
            # Test 5: Sauvegarde
            print("\n4️⃣ Test de sauvegarde...")
            model.save_model('test_model.pkl')
            print("✅ Modèle sauvegardé")
            
            # Test 6: Recommandations
            print("\n5️⃣ Test des recommandations...")
            if info['books_count'] > 0:
                first_book_id = model.books_data.iloc[0]['id_livre']
                recommendations = model.get_recommendations(first_book_id, 3)
                print(f"✅ {len(recommendations)} recommandations générées pour le livre ID {first_book_id}")
                
                for i, rec in enumerate(recommendations, 1):
                    print(f"   {i}. {rec['titre']} (Score: {rec['similarity_score']:.3f})")
            
            print("\n🎉 Tous les tests sont passés avec succès!")
            return True
            
        else:
            print("❌ Échec du chargement des données")
            return False
            
    except Exception as e:
        print(f"\n❌ Erreur: {e}")
        print("\n🔍 Détails de l'erreur:")
        traceback.print_exc()
        return False

if __name__ == "__main__":
    success = debug_model()
    if not success:
        sys.exit(1)
