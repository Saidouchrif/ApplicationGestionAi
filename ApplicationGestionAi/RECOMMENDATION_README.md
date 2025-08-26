# Système de Recommandation de Livres

Ce système utilise l'algorithme de similarité cosinus avec TF-IDF pour recommander des livres similaires basés sur leurs descriptions.

## 🏗️ Architecture

- **Modèle Python**: Entraînement avec scikit-learn et TF-IDF
- **API FastAPI**: Service de recommandation REST
- **Intégration Laravel**: Contrôleur pour communiquer avec l'API

## 📋 Prérequis

### Python
```bash
# Installer les dépendances Python
pip install -r requirements.txt
```

### Base de données
- MySQL/MariaDB avec la base `application_gestion_ai`
- Table `livres` avec les colonnes: `id_livre`, `titre`, `description`, `image_url`, `stock`, `rating`, `price`

## 🚀 Installation et Configuration

### 1. Configuration de la base de données

Modifiez les paramètres de connexion dans `recommendation_model.py` si nécessaire:

```python
connection = mysql.connector.connect(
    host='localhost',
    database='application_gestion_ai',
    user='root',
    password=''
)
```

### 2. Entraînement du modèle

```bash
# Entraîner et sauvegarder le modèle
python train_model.py
```

Cette commande va:
- Charger les données depuis la base de données
- Nettoyer les descriptions des livres
- Entraîner le modèle TF-IDF
- Calculer la matrice de similarité cosinus
- Sauvegarder le modèle dans `book_recommendation_model.pkl`

### 3. Démarrage de l'API FastAPI

```bash
# Démarrer l'API de recommandation
python recommendation_api.py
```

L'API sera accessible sur `http://localhost:8000`

### 4. Vérification de l'installation

```bash
# Vérifier l'état de l'API
curl http://localhost:8000/health
```

## 📚 Utilisation

### API FastAPI Endpoints

#### 1. Vérification de l'état
```bash
GET /health
```

#### 2. Obtenir des recommandations
```bash
POST /recommendations
{
    "book_id": 1,
    "n_recommendations": 5
}
```

#### 3. Liste de tous les livres
```bash
GET /books
```

#### 4. Détails d'un livre
```bash
GET /books/{book_id}
```

### Intégration Laravel

#### Routes disponibles

```php
// Vérifier l'état de l'API
GET /recommendations/health

// Recommandations pour un livre
GET /recommendations/book/{bookId}?limit=5

// Recommandations populaires
GET /recommendations/popular?limit=5

// Recommandations personnalisées (utilisateur connecté)
GET /recommendations/user?limit=5

// Livre avec ses recommandations
GET /recommendations/book/{bookId}/with-recommendations
```

#### Exemple d'utilisation dans une vue Blade

```php
// Dans un contrôleur
public function show($id)
{
    $response = Http::get(url('/recommendations/book/' . $id . '/with-recommendations'));
    
    if ($response->successful()) {
        $data = $response->json();
        $book = $data['book'];
        $recommendations = $data['recommendations'];
        
        return view('livres.show', compact('book', 'recommendations'));
    }
    
    return view('livres.show', compact('book'));
}
```

```blade
{{-- Dans une vue Blade --}}
@if(isset($recommendations) && count($recommendations) > 0)
    <div class="recommendations">
        <h3>Livres similaires</h3>
        @foreach($recommendations as $rec)
            <div class="book-card">
                <h4>{{ $rec['titre'] }}</h4>
                <p>{{ $rec['description'] }}</p>
                <span class="similarity">Similarité: {{ number_format($rec['similarity_score'] * 100, 1) }}%</span>
            </div>
        @endforeach
    </div>
@endif
```

## 🔧 Maintenance

### Réentraînement du modèle

Pour mettre à jour les recommandations avec de nouveaux livres:

```bash
# Réentraîner le modèle
python train_model.py

# Redémarrer l'API
python recommendation_api.py
```

### Surveillance

```bash
# Vérifier l'état de l'API
curl http://localhost:8000/health

# Vérifier depuis Laravel
curl http://votre-app.test/recommendations/health
```

## 🐛 Dépannage

### Erreurs courantes

1. **"Modèle non chargé"**
   - Vérifiez que `book_recommendation_model.pkl` existe
   - Réentraînez le modèle avec `python train_model.py`

2. **"Erreur de connexion à la base de données"**
   - Vérifiez que MySQL est démarré
   - Vérifiez les paramètres de connexion dans `recommendation_model.py`

3. **"API de recommandation non disponible"**
   - Vérifiez que l'API FastAPI est démarrée sur le port 8000
   - Vérifiez les logs de l'API

### Logs

Les erreurs sont loggées dans:
- **Laravel**: `storage/logs/laravel.log`
- **FastAPI**: Console de l'API

## 📊 Performance

- **Entraînement**: ~30 secondes pour 1000 livres
- **Prédiction**: ~100ms par recommandation
- **Mémoire**: ~50MB pour 1000 livres

## 🔒 Sécurité

- L'API FastAPI accepte les requêtes CORS depuis n'importe quelle origine (à configurer en production)
- Les paramètres de connexion à la base de données doivent être sécurisés en production

## 📝 Notes techniques

- Le modèle utilise TF-IDF avec 5000 features maximum
- N-grams (1,2) pour capturer les phrases
- Similarité cosinus pour mesurer la ressemblance
- Nettoyage automatique des descriptions (suppression des caractères spéciaux)

## 🤝 Contribution

Pour améliorer le système:

1. Modifiez `recommendation_model.py` pour changer l'algorithme
2. Ajoutez de nouveaux endpoints dans `recommendation_api.py`
3. Étendez le contrôleur Laravel pour de nouvelles fonctionnalités
