# Configuration du système de recommandation de livres

# Configuration de la base de données
DATABASE_CONFIG = {
    'host': 'localhost',
    'database': 'application_gestion_ai',
    'user': 'root',
    'password': '',
    'charset': 'utf8mb4',
    'collation': 'utf8mb4_unicode_ci'
}

# Configuration du modèle TF-IDF
TFIDF_CONFIG = {
    'max_features': 5000,      # Nombre maximum de features
    'stop_words': 'english',   # Mots à ignorer
    'ngram_range': (1, 2),     # N-grams (1-gram et 2-gram)
    'min_df': 2,               # Fréquence minimale d'un terme
    'max_df': 0.95,            # Fréquence maximale d'un terme
    'analyzer': 'word'         # Type d'analyse
}

# Configuration de l'API FastAPI
API_CONFIG = {
    'host': '0.0.0.0',
    'port': 8000,
    'reload': True,
    'workers': 1
}

# Configuration des recommandations
RECOMMENDATION_CONFIG = {
    'default_limit': 5,        # Nombre par défaut de recommandations
    'max_limit': 20,           # Nombre maximum de recommandations
    'min_similarity': 0.1      # Similarité minimale pour inclure une recommandation
}

# Configuration des fichiers
FILE_CONFIG = {
    'model_path': 'book_recommendation_model.pkl',
    'log_path': 'recommendation_system.log'
}

# Configuration du nettoyage de texte
TEXT_CLEANING_CONFIG = {
    'remove_special_chars': True,
    'lowercase': True,
    'remove_numbers': False,
    'remove_stopwords': True,
    'min_word_length': 2
}

# Configuration de la performance
PERFORMANCE_CONFIG = {
    'batch_size': 1000,        # Taille des lots pour le traitement
    'cache_results': True,     # Mettre en cache les résultats
    'cache_ttl': 3600         # Durée de vie du cache en secondes
}
