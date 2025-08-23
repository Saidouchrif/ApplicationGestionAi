<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Livre;
use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos réservations.');
        }

        // Si c'est un admin, récupérer toutes les réservations
        if (Auth::user()->role === 'admin') {
            $reservations = Reservation::with(['livre', 'adherent'])
                ->orderBy('date_reservation', 'desc')
                ->paginate(10);
        } else {
            // Sinon, récupérer seulement les réservations de l'utilisateur connecté
            $reservations = Reservation::where('id_adherent', Auth::id())
                ->with(['livre', 'adherent'])
                ->orderBy('date_reservation', 'desc')
                ->paginate(10);
        }

        return view('ReservationPage.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id_livre)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour effectuer une réservation.');
        }

        // Si un ID de livre est fourni, récupérer le livre
        if ($id_livre) {
            $livre = Livre::findOrFail($id_livre);
            return view('ReservationPage.create', compact('livre'));
        }

        // Sinon, afficher la liste des livres disponibles pour réservation
        $livres = Livre::where('stock', 0)->get();
        return view('ReservationPage.create', compact('livres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'id_livre' => 'required|exists:livres,id_livre',
            'date_reservation' => 'required|date|after_or_equal:today',
        ], [
            'id_livre.required' => 'Le livre est requis.',
            'id_livre.exists' => 'Le livre n\'existe pas.',
            'date_reservation.required' => 'La date de réservation est requise.',
            'date_reservation.after_or_equal' => 'La date de réservation doit être aujourd\'hui ou dans le futur.',
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour effectuer une réservation.');
        }

        // Vérifier que le livre existe
        $livre = Livre::find($request->id_livre);
        if (!$livre) {
            return redirect()->back()->with('error', 'Livre non trouvé.');
        }

        // Vérifier que l'utilisateur n'a pas déjà une réservation pour ce livre
        $existingReservation = Reservation::where('id_adherent', Auth::id())
            ->where('id_livre', $request->id_livre)
            ->where('status', 'en_attente')
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Vous avez déjà une réservation en attente pour ce livre.');
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'id_adherent' => Auth::id(),
            'id_livre' => $request->id_livre,
            'date_reservation' => $request->date_reservation,
            'status' => 'en_attente',
        ]);

        return to_route('livres.index')->with('success', 'Réservation créée avec succès ! Vous serez notifié quand le livre sera disponible.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Validation des données
        $request->validate([
            'status' => 'required|in:en_attente,confirmee,annulee',
        ], [
            'status.required' => 'Le statut est requis.',
            'status.in' => 'Le statut doit être en_attente, confirmee ou annulee.',
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour modifier une réservation.');
        }

        // Vérifier que l'utilisateur peut modifier cette réservation (propriétaire ou admin)
        if ($reservation->id_adherent !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette réservation.');
        }

        // Mettre à jour la réservation
        $reservation->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Statut de la réservation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation,$id)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour annuler une réservation.');
        }

        // Vérifier que l'utilisateur peut annuler cette réservation (propriétaire ou admin)
        if ($reservation->id_adherent !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à annuler cette réservation.');
        }

        // Supprimer la réservation
        $reservation->delete();

        return redirect()->back()->with('success', 'Réservation annulée avec succès.');
    }
    public function chnagestatus(Request $request, $id_livre)
    {
        // Validation des données
        $request->validate([
            'status' => 'required|in:en_attente,confirmee,annulee',
        ], [
            'status.required' => 'Le statut est requis.',
            'status.in' => 'Le statut doit être en_attente, confirmee ou annulee.',
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour modifier une réservation.');
        }

        // Si c'est un admin, il peut modifier n'importe quelle réservation pour ce livre
        if (Auth::user()->role === 'admin') {
            // Pour les admins, on peut avoir plusieurs réservations pour le même livre
            // On prend la première réservation en attente ou confirmée
            $reservation = Reservation::where('id_livre', $id_livre)
                ->whereIn('status', ['en_attente', 'confirmee'])
                ->first();
                
            if (!$reservation) {
                return redirect()->back()->with('error', 'Aucune réservation active trouvée pour ce livre.');
            }
        } else {
            // Pour les adhérents, ils ne peuvent modifier que leurs propres réservations
            $reservation = Reservation::where('id_livre', $id_livre)
                ->where('id_adherent', Auth::id())
                ->first();

            if (!$reservation) {
                return redirect()->back()->with('error', 'Réservation non trouvée.');
            }
        }

        // Mettre à jour la réservation
        $reservation->update([
            'status' => $request->status,
        ]);

        $statusMessage = '';
        switch ($request->status) {
            case 'annulee':
                $statusMessage = 'Réservation annulée avec succès.';
                break;
            case 'confirmee':
                $statusMessage = 'Réservation confirmée avec succès.';
                break;
            case 'en_attente':
                $statusMessage = 'Réservation remise en attente avec succès.';
                break;
        }

        return redirect()->back()->with('success', $statusMessage);
    }
}
