<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Livre::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $livres = $query->orderByDesc('id_livre')->paginate(12)->withQueryString();

        return view('PageLivres.Livres', compact('livres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Livres.AjouterLivre');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price'=>'required|numeric',
        ]);
        $validatedData['image_url']=$request->file('image_url')->store('livres','public');
        Livre::create($validatedData);
        return redirect()->route('livresindex')->with('success', 'Le livre a été ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_livre)
    {
        // Récupérer le livre
        $livre = Livre::findOrFail($id_livre);

        // Recherche interne si paramètre q est présent (rare dans show mais je garde ton code)
        if ($search = $request->query('q')) {
            $livre = Livre::where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('auteur', 'like', "%{$search}%");
                })->first();
        }

        // 🔥 Livres similaires avec l'API de recommandation
        $recommendations = [];
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get(url('/recommendations/book/' . $id_livre . '/with-recommendations'));
            
            if ($response->successful()) {
                $data = $response->json();
                $recommendations = $data['recommendations'] ?? [];
            }
        } catch (\Exception $e) {
            // En cas d'erreur, utiliser les livres similaires basiques
            $recommendations = Livre::where('id_livre', '!=', $livre->id_livre)
                ->when($livre->auteur ?? false, function ($query) use ($livre) {
                    $query->where('auteur', $livre->auteur);
                })
                ->inRandomOrder()
                ->take(4)
                ->get()
                ->toArray();
        }

        return view('PageLivres.details', compact('livre', 'recommendations'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $livre=Livre::findOrFail($id);
        return view('Dashboard.Livres.edit',compact('livre'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $livre=Livre::findOrFail($id);
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price'=>'required|numeric',
        ]);
        if($request->hasFile('image_url')){
        $validatedData['image_url']=$request->file('image_url')->store('livres','public');
        }
        $livre->update($validatedData);
        return redirect()->route('livresindex')->with('success', 'Le livre a été mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        Livre::destroy($id);
        return redirect()->route('livresindex')->with('success', 'Le livre a été supprimé avec succès !');
    }
}
