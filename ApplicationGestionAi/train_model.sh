#!/bin/bash

echo "========================================"
echo "  Entraînement du Modèle de Livres"
echo "========================================"
echo

# Vérifier si Python est installé
if ! command -v python3 &> /dev/null; then
    echo "ERREUR: Python3 n'est pas installé"
    echo "Veuillez installer Python3 depuis https://python.org"
    echo
    exit 1
fi

echo "✅ Python3 détecté"
echo

# Vérifier si les dépendances sont installées
echo "🔍 Vérification des dépendances..."
python3 -c "import pandas, numpy, sklearn, mysql.connector" 2>/dev/null
if [ $? -ne 0 ]; then
    echo "⚠️  Certaines dépendances manquent"
    echo "📦 Installation des dépendances..."
    pip3 install pandas numpy scikit-learn mysql-connector-python
    if [ $? -ne 0 ]; then
        echo "❌ Erreur lors de l'installation des dépendances"
        exit 1
    fi
    echo "✅ Dépendances installées"
else
    echo "✅ Toutes les dépendances sont installées"
fi

echo
echo "🚀 Démarrage de l'entraînement du modèle..."
echo

# Exécuter l'entraînement
python3 train_and_save_model.py

if [ $? -ne 0 ]; then
    echo
    echo "❌ Erreur lors de l'entraînement"
    echo
    echo "🔧 Vérifiez que:"
    echo "   - MySQL est démarré"
    echo "   - La base de données existe"
    echo "   - Vous avez des livres avec descriptions"
    echo
    exit 1
fi

echo
echo "✅ Entraînement terminé avec succès!"
echo
echo "📁 Le modèle a été sauvegardé dans: book_recommendation_model.pkl"
echo
echo "🚀 Vous pouvez maintenant:"
echo "   1. Démarrer l'API: python3 recommendation_api.py"
echo "   2. Tester l'API: http://localhost:8000/docs"
echo
