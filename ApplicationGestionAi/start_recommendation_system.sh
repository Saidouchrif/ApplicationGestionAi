#!/bin/bash

echo "========================================"
echo "  Système de Recommandation de Livres"
echo "========================================"
echo

echo "[1/4] Vérification des dépendances Python..."
if ! command -v python3 &> /dev/null; then
    echo "ERREUR: Python3 n'est pas installé"
    echo "Veuillez installer Python3: sudo apt install python3 python3-pip"
    exit 1
fi

echo "[2/4] Installation des dépendances..."
pip3 install -r requirements.txt
if [ $? -ne 0 ]; then
    echo "ERREUR: Impossible d'installer les dépendances"
    exit 1
fi

echo "[3/4] Entraînement du modèle..."
python3 train_model.py
if [ $? -ne 0 ]; then
    echo "ERREUR: L'entraînement du modèle a échoué"
    exit 1
fi

echo "[4/4] Démarrage de l'API FastAPI..."
echo
echo "L'API sera accessible sur: http://localhost:8000"
echo "Documentation: http://localhost:8000/docs"
echo
echo "Appuyez sur Ctrl+C pour arrêter l'API"
echo

python3 recommendation_api.py
