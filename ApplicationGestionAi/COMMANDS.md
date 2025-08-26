# Commandes du Système de Recommandation

## 🚀 Installation et Démarrage Rapide

### Windows
```bash
# Démarrage automatique complet
start_recommendation_system.bat
```

### Linux/Mac
```bash
# Rendre le script exécutable (une seule fois)
chmod +x start_recommendation_system.sh

# Démarrage automatique complet
./start_recommendation_system.sh
```

## 📋 Commandes Manuelles

### 1. Installation des dépendances
```bash
# Installer les packages Python requis
pip install -r requirements.txt

# Ou avec pip3
pip3 install -r requirements.txt
```

### 2. Entraînement du modèle
```bash
# Entraîner et sauvegarder le modèle
python train_model.py

# Ou avec python3
python3 train_model.py
```

### 3. Démarrage de l'API FastAPI
```bash
# Démarrer l'API de recommandation
python recommendation_api.py

# Ou avec python3
python3 recommendation_api.py
```

### 4. Tests du système
```bash
# Tester le bon fonctionnement
python test_recommendation_system.py

# Ou avec python3
python3 test_recommendation_system.py
```

## 🔧 Commandes de Maintenance

### Réentraînement du modèle
```bash
# Réentraîner avec de nouvelles données
python train_model.py

# Redémarrer l'API après réentraînement
python recommendation_api.py
```

### Vérification de l'état
```bash
# Vérifier l'état de l'API
curl http://localhost:8000/health

# Vérifier depuis Laravel
curl http://localhost/recommendations/health
```

### Test des recommandations
```bash
# Tester les recommandations pour un livre (ID 1)
curl -X POST http://localhost:8000/recommendations \
  -H "Content-Type: application/json" \
  -d '{"book_id": 1, "n_recommendations": 5}'
```

## 🌐 Endpoints API

### Vérification de l'état
```bash
GET http://localhost:8000/health
```

### Liste des livres
```bash
GET http://localhost:8000/books
```

### Recommandations pour un livre
```bash
POST http://localhost:8000/recommendations
Content-Type: application/json

{
  "book_id": 1,
  "n_recommendations": 5
}
```

### Détails d'un livre
```bash
GET http://localhost:8000/books/{book_id}
```

## 🔗 Routes Laravel

### Vérification de l'API
```bash
GET /recommendations/health
```

### Recommandations pour un livre
```bash
GET /recommendations/book/{bookId}?limit=5
```

### Recommandations populaires
```bash
GET /recommendations/popular?limit=5
```

### Recommandations personnalisées
```bash
GET /recommendations/user?limit=5
```

### Livre avec recommandations
```bash
GET /recommendations/book/{bookId}/with-recommendations
```

## 🐛 Dépannage

### Vérifier les logs
```bash
# Logs Laravel
tail -f storage/logs/laravel.log

# Logs de l'API (dans la console où elle tourne)
```

### Redémarrer le système
```bash
# 1. Arrêter l'API (Ctrl+C)
# 2. Réentraîner le modèle
python train_model.py

# 3. Redémarrer l'API
python recommendation_api.py
```

### Vérifier la base de données
```bash
# Se connecter à MySQL
mysql -u root -p application_gestion_ai

# Vérifier les livres
SELECT COUNT(*) FROM livres;
SELECT id_livre, titre, description FROM livres LIMIT 5;
```

## 📊 Monitoring

### Vérifier les performances
```bash
# Temps de réponse de l'API
time curl -X POST http://localhost:8000/recommendations \
  -H "Content-Type: application/json" \
  -d '{"book_id": 1, "n_recommendations": 5}'
```

### Vérifier l'utilisation mémoire
```bash
# Sur Linux/Mac
ps aux | grep python

# Sur Windows
tasklist | findstr python
```

## 🔒 Sécurité

### Configuration en production
```bash
# Modifier config.py pour les paramètres de production
# Changer les paramètres de base de données
# Configurer les CORS dans recommendation_api.py
```

### Sauvegarde du modèle
```bash
# Sauvegarder le modèle entraîné
cp book_recommendation_model.pkl backup_model_$(date +%Y%m%d).pkl
```

## 📝 Notes Importantes

- **Port par défaut**: L'API FastAPI tourne sur le port 8000
- **Base de données**: Assurez-vous que MySQL est démarré
- **Modèle**: Le fichier `book_recommendation_model.pkl` doit exister pour que l'API fonctionne
- **CORS**: L'API accepte les requêtes depuis n'importe quelle origine (à configurer en production)
