import pandas as pd
import numpy as np
import mysql.connector
import pickle
import re
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import logging

# Configuration du logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class BookRecommendationModel:
    def __init__(self):
        self.tfidf_vectorizer = None
        self.tfidf_matrix = None
        self.similarity_matrix = None
        self.books_data = None
        
    def clean_text(self, text):
        """
        Nettoie le texte en supprimant les caractères spéciaux et en normalisant
        """
        if pd.isna(text) or text is None:
            return ""
        
        # Convertir en string
        text = str(text)
        
        # Supprimer les caractères spéciaux et normaliser
        text = re.sub(r'[^\w\sàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ]', ' ', text, flags=re.UNICODE)
        
        # Convertir en minuscules
        text = text.lower()
        
        # Supprimer les espaces multiples
        text = re.sub(r'\s+', ' ', text).strip()
        
        return text
    
    def connect_to_database(self):
        """
        Établit la connexion à la base de données MySQL
        """
        try:
            connection = mysql.connector.connect(
                host='localhost',
                user='root',
                password='',
                database='gestionbeb'
            )
            logger.info("Connexion à la base de données établie avec succès")
            return connection
        except mysql.connector.Error as e:
            logger.error(f"Erreur de connexion à la base de données: {e}")
            raise
    
    def load_books_data(self):
        """
        Charge les données des livres depuis la base de données
        """
        try:
            connection = self.connect_to_database()
            cursor = connection.cursor(dictionary=True)
            
            # Requête pour récupérer tous les livres avec leurs descriptions
            query = """
                SELECT id_livre, titre, description, image_url, 
                       stock, rating, price, created_at, updated_at
                FROM livres 
                WHERE description IS NOT NULL AND description != ''
                ORDER BY id_livre
            """
            
            cursor.execute(query)
            books = cursor.fetchall()
            
            if not books:
                logger.warning("Aucun livre trouvé dans la base de données")
                return False
            
            # Convertir en DataFrame
            self.books_data = pd.DataFrame(books)
            
            # Nettoyer les descriptions
            self.books_data['description_clean'] = self.books_data['description'].apply(self.clean_text)
            
            # Filtrer les livres avec des descriptions vides après nettoyage
            self.books_data = self.books_data[self.books_data['description_clean'].str.len() > 10]
            
            logger.info(f"Chargement de {len(self.books_data)} livres avec descriptions nettoyées")
            
            cursor.close()
            connection.close()
            
            return True
            
        except Exception as e:
            logger.error(f"Erreur lors du chargement des données: {e}")
            raise
    
    def train_model(self):
        """
        Entraîne le modèle TF-IDF et calcule la matrice de similarité
        """
        try:
            if self.books_data is None or len(self.books_data) == 0:
                raise ValueError("Aucune donnée de livres disponible. Chargez d'abord les données.")
            
            logger.info("Début de l'entraînement du modèle TF-IDF...")
            
            # Initialiser le TF-IDF Vectorizer
            self.tfidf_vectorizer = TfidfVectorizer(
                max_features=5000,  # Nombre maximum de features
                stop_words=None,    # Pas de stop words pour garder tous les mots importants
                ngram_range=(1, 2), # Unigrammes et bigrammes
                min_df=2,           # Terme doit apparaître dans au moins 2 documents
                max_df=0.95,        # Terme ne doit pas apparaître dans plus de 95% des documents
                lowercase=True,
                strip_accents='unicode'
            )
            
            # Appliquer TF-IDF sur les descriptions nettoyées
            self.tfidf_matrix = self.tfidf_vectorizer.fit_transform(self.books_data['description_clean'])
            
            logger.info(f"Matrice TF-IDF créée avec {self.tfidf_matrix.shape[1]} features")
            
            # Calculer la matrice de similarité cosinus
            logger.info("Calcul de la matrice de similarité cosinus...")
            self.similarity_matrix = cosine_similarity(self.tfidf_matrix)
            
            logger.info(f"Matrice de similarité calculée: {self.similarity_matrix.shape}")
            
            return True
            
        except Exception as e:
            logger.error(f"Erreur lors de l'entraînement du modèle: {e}")
            raise
    
    def get_recommendations(self, book_id, n_recommendations=5):
        """
        Obtient les recommandations pour un livre donné
        """
        try:
            if self.similarity_matrix is None:
                raise ValueError("Modèle non entraîné. Entraînez d'abord le modèle.")
            
            # Trouver l'index du livre
            book_index = self.books_data[self.books_data['id_livre'] == book_id].index
            
            if len(book_index) == 0:
                raise ValueError(f"Livre avec l'ID {book_id} non trouvé")
            
            book_index = book_index[0]
            
            # Obtenir les scores de similarité pour ce livre
            similarity_scores = list(enumerate(self.similarity_matrix[book_index]))
            
            # Trier par score de similarité (du plus élevé au plus bas)
            similarity_scores = sorted(similarity_scores, key=lambda x: x[1], reverse=True)
            
            # Exclure le livre lui-même (similarité = 1.0)
            similarity_scores = similarity_scores[1:n_recommendations+1]
            
            # Récupérer les informations des livres recommandés
            recommendations = []
            for index, score in similarity_scores:
                book_info = self.books_data.iloc[index].to_dict()
                book_info['similarity_score'] = float(score)
                recommendations.append(book_info)
            
            return recommendations
            
        except Exception as e:
            logger.error(f"Erreur lors de l'obtention des recommandations: {e}")
            raise
    
    def save_model(self, model_path='book_recommendation_model.pkl'):
        """
        Sauvegarde le modèle entraîné
        """
        try:
            if self.tfidf_vectorizer is None or self.similarity_matrix is None:
                raise ValueError("Modèle non entraîné. Entraînez d'abord le modèle.")
            
            model_data = {
                'tfidf_vectorizer': self.tfidf_vectorizer,
                'similarity_matrix': self.similarity_matrix,
                'books_data': self.books_data
            }
            
            with open(model_path, 'wb') as f:
                pickle.dump(model_data, f)
            
            logger.info(f"Modèle sauvegardé avec succès dans {model_path}")
            return True
            
        except Exception as e:
            logger.error(f"Erreur lors de la sauvegarde du modèle: {e}")
            raise
    
    def load_model(self, model_path='book_recommendation_model.pkl'):
        """
        Charge un modèle sauvegardé
        """
        try:
            with open(model_path, 'rb') as f:
                model_data = pickle.load(f)
            
            self.tfidf_vectorizer = model_data['tfidf_vectorizer']
            self.similarity_matrix = model_data['similarity_matrix']
            self.books_data = model_data['books_data']
            
            logger.info(f"Modèle chargé avec succès depuis {model_path}")
            return True
            
        except Exception as e:
            logger.error(f"Erreur lors du chargement du modèle: {e}")
            raise
    
    def get_model_info(self):
        """
        Retourne les informations sur le modèle
        """
        info = {
            'books_count': len(self.books_data) if self.books_data is not None else 0,
            'tfidf_features': self.tfidf_vectorizer.get_feature_names_out().shape[0] if self.tfidf_vectorizer is not None else 0,
            'similarity_matrix_shape': self.similarity_matrix.shape if self.similarity_matrix is not None else None,
            'is_trained': self.tfidf_vectorizer is not None and self.similarity_matrix is not None
        }
        return info

def main():
    """
    Fonction principale pour tester le modèle
    """
    try:
        # Créer une instance du modèle
        model = BookRecommendationModel()
        
        # Charger les données
        print("📚 Chargement des données depuis la base de données...")
        if not model.load_books_data():
            print("❌ Échec du chargement des données")
            return
        
        # Entraîner le modèle
        print("🤖 Entraînement du modèle TF-IDF...")
        model.train_model()
        
        # Sauvegarder le modèle
        print("💾 Sauvegarde du modèle...")
        model.save_model()
        
        # Afficher les informations du modèle
        info = model.get_model_info()
        print(f"\n✅ Modèle entraîné avec succès!")
        print(f"📊 Informations du modèle:")
        print(f"   - Nombre de livres: {info['books_count']}")
        print(f"   - Nombre de features TF-IDF: {info['tfidf_features']}")
        print(f"   - Forme de la matrice de similarité: {info['similarity_matrix_shape']}")
        
        # Test des recommandations
        if info['books_count'] > 0:
            first_book_id = model.books_data.iloc[0]['id_livre']
            print(f"\n🧪 Test des recommandations pour le livre ID {first_book_id}...")
            
            recommendations = model.get_recommendations(first_book_id, 3)
            print(f"📖 Recommandations trouvées: {len(recommendations)}")
            
            for i, rec in enumerate(recommendations, 1):
                print(f"   {i}. {rec['titre']} (Score: {rec['similarity_score']:.3f})")
        
    except Exception as e:
        print(f"❌ Erreur: {e}")
        logger.error(f"Erreur dans la fonction main: {e}")

if __name__ == "__main__":
    main()
