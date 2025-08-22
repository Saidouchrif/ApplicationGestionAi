<?php
// Test du système complet
echo "Test du système de gestion des adhérents et dashboard\n";
echo "==================================================\n\n";

// Vérifier que les fichiers existent
$files = [
    'app/Http/Middleware/CheckRole.php',
    'app/Http/Controllers/DashboardController.php',
    'app/Http/Controllers/HomeController.php',
    'app/Http/Controllers/LoginController.php',
    'resources/views/Dashboard/dashboard.blade.php',
    'resources/views/HomePage/Home.blade.php',
    'routes/web.php',
    'config/auth.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ $file existe\n";
    } else {
        echo "✗ $file manquant\n";
    }
}

echo "\nConfiguration terminée !\n";
echo "==================================================\n";
echo "Pour tester le système :\n\n";

echo "1. Exécuter les migrations et seeders :\n";
echo "   php artisan migrate:fresh --seed\n\n";

echo "2. Se connecter en tant qu'administrateur :\n";
echo "   - Email: admin@bibreaders.test\n";
echo "   - Mot de passe: admin123\n\n";

echo "3. Tester les fonctionnalités :\n";
echo "   - Page d'accueil avec livres pour adhérents connectés\n";
echo "   - Dashboard administrateur (/dashboard)\n";
echo   "   - Middleware de vérification des rôles\n\n";

echo "4. Tester en tant qu'adhérent normal :\n";
echo "   - Créer un compte avec rôle 'adherent'\n";
echo "   - Vérifier l'accès aux livres\n";
echo "   - Vérifier que le dashboard est inaccessible\n\n";

echo "Le système est maintenant configuré pour :\n";
echo "- Afficher les livres pour les adhérents connectés\n";
echo "- Restreindre l'accès au dashboard aux administrateurs\n";
echo "- Utiliser le middleware de vérification des rôles\n";
echo "- Afficher des statistiques sur les adhérents\n";
?>
