<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord approprié selon le rôle de l'utilisateur
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Vérifier si l'utilisateur est un gestionnaire
        $user = Auth::user();
        $userRole = $user ? $user->role : null;

        if ($userRole === 'gestionnaire') {
            return $this->gestionnaire();
        } else {
            return $this->client();
        }
    }

    /**
     * Tableau de bord pour les gestionnaires
     *
     * @return \Illuminate\View\View
     */
    public function gestionnaire(): View
    {
        // Obtenir la date d'aujourd'hui
        $today = Carbon::today()->toDateString();

        // Statistiques des commandes
        $stats = [
            'commandes_jour' => Commande::where('created_at', 'LIKE', $today.'%')->count(),
            'revenus_jour' => $this->calculateRevenues(Commande::where('created_at', 'LIKE', $today.'%')->get()),
            'total_commandes' => Commande::count(),
            'commandes_en_cours' => Commande::where('statut', '!=', 'Payée')->count(),
            'statut_attente' => Commande::where('statut', 'En attente')->count(),
            'statut_preparation' => Commande::where('statut', 'En préparation')->count(),
            'statut_prete' => Commande::where('statut', 'Prête')->count(),
            'statut_payee' => Commande::where('statut', 'Payée')->count(),
        ];

        // Burgers en rupture ou faible stock (moins de 5)
        $low_stock_burgers = Burger::where('stock', '<', 5)->orderBy('stock')->get();

        // Commandes récentes
        $recent_orders = Commande::with(['user', 'details.burger'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Données pour le graphique des commandes mensuelles
        $commandes_par_mois = $this->getCommandesParMois();

        return view('dashboard.gestionnaire', compact('stats', 'low_stock_burgers', 'recent_orders', 'commandes_par_mois'));
    }

    /**
     * Tableau de bord pour les clients
     *
     * @return \Illuminate\View\View
     */
    public function client(): View
    {
        $user_id = Auth::id();

        // Statistiques des commandes du client
        $stats = [
            'total_commandes' => Commande::where('user_id', $user_id)->count(),
            'commandes_en_cours' => Commande::where('user_id', $user_id)->where('statut', '!=', 'Payée')->count(),
            'total_depense' => $this->calculateRevenues(Commande::where('user_id', $user_id)->get()),
        ];

        // Commandes récentes du client
        $commandes_recentes = Commande::with(['details.burger'])
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Burgers populaires
        $burgers_populaires = Burger::where('stock', '>', 0)
            ->orderBy('stock', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.client', compact('stats', 'commandes_recentes', 'burgers_populaires'));
    }

    /**
     * Calculer les revenus totaux d'une collection de commandes
     *
     * @param \Illuminate\Support\Collection $commandes
     * @return float
     */
    private function calculateRevenues($commandes): float
    {
        $total = 0;
        foreach ($commandes as $commande) {
            foreach ($commande->details as $detail) {
                $total += $detail->burger->prix * $detail->quantite;
            }
        }
        return $total;
    }

    /**
     * Récupérer le nombre de commandes par mois
     *
     * @return array
     */
    protected function getCommandesParMois()
    {
        // Récupérer les commandes des 6 derniers mois
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $mois_labels = [];
        $commandes_par_mois = [];
        // Générer les mois
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $mois = $currentDate->format('M Y');
            $mois_labels[] = $mois;
            $commandes_par_mois[$mois] = 0;
            $currentDate->addMonth();
        }
        // Récupérer toutes les commandes dans cette période
        $commandes = Commande::whereBetween('created_at', [$startDate, $endDate])
            ->get();
        // Calculer le nombre de commandes par mois
        foreach ($commandes as $commande) {
            $mois = Carbon::parse($commande->created_at)->format('M Y');

            if (isset($commandes_par_mois[$mois])) {
                $commandes_par_mois[$mois]++;
            }
        }
        return [
            'mois_labels' => array_values($mois_labels),
            'commandes_par_mois' => array_values($commandes_par_mois),
        ];
    }
}
