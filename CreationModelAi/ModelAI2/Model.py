# backend/scripts/train_reco.py
import os, sys, asyncio, pickle
from typing import List, Tuple
THIS = os.path.abspath(__file__); SCRIPTS = os.path.dirname(THIS); BACKEND = os.path.abspath(os.path.join(SCRIPTS, ".."))
if BACKEND not in sys.path: sys.path.insert(0, BACKEND)

from sqlalchemy import select
from app.db.session import SessionLocal
from app.models.livre import Livre
from sklearn.feature_extraction.text import TfidfVectorizer

MODEL_PATH = os.path.join(BACKEND, "app", "core", "reco_model.pkl")

async def _fetch_books() -> List[Tuple[int, str, str]]:
    async with SessionLocal() as s:
        res = await s.execute(select(Livre.id, Livre.title, Livre.description))
        return [(i, t or "", d or "") for i, t, d in res.all()]

def _corpus(rows): return [f"{t}. {d}".strip() for _, t, d in rows]

async def main():
    rows = await _fetch_books()
    if not rows: return print("No books in DB. Run the scraper with --load-db first.")
    vec = TfidfVectorizer(stop_words="english", max_features=5000)
    X = vec.fit_transform(_corpus(rows))
    payload = {"vectorizer": vec, "matrix": X, "book_ids": [r[0] for r in rows], "titles": [r[1] for r in rows]}
    os.makedirs(os.path.dirname(MODEL_PATH), exist_ok=True)
    with open(MODEL_PATH, "wb") as f: pickle.dump(payload, f)
    print(f"Saved model → {MODEL_PATH} | books indexed: {len(rows)}")

if __name__ == "__main__": asyncio.run(main())