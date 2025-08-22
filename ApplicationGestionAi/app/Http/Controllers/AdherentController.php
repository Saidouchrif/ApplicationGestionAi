<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Membres.AjouterMembre');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email',
            'password_hash' => 'required|confirmed|min:8', // تحقق من تأكيد كلمة المرور
            'date_inscription' => 'required|date',
        ]);
    
        // تشفير كلمة المرور
        $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);
    
        // إنشاء Adherent
        Adherent::create($validatedData);
    
        return redirect()->route('adherentindex')->with('success', 'Adhérent ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherent $adherent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $adherent=Adherent::findOrFail($id);
        return view('Dashboard.Membres.edit',compact('adherent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $adherent = Adherent::findOrFail($id);
    
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email,' . $adherent->id_adherent . ',id_adherent',
            'password_hash' => 'nullable|confirmed|min:8', // تحقق من تأكيد كلمة المرور
        ]);
    
        // إذا تم إدخال كلمة مرور جديدة، نشفرها
        if (!empty($validatedData['password_hash'])) {
            $validatedData['password_hash'] = Hash::make($validatedData['password_hash']);
        } else {
            // إذا لم يتم إدخال كلمة المرور، نحيدها من المصفوفة باش لا يتم تحديثها
            unset($validatedData['password_hash']);
        }
    
        $adherent->update($validatedData);
    
        return redirect()->route('adherentindex')->with('success', 'Adhérent modifié avec succès !');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Adherent::destroy($id);
        return to_route('adherentindex')->with('success', 'Adhérent ajouté avec succès !');
    }
}
