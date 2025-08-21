#!/usr/bin/env python
# coding: utf-8

# # Installation of the environnement

# In[ ]:


from selenium import webdriver
from selenium.webdriver.common.by import By
import pandas as pd
import time


# In[ ]:





# ## Initialiser le driver Selenium (ex: Chrome)

# In[7]:


import time
import pandas as pd
from selenium import webdriver
from selenium.webdriver.common.by import By  

# Initialiser le driver Selenium (ex: Chrome)
driver = webdriver.Chrome()

url = "https://books.toscrape.com/catalogue/page-1.html"
driver.get(url)

books_data = []
page = 1
MAX_PAGES = 15   # 🔥 Limite à 15 pages

while True:
    print(f"📖 Scraping page {page}...")

    # Récupérer directement les livres de la page
    book_elements = driver.find_elements(By.CSS_SELECTOR, "article.product_pod")

    for book in book_elements:
        title = book.find_element(By.CSS_SELECTOR, "h3 a").get_attribute("title")
        link = book.find_element(By.CSS_SELECTOR, "h3 a").get_attribute("href")
        price = book.find_element(By.CSS_SELECTOR, ".price_color").text
        availability = book.find_element(By.CSS_SELECTOR, ".availability").text.strip()
        image_url = book.find_element(By.CSS_SELECTOR, "img").get_attribute("src")
        rating_class = book.find_element(By.CSS_SELECTOR, ".star-rating").get_attribute("class")

        # Aller dans la page détail uniquement pour la description
        driver.execute_script("window.open(arguments[0]);", link)
        driver.switch_to.window(driver.window_handles[1])
        time.sleep(1)

        description_elem = driver.find_elements(By.CSS_SELECTOR, "#product_description ~ p")
        description = description_elem[0].text if description_elem else ""

        books_data.append({
            "title": title,
            "description": description,
            "price": price,
            "availability": availability,
            "image_url": image_url,
            "rating": rating_class
        })

        # Fermer l’onglet détail et revenir
        driver.close()
        driver.switch_to.window(driver.window_handles[0])

    # Vérifier si bouton "next" existe ET si on n’a pas atteint 15 pages
    next_button = driver.find_elements(By.CSS_SELECTOR, ".next a")
    if next_button and page < MAX_PAGES:
        next_page_link = next_button[0].get_attribute("href")
        driver.get(next_page_link)
        page += 1
        time.sleep(2)
    else:
        break

driver.quit()

# Sauvegarde finale
df_books = pd.DataFrame(books_data)
df_books.to_csv("livres_bruts.csv", index=False)

print(f"✅ Scraping terminé : {len(df_books)} livres extraits sur {page} pages")


# In[8]:


import pandas as pd
import re

# Charger les données brutes
df = pd.read_csv("livres_bruts.csv")

# Nettoyage description
df["description"] = df["description"].fillna("").apply(
    lambda x: re.sub(r"[^a-zA-Z0-9\s]", " ", x)
)
df["description"] = df["description"].apply(lambda x: re.sub(r"\s+", " ", x).strip())

# Si description vide → utiliser titre
df["description"] = df.apply(
    lambda row: row["title"] if row["description"] == "" else row["description"], axis=1
)

# Prix → float
df["price"] = df["price"].str.replace("£", "").astype(float)

# Disponibilité → int
df["availability"] = df["availability"].str.extract(r"(\d+)").fillna(0).astype(int)

# Note → numérique
rating_map = {"One":1, "Two":2, "Three":3, "Four":4, "Five":5}
df["rating"] = df["rating"].apply(
    lambda x: next((rating_map[w] for w in rating_map if w in x), 0)
)

df.to_csv("livres_nettoyes.csv", index=False)
print("✅ Données nettoyées prêtes pour PostgreSQL")


# In[ ]:


import psycopg2
from psycopg2.extras import execute_values

# Connexion PostgreSQL (⚠️ adapte les infos à ton setup)
conn = psycopg2.connect(
    dbname="LivresDB",
    user="postgres",
    password="raja2020",
    host="localhost",
    port="5432"
)
cur = conn.cursor()

# Création table Livres
cur.execute("""
CREATE TABLE IF NOT EXISTS Livres (
    id SERIAL PRIMARY KEY,
    title TEXT,
    description TEXT,
    price FLOAT,
    availability INT,
    image_url TEXT,
    rating INT
);
""")

# Insertion des données
records = df.to_dict(orient="records")
execute_values(
    cur,
    """
    INSERT INTO Livres (title, description, price, availability, image_url, rating)
    VALUES %s
    """,
    [(r["title"], r["description"], r["price"], r["availability"], r["image_url"], r["rating"]) for r in records]
)

conn.commit()
cur.close()
conn.close()
print("📚 Données insérées dans PostgreSQL")


# In[ ]:




