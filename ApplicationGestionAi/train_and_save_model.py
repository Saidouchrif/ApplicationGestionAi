#!/usr/bin/env python3
"""
Script pour entraîner et sauvegarder le modèle de recommandation de livres
"""

import sys
import os
from recommendation_model import BookRecommendationModel

def main():
    print("=" * 60)
    print("🤖 ENTRAÎNEMENT DU MODÈLE DE RECOMMANDATION DE LIVRES")
    print("=" * 60)
    
    try:
        # Créer une instance du modèle
        print("\n📚 Création de l'instance du modèle...")
        model = BookRecommendationModel()
        
        # Étape 1: Charger les données depuis la base de données
        print("\n🔄 ÉTAPE 1: Chargement des données depuis la base de données...")
        print("   - Connexion à MySQL...")
        print("   - Récupération des livres avec descriptions...")
        print("   - Nettoyage des descriptions...")
        
        if not model.load_books_data():
            print("❌ Échec du chargement des données")
            print("   Vérifiez que:")
            print("   - MySQL est démarré")
            print("   - La base de données 'application_gestion_ai' existe")
            print("   - La table 'livres' contient des données avec descriptions")
            return False
        
        print(f"✅ {len(model.books_data)} livres chargés avec succès")
        
        # Étape 2: Entraîner le modèle TF-IDF
        print("\n🔄 ÉTAPE 2: Entraînement du modèle TF-IDF...")
        print("   - Application du TF-IDF Vectorizer...")
        print("   - Transformation des descriptions en vecteurs numériques...")
        print("   - Calcul de la matrice de similarité cosinus...")
        
        model.train_model()
        
        # Afficher les informations du modèle
        info = model.get_model_info()
        print(f"✅ Modèle TF-IDF entraîné avec succès!")
        print(f"   - Nombre de features TF-IDF: {info['tfidf_features']}")
        print(f"   - Matrice de similarité: {info['similarity_matrix_shape']}")
        
        # Étape 3: Sauvegarder le modèle
        print("\n🔄 ÉTAPE 3: Sauvegarde du modèle...")
        print("   - Sauvegarde du TF-IDF Vectorizer...")
        print("   - Sauvegarde de la matrice de similarité...")
        print("   - Sauvegarde des données des livres...")
        
        model_path = 'book_recommendation_model.pkl'
        model.save_model(model_path)
        
        # Vérifier que le fichier a été créé
        if os.path.exists(model_path):
            file_size = os.path.getsize(model_path) / (1024 * 1024)  # Taille en MB
            print(f"✅ Modèle sauvegardé avec succès!")
            print(f"   - Fichier: {model_path}")
            print(f"   - Taille: {file_size:.2f} MB")
        else:
            print("❌ Erreur: Le fichier de modèle n'a pas été créé")
            return False
        
        # Étape 4: Test du modèle
        print("\n🔄 ÉTAPE 4: Test du modèle...")
        if info['books_count'] > 0:
            first_book_id = model.books_data.iloc[0]['id_livre']
            first_book_title = model.books_data.iloc[0]['titre']
            
            print(f"   - Test avec le livre: '{first_book_title}' (ID: {first_book_id})")
            
            recommendations = model.get_recommendations(first_book_id, 3)
            print(f"✅ {len(recommendations)} recommandations générées:")
            
            for i, rec in enumerate(recommendations, 1):
                print(f"   {i}. {rec['titre']} (Score: {rec['similarity_score']:.3f})")
        
        # Résumé final
        print("\n" + "=" * 60)
        print("🎉 ENTRAÎNEMENT TERMINÉ AVEC SUCCÈS!")
        print("=" * 60)
        print(f"📊 Résumé:")
        print(f"   - Livres traités: {info['books_count']}")
        print(f"   - Features TF-IDF: {info['tfidf_features']}")
        print(f"   - Modèle sauvegardé: {model_path}")
        print(f"   - Prêt pour l'API FastAPI!")
        
        print("\n🚀 Prochaines étapes:")
        print("   1. Démarrer l'API FastAPI: python recommendation_api.py")
        print("   2. Tester l'API: http://localhost:8000/docs")
        print("   3. Intégrer avec Laravel")
        
        return True
        
    except Exception as e:
        print(f"\n❌ ERREUR LORS DE L'ENTRAÎNEMENT: {e}")
        print("\n🔧 Solutions possibles:")
        print("   - Vérifiez que MySQL est démarré")
        print("   - Vérifiez les paramètres de connexion à la base de données")
        print("   - Assurez-vous d'avoir des livres avec descriptions dans la base")
        print("   - Vérifiez que toutes les dépendances Python sont installées")
        return False

if __name__ == "__main__":
    success = main()
    if not success:
        sys.exit(1)
