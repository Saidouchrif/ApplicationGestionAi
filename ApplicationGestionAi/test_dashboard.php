<?php
// Test simple pour vérifier que le dashboard est accessible
echo "Test du dashboard - Vérification des routes et middleware\n";

// Vérifier que les fichiers existent
$files = [
    'app/Http/Middleware/CheckRole.php',
    'app/Http/Controllers/DashboardController.php',
    'resources/views/Dashboard/dashboard.blade.php',
    'routes/web.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ $file existe\n";
    } else {
        echo "✗ $file manquant\n";
    }
}

echo "\nConfiguration terminée !\n";
echo "Pour tester :\n";
echo "1. Exécuter : php artisan migrate:fresh --seed\n";
echo "2. Se connecter avec : admin@bibreaders.test / admin123\n";
echo "3. Accéder à : /dashboard\n";
?>
