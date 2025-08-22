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
        $adherents=Auth::id();
        $emprunts=Emprunt::where('id_adherent',$adherents)->get();
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
        $emprunt=$request->validate([
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
        Emprunt::create($emprunt);
        return redirect()->route('livres.index')->with('success', 'Emprunt créé avec succès.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        //
    }
}
