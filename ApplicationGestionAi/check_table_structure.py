#!/usr/bin/env python3
"""
Script pour vérifier la structure de la table livres
"""

import mysql.connector

def check_table_structure():
    print("🔍 Vérification de la structure de la table 'livres'...")
    
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='gestionbeb'
        )
        
        cursor = connection.cursor(dictionary=True)
        
        # Vérifier la structure de la table
        cursor.execute("DESCRIBE livres")
        columns = cursor.fetchall()
        
        print("\n📋 Structure de la table 'livres':")
        print("   Nom de colonne | Type | Null | Clé | Défaut | Extra")
        print("   " + "-" * 60)
        
        column_names = []
        for column in columns:
            print(f"   {column['Field']:<15} | {column['Type']:<15} | {column['Null']:<4} | {column['Key']:<3} | {str(column['Default']):<6} | {column['Extra']}")
            column_names.append(column['Field'])
        
        print(f"\n📊 Nombre total de colonnes: {len(column_names)}")
        print(f"📝 Noms des colonnes: {', '.join(column_names)}")
        
        # Vérifier les colonnes nécessaires
        required_columns = ['id_livre', 'titre', 'description']
        optional_columns = ['auteur', 'genre', 'image_url', 'stock', 'rating', 'price', 'created_at', 'updated_at']
        
        print(f"\n✅ Colonnes requises trouvées:")
        for col in required_columns:
            if col in column_names:
                print(f"   ✓ {col}")
            else:
                print(f"   ✗ {col} (MANQUANTE)")
        
        print(f"\n📋 Colonnes optionnelles trouvées:")
        for col in optional_columns:
            if col in column_names:
                print(f"   ✓ {col}")
            else:
                print(f"   - {col} (non présente)")
        
        cursor.close()
        connection.close()
        
        return column_names
        
    except Exception as e:
        print(f"❌ Erreur: {e}")
        return []

if __name__ == "__main__":
    check_table_structure()
