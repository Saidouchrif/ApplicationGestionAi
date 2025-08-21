import psycopg2
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import joblib


# ========= 1. Charger les données depuis PostgreSQL =========
def load_data():
    conn = psycopg2.connect(
        dbname="LivresDB",
        user="postgres",
        password="raja2020",  # ⚠️ change si besoin
        host="localhost",
        port="5432"
    )
    query = "SELECT id, title, description FROM Livres"
    df = pd.read_sql(query, conn)
    conn.close()
    return df


# ========= 2. Construire le modèle de similarité =========
def build_model(df):
    # Combiner title + description
    df["text"] = df["title"] + " " + df["description"].fillna("")

    vectorizer = TfidfVectorizer(stop_words="english", max_features=5000)
    tfidf_matrix = vectorizer.fit_transform(df["text"])

    cosine_sim = cosine_similarity(tfidf_matrix, tfidf_matrix)

    # Sauvegarde du modèle
    joblib.dump((vectorizer, cosine_sim, df), "reco_model.pkl")
    print("✅ Modèle sauvegardé dans reco_model.pkl")


# ========= 3. Fonction de recommandation =========
def recommend_books(title, top_n=5):
    vectorizer, cosine_sim, df = joblib.load("reco_model.pkl")

    if title not in df["title"].values:
        return ["⚠️ Livre introuvable dans la base."]

    idx = df[df["title"] == title].index[0]

    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)

    sim_scores = sim_scores[1:top_n+1]

    return df["title"].iloc[[i[0] for i in sim_scores]].tolist()


# ========= 4. Main (test rapide) =========
if __name__ == "__main__":
    print("📥 Chargement des données...")
    df = load_data()

    print("🔧 Construction du modèle...")
    build_model(df)

    print("📚 Exemple de recommandation :")
    suggestions = recommend_books("A Light in the Attic", top_n=5)
    for i, s in enumerate(suggestions, 1):
        print(f"{i}. {s}")
