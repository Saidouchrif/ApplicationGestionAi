@echo off
chcp 65001 >nul
echo.
echo 🚀 Démarrage de l'API de recommandation de livres...
echo.
echo 📍 Port: 5000
echo 🌐 URL: http://localhost:5000
echo 📖 Documentation: http://localhost:5000/docs
echo 🔍 Test de santé: http://localhost:5000/health
echo.
echo ⏳ Démarrage en cours...

python recommendation_api.py

echo.
echo ❌ L'API s'est arrêtée.
pause
