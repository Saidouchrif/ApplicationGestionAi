# Dashboard Administrateur - ApplicationGestionAi

## Vue d'ensemble

Ce système ajoute un middleware de vérification des rôles et un dashboard administrateur pour gérer les statistiques des adhérents de la bibliothèque.

## Fonctionnalités

### 1. Middleware de vérification des rôles
- **Fichier** : `app/Http/Middleware/CheckRole.php`
- **Alias** : `role`
- **Utilisation** : `->middleware('role:admin')` ou `->middleware('role:adherent')`

### 2. Dashboard Administrateur
- **Route** : `/dashboard` (protégée par le middleware `role:admin`)
- **Contrôleur** : `DashboardController@index`
- **Vue** : `resources/views/Dashboard/dashboard.blade.php`

### 3. Statistiques affichées
- Total des adhérents
- Nombre d'adhérents actifs
- Nombre d'administrateurs
- Total des emprunts
- Graphique des adhérents inscrits par mois (Chart.js)
- Graphique de répartition des rôles (Chart.js)
- Top 5 des emprunteurs
- Liste des adhérents récents

## Configuration

### 1. Middleware enregistré
Le middleware `CheckRole` est automatiquement enregistré dans `app/Http/Kernel.php` avec l'alias `role`.

### 2. Configuration d'authentification
- **Guard** : `adherent` configuré pour utiliser le modèle `Adherent`
- **Provider** : `adherents` configuré dans `config/auth.php`

### 3. Routes protégées
```php
Route::middleware('auth:adherent')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard');
});
```

## Utilisation

### 1. Créer un administrateur
```bash
php artisan migrate:fresh --seed
```
Cela créera un administrateur par défaut :
- **Email** : `admin@bibreaders.test`
- **Mot de passe** : `admin123`

### 2. Se connecter
1. Aller sur `/login`
2. Utiliser les identifiants de l'administrateur
3. Une fois connecté, un lien "Dashboard Admin" apparaîtra dans le menu utilisateur

### 3. Accéder au dashboard
- **URL** : `/dashboard`
- **Accès** : Réservé aux utilisateurs avec le rôle `admin`

## Structure des fichiers

```
app/
├── Http/
│   ├── Controllers/
│   │   └── DashboardController.php          # Contrôleur du dashboard
│   └── Middleware/
│       └── CheckRole.php                    # Middleware de vérification des rôles
├── Models/
│   └── Adherent.php                         # Modèle avec champ 'role'
config/
└── auth.php                                 # Configuration des guards
database/
└── seeders/
    ├── AdminSeeder.php                      # Seeder pour créer l'admin
    └── DatabaseSeeder.php                   # Seeder principal
resources/
└── views/
    └── Dashboard/
        └── dashboard.blade.php              # Vue du dashboard avec Chart.js
routes/
└── web.php                                  # Routes avec middleware
```

## Sécurité

- Le middleware vérifie que l'utilisateur est connecté
- Le middleware vérifie que l'utilisateur a le bon rôle
- Les routes sont protégées par authentification
- Seuls les administrateurs peuvent accéder au dashboard

## Personnalisation

### Ajouter de nouveaux rôles
1. Modifier le middleware `CheckRole.php`
2. Ajouter la logique de vérification
3. Utiliser `->middleware('role:nouveau_role')`

### Ajouter de nouvelles statistiques
1. Modifier `DashboardController@index`
2. Ajouter les données dans la vue
3. Créer de nouveaux graphiques Chart.js si nécessaire

## Dépannage

### Erreur "Class CheckRole not found"
- Vérifier que le fichier existe dans `app/Http/Middleware/`
- Vérifier que l'alias est bien enregistré dans `Kernel.php`

### Erreur "Guard adherent not defined"
- Vérifier la configuration dans `config/auth.php`
- Vérifier que le guard `adherent` est bien défini

### Dashboard inaccessible
- Vérifier que l'utilisateur est connecté
- Vérifier que l'utilisateur a le rôle `admin`
- Vérifier que la route est bien définie dans `web.php`
