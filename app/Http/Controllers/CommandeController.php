<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Commande_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::all();
        return view('commandes.index', compact('commandes'));
    }

    /**
     * Affiche les commandes de l'utilisateur connecté.
     */
    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', auth()->id())->get();
        return view('commandes.mes_commandes', compact('commandes'));
    }

    public function create()
    {
        return view('commandes.create');
    }

    /**
     * Valide le panier et crée une commande
     * Version adaptée à votre structure de base de données
     */
    public function validerPanier(Request $request)
    {
        try {
            // Vérifier si le panier existe et n'est pas vide
            if (!$request->has('panier') || empty($request->panier)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Le panier est vide.'
                ], 400);
            }

            // Vérifier si l'utilisateur est connecté
            $user_id = auth()->id();
            if (!$user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vous devez être connecté pour passer une commande.'
                ], 401);
            }

            // Générer un numéro de commande numérique unique (timestamp)
            $numCommande = time();

            // Créer la commande avec transaction pour assurer l'intégrité
            DB::beginTransaction();

            try {
                // Créer la commande
                $commande = new Commande();
                $commande->user_id = $user_id;
                $commande->numCommande = $numCommande;
                $commande->statut = 0; // 0 = En attente
                $commande->save();

                // Créer les détails de la commande
                foreach ($request->panier as $item) {
                    $detail = new Commande_detail();
                    $detail->commande_id = $commande->id;
                    $detail->burger_id = $item['id'];
                    $detail->quantite = $item['quantite'];
                    // Notez qu'il n'y a pas de champ prix_unitaire dans votre table
                    $detail->save();
                }

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Commande validée avec succès! Référence: ' . $numCommande,
                    'commande' => $commande
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e; // Relancer pour le bloc catch externe
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la validation du panier: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Pour la compatibilité avec l'ancienne route
     */
    public function valider_panier(Request $request)
    {
        return $this->validerPanier($request);
    }

    public function store(Request $request)
    {
        $validated = request()->validate([
            'numCommande' => 'required',
            'statut' => 'required'
        ]);

        $commande = new Commande();
        $commande->statut = $validated['statut'];
        $commande->numCommande = $validated['numCommande'];
        $commande->user_id = auth()->id();

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/commandes/', $filename);
            $commande->image = 'uploads/commandes/' . $filename;
        }

        $commande->save();
        return redirect()->route('commandes.index')->with('success', 'La commande a été ajoutée avec succès');
    }

    public function show($id)
    {
        $commande = Commande::with(['details.burger'])->find($id);
        return view('commandes.show', compact('commande'));
    }

    public function edit($id)
    {
        $commande = Commande::find($id);
        return redirect()->route('commandes.id', $commande);
    }

    public function update(Request $request, $id)
    {
        $validated = request()->validate([
            'numCommande' => 'required',
            'statut' => 'required'
        ]);

        $commande = Commande::find($id);
        $commande->statut = $validated['statut'];
        $commande->numCommande = $validated['numCommande'];

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/commandes/', $filename);
            $commande->image = 'uploads/commandes/' . $filename;
        }

        $commande->save();
        return redirect()->route('commandes.index')->with('success', 'La commande a été modifiée avec succès');
    }

    public function destroy($id)
    {
        $commande = Commande::find($id);
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'La commande a été supprimée avec succès');
    }
}
