<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rechercher l'adhérent par email
        $adherent = Adherent::where('email', $request->email)->first();

        if (!$adherent) {
            return redirect()->back()->withErrors(['email' => 'Identifiants invalides']);
        }

        // Vérifier le mot de passe
        if (Hash::check($request->password, $adherent->password_hash)) {
            // Connecter l'adhérent
            Auth::login($adherent);

            // Message de succès
            return redirect()->intended('home')->with('success', 'Connexion réussie ! Bienvenue ' . $adherent->nom . ' !');
        }

        return redirect()->back()->withErrors(['email' => 'Identifiants invalides']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email',
            'password' => 'required|confirmed|min:8',
            'terms' => 'required|accepted',
        ]);

        // Créer l'adhérent
        $adherent = Adherent::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role' => 'adherent',
            'date_inscription' => now(),
        ]);

        // Connecter automatiquement l'adhérent
        Auth::login($adherent);

        // Message de succès
        return redirect()->route('home')->with('success', 'Inscription réussie ! Bienvenue ' . $adherent->nom . ' ! Votre compte a été créé avec succès.');
    }

    public function logout()
    {
        // Récupérer le nom avant de déconnecter
        $adherent = Auth::user();
        $nom = $adherent ? $adherent->nom : 'Utilisateur';
        
        // Déconnecter l'adhérent
        Auth::logout();
        
        // Message de déconnexion
        return redirect()->route('home')->with('info', 'Déconnexion réussie. À bientôt ' . $nom . ' !');
    }
}
