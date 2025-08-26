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

### 1. Clonage du projet

```bash
git clone https://github.com/votre-username/ApplicationGestionAi.git
cd ApplicationGestionAi
```

### 2. Configuration Laravel

```bash
# Installation des dépendances PHP
composer install

# Copie du fichier d'environnement
cp .env.example .env

# Génération de la clé d'application
php artisan key:generate

# Configuration de la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionbeb
DB_USERNAME=votre_username
DB_PASSWORD=votre_password

# Exécution des migrations
php artisan migrate

# Seeding de la base de données
php artisan db:seed

# Installation des dépendances Node.js
npm install

# Compilation des assets
npm run dev
```

### 3. Configuration Python/IA

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

# Entraînement du modèle IA
python train_and_save_model.py
```

### 4. Configuration de la base de données

```sql
-- Création de la base de données
CREATE DATABASE gestionbeb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisateur avec privilèges (optionnel)
CREATE USER 'bibliotheque_user'@'localhost' IDENTIFIED BY 'votre_password';
GRANT ALL PRIVILEGES ON gestionbeb.* TO 'bibliotheque_user'@'localhost';
FLUSH PRIVILEGES;
```

## 🔧 Configuration détaillée

### Variables d'environnement (.env)

```env
# Configuration Laravel
APP_NAME="ApplicationGestionAi"
APP_ENV=local
APP_KEY=base64:votre_cle_generee
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestionbeb
DB_USERNAME=root
DB_PASSWORD=

# Configuration de session
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuration cache
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Configuration mail (optionnel)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Configuration Python (config.py)

```python
# Configuration de la base de données
DATABASE_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'gestionbeb',
    'charset': 'utf8mb4'
}

# Configuration TF-IDF
TFIDF_CONFIG = {
    'max_features': 5000,
    'ngram_range': (1, 2),
    'min_df': 2,
    'max_df': 0.95
}

# Configuration API
API_CONFIG = {
    'host': '0.0.0.0',
    'port': 5000,
    'debug': True
}
```

## 🎮 Utilisation

### Démarrage des services

#### 1. Serveur Laravel

```bash
# Démarrage du serveur de développement
php artisan serve

# Ou avec un port spécifique
php artisan serve --host=0.0.0.0 --port=8000
```

#### 2. API FastAPI (Recommandations IA)

```bash
# Démarrage manuel
python recommendation_api.py

# Ou avec le script automatique
start_api.bat  # Windows
./start_api.sh  # Linux/Mac
```

#### 3. Compilation des assets (développement)

```bash
# Surveillance des changements
npm run dev

# Compilation pour production
npm run build
```

### Accès à l'application

- **Interface utilisateur** : http://localhost:8000
- **API FastAPI** : http://localhost:5000
- **Documentation API** : http://localhost:5000/docs
- **Test de santé API** : http://localhost:5000/health

## 📊 Fonctionnalités détaillées

### 🔐 Système d'authentification

#### Rôles utilisateur
- **Administrateur** : Accès complet à toutes les fonctionnalités
- **Adhérent** : Accès limité aux emprunts et réservations
- **Utilisateur non connecté** : Consultation du catalogue

#### Sécurité
- Authentification Laravel Sanctum
- Protection CSRF
- Validation des données
- Hachage des mots de passe

### 📚 Gestion des livres

#### Fonctionnalités
- **CRUD complet** : Création, lecture, mise à jour, suppression
- **Recherche avancée** : Par titre, description, genre
- **Filtrage** : Par disponibilité, rating, prix
- **Images** : Upload et gestion des couvertures
- **Métadonnées** : Titre, description, stock, rating, prix

#### Interface
- Grille responsive des livres
- Cartes avec informations complètes
- Actions rapides (emprunter, réserver)
- Pagination automatique

### 👥 Gestion des adhérents

#### Profils adhérents
- Informations personnelles
- Historique des emprunts
- Préférences de lecture
- Statut d'adhésion

#### Fonctionnalités
- Inscription et connexion
- Gestion du profil
- Suivi des emprunts actifs
- Historique complet

### 📖 Système d'emprunts

#### Processus d'emprunt
1. Sélection du livre
2. Vérification de disponibilité
3. Création de l'emprunt
4. Mise à jour du stock
5. Notification de confirmation

#### Gestion des retours
- Calcul automatique des retards
- Notifications de rappel
- Historique des emprunts
- Statistiques d'utilisation

### 🔄 Système de réservations

#### Fonctionnalités
- Réservation de livres indisponibles
- File d'attente automatique
- Notifications de disponibilité
- Gestion des priorités

### 🤖 Recommandations IA

#### Algorithme de recommandation
- **TF-IDF Vectorization** : Transformation du texte en vecteurs
- **Similarité cosinus** : Calcul de similarité entre livres
- **Content-based filtering** : Recommandations basées sur le contenu

#### Types de recommandations
1. **Recommandations par livre** : Livres similaires à un ouvrage spécifique
2. **Recommandations personnalisées** : Basées sur les préférences utilisateur
3. **Recommandations populaires** : Livres les plus appréciés

#### Interface utilisateur
- Formulaire de saisie des préférences
- Ajout dynamique de livres
- Affichage des scores de similarité
- Actions directes sur les recommandations
