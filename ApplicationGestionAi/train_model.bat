@echo off
chcp 65001 >nul
echo ========================================
echo   Entraînement du Modèle de Livres
echo ========================================
echo.

REM Vérifier si Python est installé
python --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Python n'est pas installé ou n'est pas dans le PATH
    echo Veuillez installer Python depuis https://python.org
    echo.
    pause
    exit /b 1
)

echo ✅ Python détecté
echo.

REM Vérifier si les dépendances sont installées
echo 🔍 Vérification des dépendances...
python -c "import pandas, numpy, sklearn, mysql.connector" >nul 2>&1
if errorlevel 1 (
    echo ⚠️  Certaines dépendances manquent
    echo 📦 Installation des dépendances...
    pip install pandas numpy scikit-learn mysql-connector-python
    if errorlevel 1 (
        echo ❌ Erreur lors de l'installation des dépendances
        pause
        exit /b 1
    )
    echo ✅ Dépendances installées
) else (
    echo ✅ Toutes les dépendances sont installées
)

echo.
echo 🚀 Démarrage de l'entraînement du modèle...
echo.

REM Exécuter l'entraînement
python train_and_save_model.py

if errorlevel 1 (
    echo.
    echo ❌ Erreur lors de l'entraînement
    echo.
    echo 🔧 Vérifiez que:
    echo    - MySQL est démarré
    echo    - La base de données existe
    echo    - Vous avez des livres avec descriptions
    echo.
    pause
    exit /b 1
)

echo.
echo ✅ Entraînement terminé avec succès!
echo.
echo 📁 Le modèle a été sauvegardé dans: book_recommendation_model.pkl
echo.
echo 🚀 Vous pouvez maintenant:
echo    1. Démarrer l'API: python recommendation_api.py
echo    2. Tester l'API: http://localhost:8000/docs
echo.
pause
