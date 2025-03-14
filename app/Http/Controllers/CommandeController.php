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
        $commandes= Commande::all();
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
    public function valider_panier(Request $request)
    {
        // Vérifier les données envoyées
//        $validated = $request->validate([
//            'numCommande' => 'required',
//            'statut' => 'required',
//            'burgers' => 'required|array',
//            'burgers.*.id' => 'required|integer|exists:burgers,id',
//            'burgers.*.quantite' => 'required|integer|min:1'
//        ]);
//
//        // Créer la commande
//        $commande = new Commande();
//        $commande->numCommande = $validated['numCommande'];
//        $commande->statut = $validated['statut'];
//        $commande->user_id = auth()->id();
//        $commande->save();
//
//        // Ajouter les articles de la commande
//        foreach ($validated['burgers'] as $burger) {
//            $commande->burgers()->attach($burger['id'], ['quantite' => $burger['quantite']]);
//        }
//
//        return response()->json(['message' => 'Commande enregistrée avec succès'], 200);

////        try {
////            // Exemple : Traitement du panier (ajuster selon ton besoin)
////            $data = $request->all();
////
////            // Simuler une validation réussie
////            return response()->json([
////                'status' => 'success',
////                'message' => 'Commande validée avec succès !',
////                'data' => $data
////            ]);
////        } catch (\Exception $e) {
////            return response()->json([
////                'status' => 'error',
////                'message' => 'Une erreur est survenue.',
////                'error' => $e->getMessage()
////            ], 500);
//        }


        try {
            // Vérifier si le panier est vide
            if (!$request->has('panier') || empty($request->panier)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Le panier est vide.'
                ], 400);
            }

            // Démarrer une transaction pour garantir l'intégrité des données
            DB::beginTransaction();

            // Création de la commande principale
            $commande = Commande::create([
                'user_id' => auth()->id(), // Associer à l'utilisateur connecté
                'total' => collect($request->panier)->sum(fn($item) => $item['prix'] * $item['quantite']),
                'status' => 'en attente'
            ]);

            // Enregistrer chaque article dans la table commande_details
            foreach ($request->panier as $item) {
                Commande_detail::create([
                    'commande_id' => $commande->id,
                    'burger_id' => $item['id'],
                    'quantite' => $item['quantite'],
//                    'prix_unitaire' => $item['prix']
                ]);
            }

            // Valider la transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Commande validée avec succès !'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function validerPanier(Request $request)
    {
        try {
            $data = $request->all();

            // Simuler une validation réussie
            return response()->json([
                'status' => 'success',
                'message' => 'Commande validée avec succès !',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue.',
                'error' => $e->getMessage()
            ], 500);
        }

    }



    public function store(Request $request)
    {
        $validated = request()->validate([
            'numCommande' => 'required', // Changé "num" en "numCommande" pour correspondre à votre modèle
            'statut' => 'required'
        ]);

        $commande = new Commande();
        $commande->statut = $validated['statut']; // Utilisez la valeur validée
        $commande->numCommande = $validated['numCommande'];
        $commande->user_id = auth()->id(); // Ajouter l'ID de l'utilisateur connecté

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
        $commande->statut = $validated['statut']; // Correction: utilisez statut au lieu de numCommande
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
