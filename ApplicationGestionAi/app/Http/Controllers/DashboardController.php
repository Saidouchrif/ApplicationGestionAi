<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques des adhérents
        $totalAdherents = Adherent::count();
        $adherentsActifs = Adherent::where('role', 'adherent')->count();
        $admins = Adherent::where('role', 'admin')->count();

        // Adhérents par mois (12 derniers mois)
        $adherentsParMois = Adherent::selectRaw('MONTH(date_inscription) as mois, COUNT(*) as total')
            ->whereYear('date_inscription', date('Y'))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->map(function ($item) {
                $mois = [
                    1 => 'Jan', 2 => 'Fév', 3 => 'Mar', 4 => 'Avr',
                    5 => 'Mai', 6 => 'Juin', 7 => 'Juil', 8 => 'Août',
                    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc'
                ];
                return [
                    'mois' => $mois[$item->mois] ?? $item->mois,
                    'total' => $item->total
                ];
            });

        // Top 5 des adhérents avec le plus d'emprunts
        $topEmprunteurs = Adherent::select(
                'adherents.id_adherent',
                'adherents.nom',
                'adherents.email',
                DB::raw('COUNT(emprunts.id_emprunt) as total_emprunts')
            )
            ->leftJoin('emprunts', 'adherents.id_adherent', '=', 'emprunts.id_adherent')
            ->where('adherents.role', 'adherent')
            ->groupBy('adherents.id_adherent', 'adherents.nom', 'adherents.email')
            ->orderBy('total_emprunts', 'desc')
            ->limit(5)
            ->get();

        // Répartition des rôles
        $repartitionRoles = Adherent::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->get();

        // Adhérents récents (5 derniers)
        $adherentsRecents = Adherent::where('role', 'adherent')
            ->orderBy('date_inscription', 'desc')
            ->limit(5)
            ->get();

        // Statistiques des emprunts et réservations
        $totalEmprunts = Emprunt::count();
        $totalReservations = Reservation::count();

        return view('Dashboard.dashboard', compact(
            'totalAdherents',
            'adherentsActifs',
            'admins',
            'adherentsParMois',
            'topEmprunteurs',
            'repartitionRoles',
            'adherentsRecents',
            'totalEmprunts',
            'totalReservations'
        ));
    }
    public function adherentindex(Request $request)
    {
        $query = Adherent::where('role', 'adherent');
    
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        $adherent = $query->orderByDesc('id_adherent')->paginate(12)->withQueryString();
    
        return view('Dashboard.Membres.indexadhrent', compact('adherent'));
    }
    public function livresindex(Request $request)
    {
        $query = Livre::query();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $livres = $query->orderByDesc('id_livre')->paginate(12)->withQueryString();

        return view('Dashboard.Livres.index', compact('livres'));
    }
    
}
