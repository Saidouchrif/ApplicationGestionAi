<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos emprunts.');
        }

        if (Auth::user()->role === 'admin') {
            // Les admins voient tous les emprunts
            $emprunts = Emprunt::with(['livre', 'adherent'])
                ->orderBy('date_emprunt', 'desc')
                ->get();
        } else {
            // Les adhérents voient seulement leurs emprunts
            $emprunts = Emprunt::where('id_adherent', Auth::id())
                ->with(['livre', 'adherent'])
                ->orderBy('date_emprunt', 'desc')
                ->get();
        }

        return view('EmpruntPage.index', compact('emprunts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request,$id_livre)
    {
        $livre = Livre::findOrFail($id_livre);
        return view('EmpruntPage.create', compact('livre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $emprunt = $request->validate([
            'id_livre' => 'required|exists:livres,id_livre',
            'id_adherent' => 'required|exists:adherents,id_adherent',
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
            'date_retour_effectif' => 'required|date|after_or_equal:date_emprunt',
            'statut' => 'required|in:en_cours,retourne',
        ],[
            'id_livre.required' => 'Le livre est requis.',
            'id_livre.exists' => 'Le livre n\'existe pas.',
            'id_adherent.required' => 'L\'adherent est requis.',
            'id_adherent.exists' => 'L\'adherent n\'existe pas.',
            'date_emprunt.required' => 'La date d\'emprunt est requise.',
        ]);

        // Vérifier que le livre est disponible
        $livre = Livre::find($request->id_livre);
        if (!$livre) {
            return redirect()->back()->with('error', 'Livre non trouvé.');
        }

        if ($livre->stock <= 0) {
            return redirect()->back()->with('error', 'Ce livre n\'est plus disponible en stock.');
        }

        // Créer l'emprunt
        Emprunt::create($emprunt);

        // Décrémenter le stock du livre
        $livre->decrement('stock');

        return redirect()->route('livres.index')->with('success', 'Emprunt créé avec succès. Le stock du livre a été mis à jour.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Emprunt $emprunt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Emprunt $emprunt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Emprunt $emprunt)
    {
        // Validation des données
        $request->validate([
            'statut' => 'required|in:en_cours,retourne',
            'date_retour_effectif' => 'required_if:statut,retourne|date|after_or_equal:date_emprunt',
        ]);

        // Si le statut passe à "retourné", incrémenter le stock du livre
        if ($request->statut === 'retourne' && $emprunt->statut === 'en_cours') {
            $livre = Livre::find($emprunt->id_livre);
            if ($livre) {
                $livre->increment('stock');
            }
        }

        // Mettre à jour l'emprunt
        $emprunt->update($request->all());

        return redirect()->back()->with('success', 'Emprunt mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        // Si l'emprunt est en cours, remettre le livre en stock
        if ($emprunt->statut === 'en_cours') {
            $livre = Livre::find($emprunt->id_livre);
            if ($livre) {
                $livre->increment('stock');
            }
        }

        // Supprimer l'emprunt
        $emprunt->delete();

        return redirect()->back()->with('success', 'Emprunt supprimé avec succès.');
    }
    public function chnagerstatus(Request $request, $id){
        // Validation des données
        $request->validate([
            'status' => 'required|in:retourne'
        ]);

        try {
            // Récupérer l'emprunt
            $emprunt = Emprunt::findOrFail($id);
            
            // Vérifier que l'utilisateur est connecté
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'Vous devez être connecté pour effectuer cette action.');
            }
            
            // Vérifier que l'utilisateur est le propriétaire de l'emprunt ou un admin
            if (Auth::user()->role !== 'admin' && Auth::id() != $emprunt->id_adherent) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cet emprunt.');
            }
            
            // Vérifier que l'emprunt est en cours
            if ($emprunt->statut !== 'en_cours') {
                return redirect()->back()->with('error', 'Seuls les emprunts en cours peuvent être marqués comme retournés.');
            }
            
            // Mettre à jour le statut
            $emprunt->statut = 'retourne';
            $emprunt->date_retour_effectif = now();
            $emprunt->save();
            
            // Incrémenter le stock du livre
            if ($emprunt->livre) {
                $emprunt->livre->increment('stock');
            }
            
            return redirect()->back()->with('success', 'L\'emprunt a été marqué comme retourné avec succès. Le stock du livre a été mis à jour.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        }
    }
}
