# 📚 ApplicationGestionAi - Système de Gestion de Bibliothèque avec IA

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![Python](https://img.shields.io/badge/Python-3.8+-blue.svg)](https://python.org)
[![FastAPI](https://img.shields.io/badge/FastAPI-0.104+-green.svg)](https://fastapi.tiangolo.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC.svg)](https://tailwindcss.com)

## 🎯 Vue d'ensemble

**ApplicationGestionAi** est une solution complète de gestion de bibliothèque moderne qui intègre l'intelligence artificielle pour offrir des recommandations personnalisées de livres. Cette application combine la robustesse de Laravel pour la gestion des données et la puissance de Python/FastAPI pour l'analyse prédictive.

### 🌟 Fonctionnalités principales

- **Gestion complète de bibliothèque** : Adhérents, livres, emprunts, réservations
- **Recommandations IA personnalisées** : Basées sur TF-IDF et similarité cosinus
- **Interface moderne et responsive** : Design Tailwind CSS
- **API REST performante** : FastAPI pour les recommandations
- **Système d'authentification** : Rôles utilisateur et adhérent
- **Dashboard administrateur** : Gestion complète de la bibliothèque
- **Recherche avancée** : Filtrage et tri des livres
- **Historique des emprunts** : Suivi complet des activités

## 🏗️ Architecture du système

### Composants principaux

```
ApplicationGestionAi/
├── 🐘 Laravel (Backend principal)
│   ├── Gestion des utilisateurs et authentification
│   ├── CRUD pour livres, adhérents, emprunts
│   ├── Interface d'administration
│   └── API REST pour l'application web
├── 🐍 Python/FastAPI (IA & Recommandations)
│   ├── Modèle de recommandation TF-IDF
│   ├── API de recommandations personnalisées
│   ├── Analyse de similarité cosinus
│   └── Traitement de texte avancé
├── 🎨 Frontend (Blade + Tailwind)
│   ├── Interface utilisateur responsive
│   ├── Dashboard administrateur
│   ├── Formulaires de recommandations IA
│   └── Affichage des résultats
└── 🗄️ Base de données MySQL
    ├── Tables de gestion (livres, adhérents, etc.)
    ├── Historique des emprunts
    └── Données pour l'IA
```

## 🚀 Installation et configuration

### Prérequis système

- **PHP** : 8.1 ou supérieur
- **Composer** : 2.0 ou supérieur
- **Python** : 3.8 ou supérieur
- **MySQL** : 8.0 ou supérieur
- **Node.js** : 16.0 ou supérieur (pour Tailwind CSS)
- **Git** : Pour le contrôle de version

### 1. Clonage et configuration

```bash
# Cloner le projet
git clone https://github.com/Saidouchrif/ApplicationGestionAi.git
cd ApplicationGestionAi/ApplicationGestionAi

# Configuration Laravel
composer install
cp .env.example .env
php artisan key:generate

# Configuration de la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionbeb
DB_USERNAME=votre_username
DB_PASSWORD=votre_password

# Migration et seeding
php artisan migrate
php artisan db:seed

# Installation des dépendances Node.js
npm install
npm run dev
```

### 2. Configuration Python/IA

```bash
# Création d'un environnement virtuel Python
python -m venv venv

# Activation de l'environnement virtuel
# Windows
venv\Scripts\activate
# Linux/Mac
source venv/bin/activate

# Installation des dépendances Python
pip install -r requirements.txt
```

### 3. Configuration du modèle IA

```bash
# Entraînement du modèle de recommandation
python train_model.py

# Ou utiliser les scripts batch/shell fournis
# Windows
train_model.bat
# Linux/Mac
./train_model.sh
```

### 4. Démarrage des services

```bash
# Démarrage du serveur Laravel
php artisan serve

# Démarrage de l'API FastAPI (dans un autre terminal)
python recommendation_api.py

# Ou utiliser les scripts fournis
# Windows
start_recommendation_system.bat
# Linux/Mac
./start_recommendation_system.sh
```

## 📁 Structure du projet

```
ApplicationGestionAi/
├── ApplicationGestionAi/          # Application Laravel principale
│   ├── app/
│   │   ├── Http/Controllers/      # Contrôleurs Laravel
│   │   ├── Models/               # Modèles Eloquent
│   │   └── Middleware/           # Middleware personnalisé
│   ├── resources/views/          # Vues Blade
│   ├── routes/                   # Routes Laravel
│   ├── database/                 # Migrations et seeders
│   └── public/                   # Assets publics
├── CreationModelAi/              # Composants IA
│   ├── ModelAi/                  # Modèles et données IA
│   ├── FastApi/                  # API FastAPI
│   └── ModelAI2/                 # Modèles IA alternatifs
├── Web Scraping/                 # Scripts de collecte de données
└── Documentation/                # Documentation du projet
```

## 🔧 Configuration avancée

### Variables d'environnement

Créez un fichier `.env` dans le répertoire Laravel avec les configurations suivantes :

```env
# Configuration Laravel
APP_NAME="ApplicationGestionAi"
APP_ENV=local
APP_KEY=base64:votre_clé_générée
APP_DEBUG=true
APP_URL=http://localhost:8000

# Configuration base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionbeb
DB_USERNAME=votre_username
DB_PASSWORD=votre_password

# Configuration IA
AI_API_URL=http://localhost:8001
AI_MODEL_PATH=book_recommendation_model.pkl
```

### Configuration de l'API IA

L'API FastAPI utilise les paramètres suivants :

```python
# recommendation_api.py
HOST = "127.0.0.1"
PORT = 8001
MODEL_PATH = "book_recommendation_model.pkl"
```

## 🎮 Utilisation

### Interface d'administration

1. **Accès au dashboard** : `http://localhost:8000/dashboard`
2. **Gestion des livres** : Ajout, modification, suppression
3. **Gestion des adhérents** : Inscription, profil, historique
4. **Gestion des emprunts** : Création, retour, suivi

### Système de recommandations IA

1. **Accès aux recommandations** : `http://localhost:8000/recommendations`
2. **Formulaire personnalisé** : Saisie des préférences utilisateur
3. **Résultats en temps réel** : Affichage des livres recommandés

### API REST

#### Endpoints disponibles

```bash
# Recommandations de livres
GET /api/recommendations?user_preferences=...

# Informations sur un livre
GET /api/books/{id}

# Liste des livres
GET /api/books

# Recherche de livres
GET /api/books/search?q=...
```

## 🤖 Modèle IA

### Algorithme de recommandation

Le système utilise une approche hybride :

1. **TF-IDF Vectorization** : Transformation du texte des livres
2. **Similarité cosinus** : Calcul de similarité entre utilisateurs et livres
3. **Filtrage collaboratif** : Basé sur l'historique des emprunts
4. **Contenu-based filtering** : Basé sur les caractéristiques des livres

### Entraînement du modèle

```bash
# Entraînement avec données personnalisées
python train_model.py --data-path livres_nettoyes.csv

# Évaluation du modèle
python test_recommendation_system.py

# Sauvegarde du modèle
python train_and_save_model.py
```

## 🧪 Tests

### Tests Laravel

```bash
# Tests unitaires
php artisan test

# Tests spécifiques
php artisan test --filter=AdherentTest
php artisan test --filter=LivreTest
```

### Tests Python

```bash
# Tests du modèle IA
python test_recommendation_system.py

# Tests de l'API
python -m pytest tests/
```

## 📊 Base de données

### Tables principales

- **users** : Utilisateurs système
- **adherents** : Adhérents de la bibliothèque
- **livres** : Catalogue des livres
- **emprunts** : Historique des emprunts
- **reservations** : Réservations de livres
- **historique_emprunts** : Logs détaillés

### Migrations

```bash
# Création des tables
php artisan migrate

# Reset complet
php artisan migrate:fresh --seed

# Rollback
php artisan migrate:rollback
```

## 🔒 Sécurité

### Authentification

- **Laravel Sanctum** pour l'API
- **Middleware d'authentification** personnalisé
- **Gestion des rôles** (admin, adhérent)

### Protection des données

- **Validation des entrées** côté serveur
- **CSRF protection** pour les formulaires
- **Sanitisation des données** avant stockage

## 🚀 Déploiement

### Production

1. **Configuration serveur** : Apache/Nginx
2. **Optimisation Laravel** : `php artisan config:cache`
3. **Compilation assets** : `npm run build`
4. **Configuration base de données** : Production MySQL
5. **Démarrage services** : Supervisor/systemd

### Docker (optionnel)

```dockerfile
# Dockerfile pour l'application Laravel
FROM php:8.1-fpm
# ... configuration Docker
```

## 📈 Monitoring et maintenance

### Logs

- **Laravel logs** : `storage/logs/laravel.log`
- **API logs** : Logs FastAPI intégrés
- **Base de données** : Logs MySQL

### Performance

- **Cache Laravel** : Redis/Memcached
- **Optimisation requêtes** : Index base de données
- **CDN** : Pour les assets statiques

## 🤝 Contribution

### Guidelines

1. **Fork** le projet
2. **Créer** une branche feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** les changements (`git commit -m 'Add AmazingFeature'`)
4. **Push** vers la branche (`git push origin feature/AmazingFeature`)
5. **Ouvrir** une Pull Request

### Standards de code

- **PHP** : PSR-12
- **Python** : PEP 8
- **JavaScript** : ESLint
- **Tests** : Couverture minimale 80%

## 📝 Documentation

### Fichiers de documentation

- `COMMANDS.md` : Commandes artisan disponibles
- `SYSTEME_RECOMMANDATIONS.md` : Documentation du système IA
- `MODELE_ENTRAINEMENT.md` : Guide d'entraînement des modèles
- `DASHBOARD_README.md` : Documentation du dashboard

## 🐛 Dépannage

### Problèmes courants

1. **Erreur de connexion base de données**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Modèle IA non trouvé**
   ```bash
   python train_model.py
   ```

3. **Assets non compilés**
   ```bash
   npm install
   npm run dev
   ```

### Debug

```bash
# Mode debug Laravel
APP_DEBUG=true

# Logs détaillés Python
python -u recommendation_api.py
```

## 📞 Support

### Contact

- **Développeur** : Saidouchrif
- **Email** : [saidouchrif16@gmail.com]
- **GitHub** : [https://github.com/Saidouchrif/ApplicationGestionAi.git]

### Ressources

- **Documentation Laravel** : https://laravel.com/docs
- **Documentation FastAPI** : https://fastapi.tiangolo.com
- **Documentation Tailwind** : https://tailwindcss.com/docs

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**ApplicationGestionAi** - Une solution moderne de gestion de bibliothèque avec IA ✨
