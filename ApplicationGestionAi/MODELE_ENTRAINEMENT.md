# 🤖 Guide d'Entraînement du Modèle de Recommandation

## 📋 Vue d'ensemble

Ce guide explique comment entraîner et sauvegarder le modèle de recommandation de livres basé sur TF-IDF et similarité cosinus.

## 🔧 Prérequis

### 1. Python et Dépendances
- Python 3.7+ installé
- Dépendances Python installées (voir `requirements.txt`)

### 2. Base de Données
- MySQL démarré
- Base de données `application_gestion_ai` créée
- Table `livres` avec des données et descriptions

### 3. Structure des Données
La table `livres` doit contenir au minimum :
- `id_livre` (clé primaire)
- `titre` (titre du livre)
- `description` (description/résumé du livre)
- Autres champs optionnels : `auteur`, `genre`, `image_url`, `stock`, `rating`, `price`

## 🚀 Méthodes d'Entraînement

### Option 1: Script Automatique (Recommandé)

#### Sur Windows :
```bash
.\train_model.bat
```

#### Sur Linux/Mac :
```bash
chmod +x train_model.sh
./train_model.sh
```

### Option 2: Commande Manuelle

```bash
# Installer les dépendances si nécessaire
pip install pandas numpy scikit-learn mysql-connector-python

# Exécuter l'entraînement
python train_and_save_model.py
```

### Option 3: Depuis le Code Python

```python
from recommendation_model import BookRecommendationModel

# Créer l'instance
model = BookRecommendationModel()

# Charger les données
model.load_books_data()

# Entraîner le modèle
model.train_model()

# Sauvegarder le modèle
model.save_model('book_recommendation_model.pkl')
```

## 📊 Processus d'Entraînement

### Étape 1: Chargement des Données
```python
# Connexion à MySQL
connection = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='application_gestion_ai'
)

# Requête pour récupérer les livres
query = """
    SELECT id_livre, titre, description, auteur, genre, 
           image_url, stock, rating, price, created_at, updated_at
    FROM livres 
    WHERE description IS NOT NULL AND description != ''
    ORDER BY id_livre
"""
```

### Étape 2: Nettoyage des Descriptions
```python
def clean_text(self, text):
    # Supprimer les caractères spéciaux
    text = re.sub(r'[^\w\sàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ]', ' ', text)
    
    # Convertir en minuscules
    text = text.lower()
    
    # Supprimer les espaces multiples
    text = re.sub(r'\s+', ' ', text).strip()
    
    return text
```

### Étape 3: Application TF-IDF
```python
# Configuration du TF-IDF Vectorizer
tfidf_vectorizer = TfidfVectorizer(
    max_features=5000,      # Nombre maximum de features
    stop_words=None,        # Pas de stop words
    ngram_range=(1, 2),     # Unigrammes et bigrammes
    min_df=2,              # Terme dans au moins 2 documents
    max_df=0.95,           # Terme dans max 95% des documents
    lowercase=True,
    strip_accents='unicode'
)

# Application sur les descriptions nettoyées
tfidf_matrix = tfidf_vectorizer.fit_transform(descriptions_clean)
```

### Étape 4: Calcul de la Matrice de Similarité
```python
# Calcul de la similarité cosinus
similarity_matrix = cosine_similarity(tfidf_matrix)
```

### Étape 5: Sauvegarde du Modèle
```python
model_data = {
    'tfidf_vectorizer': tfidf_vectorizer,
    'similarity_matrix': similarity_matrix,
    'books_data': books_data
}

with open('book_recommendation_model.pkl', 'wb') as f:
    pickle.dump(model_data, f)
```

## 📁 Fichiers Générés

### `book_recommendation_model.pkl`
Fichier principal contenant :
- Le TF-IDF Vectorizer entraîné
- La matrice de similarité cosinus
- Les données des livres (DataFrame pandas)

**Taille typique** : 1-10 MB selon le nombre de livres

## 🔍 Vérification du Modèle

### Test des Recommandations
```python
# Charger le modèle
model = BookRecommendationModel()
model.load_model('book_recommendation_model.pkl')

# Obtenir des recommandations
recommendations = model.get_recommendations(book_id=1, n_recommendations=5)

# Afficher les résultats
for rec in recommendations:
    print(f"- {rec['titre']} (Score: {rec['similarity_score']:.3f})")
```

### Informations du Modèle
```python
info = model.get_model_info()
print(f"Livres: {info['books_count']}")
print(f"Features TF-IDF: {info['tfidf_features']}")
print(f"Matrice: {info['similarity_matrix_shape']}")
```

## ⚠️ Dépannage

### Erreur de Connexion MySQL
```
Erreur de connexion à la base de données
```
**Solutions :**
- Vérifier que MySQL est démarré
- Vérifier les paramètres de connexion dans `recommendation_model.py`
- Vérifier que la base de données existe

### Aucun Livre Trouvé
```
Aucun livre trouvé dans la base de données
```
**Solutions :**
- Vérifier que la table `livres` contient des données
- Vérifier que les livres ont des descriptions non vides
- Vérifier la requête SQL

### Erreur de Dépendances
```
ModuleNotFoundError: No module named 'pandas'
```
**Solutions :**
```bash
pip install pandas numpy scikit-learn mysql-connector-python
```

### Modèle Vide
```
Modèle non entraîné. Entraînez d'abord le modèle.
```
**Solutions :**
- Exécuter l'entraînement complet
- Vérifier que le fichier `.pkl` a été créé
- Vérifier les permissions d'écriture

## 🔄 Mise à Jour du Modèle

### Quand Réentraîner ?
- Ajout de nouveaux livres
- Modification des descriptions existantes
- Changement significatif du catalogue

### Processus de Mise à Jour
1. Ajouter/modifier les livres dans la base de données
2. Exécuter l'entraînement complet
3. Redémarrer l'API FastAPI si nécessaire

## 📈 Performance

### Temps d'Entraînement Typiques
- 100 livres : ~5-10 secondes
- 1000 livres : ~30-60 secondes
- 10000 livres : ~2-5 minutes

### Facteurs de Performance
- Nombre de livres
- Longueur des descriptions
- Configuration TF-IDF (max_features, ngram_range)
- Puissance de la machine

## 🎯 Optimisations

### Pour de Grands Catalogues
```python
# Réduire le nombre de features
tfidf_vectorizer = TfidfVectorizer(
    max_features=2000,  # Au lieu de 5000
    min_df=3,          # Au lieu de 2
    max_df=0.90        # Au lieu de 0.95
)
```

### Pour de Petits Catalogues
```python
# Augmenter la sensibilité
tfidf_vectorizer = TfidfVectorizer(
    max_features=1000,
    min_df=1,          # Inclure tous les termes
    ngram_range=(1, 3) # Inclure les trigrammes
)
```

## 🔐 Sécurité

### Fichier de Modèle
- Le fichier `.pkl` contient des données sensibles
- Ne pas partager publiquement
- Sauvegarder régulièrement

### Base de Données
- Utiliser des identifiants sécurisés
- Limiter les permissions de l'utilisateur MySQL
- Sauvegarder régulièrement la base de données

## 📞 Support

En cas de problème :
1. Vérifier les logs d'erreur
2. Consulter ce guide de dépannage
3. Vérifier la configuration de l'environnement
4. Tester avec un petit ensemble de données
