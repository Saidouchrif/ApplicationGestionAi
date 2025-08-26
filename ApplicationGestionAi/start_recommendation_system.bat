@echo off
echo ========================================
echo   Systeme de Recommendation de Livres
echo ========================================
echo.

echo [1/4] Verification des dependances Python...
python --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Python n'est pas installe ou n'est pas dans le PATH
    echo Veuillez installer Python depuis https://python.org
    pause
    exit /b 1
)

echo [2/4] Installation des dependances...
pip install -r requirements.txt
if errorlevel 1 (
    echo ERREUR: Impossible d'installer les dependances
    pause
    exit /b 1
)

echo [3/4] Entrainement du modele...
python train_model.py
if errorlevel 1 (
    echo ERREUR: L'entrainement du modele a echoue
    pause
    exit /b 1
)

echo [4/4] Demarrage de l'API FastAPI...
echo.
echo L'API sera accessible sur: http://localhost:8000
echo Documentation: http://localhost:8000/docs
echo.
echo Appuyez sur Ctrl+C pour arreter l'API
echo.

python recommendation_api.py

pause
