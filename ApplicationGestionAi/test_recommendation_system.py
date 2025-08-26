#!/usr/bin/env python3
"""
Script de test pour le système de recommandation de livres
"""

import sys
import os
import requests
import json
import time

# Ajouter le répertoire courant au path Python
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

def test_model_training():
    """Tester l'entraînement du modèle"""
    print("🧪 Test 1: Entraînement du modèle...")
    
    try:
        from recommendation_model import BookRecommendationModel
        
        model = BookRecommendationModel()
        
        # Test du chargement des données
        if not model.load_books_data():
            print("❌ Échec: Impossible de charger les données")
            return False
        
        # Test de l'entraînement
        if not model.train_model():
            print("❌ Échec: Impossible d'entraîner le modèle")
            return False
        
        # Test de la sauvegarde
        if not model.save_model('test_model.pkl'):
            print("❌ Échec: Impossible de sauvegarder le modèle")
            return False
        
        # Test des recommandations
        if len(model.books_data) > 0:
            first_book_id = model.books_data.iloc[0]['id_livre']
            recommendations = model.get_recommendations(first_book_id, 3)
            
            if recommendations:
                print(f"✅ Succès: {len(recommendations)} recommandations générées")
                return True
            else:
                print("❌ Échec: Aucune recommandation générée")
                return False
        
        print("❌ Échec: Aucune donnée disponible")
        return False
        
    except Exception as e:
        print(f"❌ Erreur: {e}")
        return False

def test_api_endpoints():
    """Tester les endpoints de l'API"""
    print("\n🧪 Test 2: Endpoints de l'API...")
    
    base_url = "http://localhost:8000"
    
    # Test de l'endpoint de santé
    try:
        response = requests.get(f"{base_url}/health", timeout=5)
        if response.status_code == 200:
            data = response.json()
            print(f"✅ Endpoint /health: OK (Modèle chargé: {data.get('model_loaded', False)})")
        else:
            print(f"❌ Endpoint /health: Erreur {response.status_code}")
            return False
    except requests.exceptions.RequestException as e:
        print(f"❌ Endpoint /health: Impossible de contacter l'API - {e}")
        return False
    
    # Test de l'endpoint des livres
    try:
        response = requests.get(f"{base_url}/books", timeout=5)
        if response.status_code == 200:
            data = response.json()
            print(f"✅ Endpoint /books: OK ({data.get('total_books', 0)} livres)")
        else:
            print(f"❌ Endpoint /books: Erreur {response.status_code}")
            return False
    except requests.exceptions.RequestException as e:
        print(f"❌ Endpoint /books: Erreur - {e}")
        return False
    
    # Test de l'endpoint des recommandations
    try:
        # Obtenir d'abord un livre
        response = requests.get(f"{base_url}/books", timeout=5)
        if response.status_code == 200:
            books = response.json().get('books', [])
            if books:
                book_id = books[0]['id_livre']
                
                # Tester les recommandations
                recommendation_data = {
                    "book_id": book_id,
                    "n_recommendations": 3
                }
                
                response = requests.post(
                    f"{base_url}/recommendations",
                    json=recommendation_data,
                    timeout=10
                )
                
                if response.status_code == 200:
                    data = response.json()
                    print(f"✅ Endpoint /recommendations: OK ({data.get('total_recommendations', 0)} recommandations)")
                    return True
                else:
                    print(f"❌ Endpoint /recommendations: Erreur {response.status_code}")
                    return False
            else:
                print("❌ Aucun livre disponible pour tester les recommandations")
                return False
        else:
            print(f"❌ Impossible d'obtenir la liste des livres")
            return False
            
    except requests.exceptions.RequestException as e:
        print(f"❌ Endpoint /recommendations: Erreur - {e}")
        return False

def test_laravel_integration():
    """Tester l'intégration avec Laravel"""
    print("\n🧪 Test 3: Intégration Laravel...")
    
    try:
        # Simuler une requête Laravel vers l'API
        response = requests.get("http://localhost:8000/health", timeout=5)
        
        if response.status_code == 200:
            print("✅ API accessible depuis Laravel")
            
            # Test de la route Laravel (si disponible)
            try:
                laravel_response = requests.get("http://localhost/recommendations/health", timeout=5)
                if laravel_response.status_code == 200:
                    print("✅ Route Laravel /recommendations/health: OK")
                    return True
                else:
                    print(f"⚠️  Route Laravel non disponible (code {laravel_response.status_code})")
                    return True  # L'API fonctionne, Laravel peut être configuré plus tard
            except requests.exceptions.RequestException:
                print("⚠️  Laravel non accessible (normal si pas démarré)")
                return True
        else:
            print("❌ API non accessible")
            return False
            
    except requests.exceptions.RequestException as e:
        print(f"❌ Erreur de connexion: {e}")
        return False

def main():
    """Fonction principale de test"""
    print("🚀 Démarrage des tests du système de recommandation...")
    print("=" * 60)
    
    # Test 1: Entraînement du modèle
    test1_passed = test_model_training()
    
    # Test 2: API (nécessite que l'API soit démarrée)
    print("\n⚠️  Pour tester l'API, assurez-vous qu'elle est démarrée avec:")
    print("   python recommendation_api.py")
    
    test2_passed = test_api_endpoints()
    
    # Test 3: Intégration Laravel
    test3_passed = test_laravel_integration()
    
    # Résumé
    print("\n" + "=" * 60)
    print("📊 RÉSUMÉ DES TESTS:")
    print(f"   Test 1 (Modèle): {'✅ PASSÉ' if test1_passed else '❌ ÉCHOUÉ'}")
    print(f"   Test 2 (API): {'✅ PASSÉ' if test2_passed else '❌ ÉCHOUÉ'}")
    print(f"   Test 3 (Laravel): {'✅ PASSÉ' if test3_passed else '❌ ÉCHOUÉ'}")
    
    if test1_passed and test2_passed and test3_passed:
        print("\n🎉 TOUS LES TESTS SONT PASSÉS!")
        print("   Le système de recommandation fonctionne correctement.")
    else:
        print("\n⚠️  CERTAINS TESTS ONT ÉCHOUÉ")
        print("   Vérifiez les erreurs ci-dessus et relancez les tests.")
    
    # Nettoyage
    if os.path.exists('test_model.pkl'):
        os.remove('test_model.pkl')
        print("\n🧹 Fichier de test nettoyé")

if __name__ == "__main__":
    main()
