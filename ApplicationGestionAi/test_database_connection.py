#!/usr/bin/env python3
"""
Script de test pour vérifier la connexion à la base de données
"""

import mysql.connector

def test_connection():
    print("🔍 Test de connexion à la base de données...")
    
    try:
        # Test de connexion
        connection = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='gestionbeb'
        )
        
        print("✅ Connexion à MySQL réussie!")
        
        # Test de la table livres
        cursor = connection.cursor(dictionary=True)
        
        # Vérifier si la table existe
        cursor.execute("SHOW TABLES LIKE 'livres'")
        tables = cursor.fetchall()
        
        if not tables:
            print("❌ La table 'livres' n'existe pas")
            return False
        
        print("✅ La table 'livres' existe")
        
        # Compter les livres
        cursor.execute("SELECT COUNT(*) as count FROM livres")
        count_result = cursor.fetchone()
        total_books = count_result['count']
        
        print(f"📚 Nombre total de livres: {total_books}")
        
        # Compter les livres avec descriptions
        cursor.execute("SELECT COUNT(*) as count FROM livres WHERE description IS NOT NULL AND description != ''")
        count_result = cursor.fetchone()
        books_with_desc = count_result['count']
        
        print(f"📝 Livres avec descriptions: {books_with_desc}")
        
        # Afficher quelques exemples
        if books_with_desc > 0:
            cursor.execute("""
                SELECT id_livre, titre, LEFT(description, 100) as description_preview 
                FROM livres 
                WHERE description IS NOT NULL AND description != '' 
                LIMIT 3
            """)
            
            books = cursor.fetchall()
            print("\n📖 Exemples de livres:")
            for book in books:
                print(f"   - ID {book['id_livre']}: {book['titre']}")
                print(f"     Description: {book['description_preview']}...")
                print()
        
        cursor.close()
        connection.close()
        
        if books_with_desc == 0:
            print("⚠️  Aucun livre avec description trouvé")
            print("   Vous devez ajouter des descriptions aux livres pour entraîner le modèle")
            return False
        
        print("✅ Base de données prête pour l'entraînement!")
        return True
        
    except mysql.connector.Error as e:
        print(f"❌ Erreur de connexion: {e}")
        
        if e.errno == 1049:
            print("   La base de données 'gestionbeb' n'existe pas")
            print("   Créez la base de données ou vérifiez le nom")
        elif e.errno == 1045:
            print("   Erreur d'authentification")
            print("   Vérifiez le nom d'utilisateur et le mot de passe")
        elif e.errno == 2003:
            print("   Impossible de se connecter au serveur MySQL")
            print("   Vérifiez que MySQL est démarré")
        
        return False

if __name__ == "__main__":
    test_connection()
