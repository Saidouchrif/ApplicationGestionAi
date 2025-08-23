<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route principale - Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Contact (données aléatoires)
Route::get('/contact', function () {
    $emails = ['support@bibreaders.test', 'contact@bibreaders.test', 'help@bibreaders.test'];
    $phones = ['+212 6 12 34 56 78', '+212 6 98 76 54 32', '+212 5 22 33 44 55'];
    $adresses = [
        '123 Avenue des Lecteurs, Rabat',
        '45 Boulevard des Bibliothèques, Casablanca',
        '7 Rue des Romans, Marrakech',
    ];
    $horaires = [
        'Lun-Ven: 9h-18h',
        'Lun-Sam: 8h30-19h',
        'Lun-Ven: 10h-17h | Sam: 9h-13h',
    ];
    $sujets = [
        'Problème d\'emprunt',
        'Suggestion de livre',
        'Accès au compte',
        'Erreur d\'affichage',
        'Autre demande',
    ];

    $supportEmail = $emails[array_rand($emails)];
    $supportPhone = $phones[array_rand($phones)];
    $address = $adresses[array_rand($adresses)];
    $hours = $horaires[array_rand($horaires)];
    shuffle($sujets);
    $popularSubjects = array_slice($sujets, 0, 3);

    return view('Contact.Contact', compact('supportEmail', 'supportPhone', 'address', 'hours', 'popularSubjects'));
})->name('contact');

// Page des livres (liste + pagination)
Route::get('/livres', [LivreController::class, 'index'])->name('livres.index');
// Détails d'un livre spécifique
Route::get('/livres/{id_livre}', [LivreController::class, 'show'])->name('livres.show');
// Routes d'authentification
Route::middleware('guest')->group(function () {
    // Page de connexion
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    
    // Traitement de la connexion
    Route::post('/login', [LoginController::class, 'login']);
    
    // Page d'inscription
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    
    // Traitement de l'inscription
    Route::post('/register', [LoginController::class, 'register']);
});

// Route de déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route pour la réinitialisation du mot de passe
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Dashboard administrateur (accès restreint aux admins)
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard');
});
Route::put('/emprunts/update/status/{id}', [EmpruntController::class, 'chnagerstatus'])->name('emprunts.status')->middleware('auth');
Route::get('/emprunts/create/{id_livre}', [EmpruntController::class, 'create'])->name('emprunts.create')->middleware('auth');
Route::post('/emprunts/store', [EmpruntController::class, 'store'])->name('emprunts.store')->middleware('auth');
Route::get('/emprunts', [EmpruntController::class, 'index'])->name('emprunts.index')->middleware('auth');
Route::get('/adherents/create', [AdherentController::class, 'create'])->name('adherents.create');
Route::post('/adherents/store', [AdherentController::class, 'store'])->name('adherents.store');
Route::get('/adherent/index',[DashboardController::class,'adherentindex'])->name('adherentindex');
Route::get('/adherent/edit/{id}',[AdherentController::class,'edit'])->name('adherent.edit');
Route::put('/adherent/update/{id}',[AdherentController::class,'update'])->name('adherent.update');
Route::delete('/adherent/delete/{id}',[AdherentController::class,'destroy'])->name('adherent.destroy');
Route::get('/books/index', [DashboardController::class, 'livresindex'])->name('livresindex');
Route::get('/Books/create', [LivreController::class, 'create'])->name('livres.create');
Route::post('/books/store', [LivreController::class, 'store'])->name('livres.store');
Route::get('/Books/edit/{id}', [LivreController::class, 'edit'])->name('livres.edit');
Route::put('/Books/update/{id}', [LivreController::class, 'update'])->name('livres.update');
Route::delete('/Books/delete/{id}', [LivreController::class, 'destroy'])->name('livres.destroy');
Route::get('/reservation/index',[ReservationController::class,'index'])->name('reservations.index');
Route::get('/reservation/create/{id_livre}',[ReservationController::class,'create'])->name('reservation.create');
Route::post('/reservation/store',[ReservationController::class,'store'])->name('reservations.store');
Route::get('/reservation/edit/{id}',[ReservationController::class,'edit'])->name('reservations.edit');
Route::put('/reservation/update/{id}',[ReservationController::class,'update'])->name('reservations.update');
Route::delete('/reservation/delete/{id}',[ReservationController::class,'destroy'])->name('reservations.destroy');
Route::put('/reservation/update/chnagestatus/{id_livre}',[ReservationController::class,'chnagestatus'])->name('reservations.status');