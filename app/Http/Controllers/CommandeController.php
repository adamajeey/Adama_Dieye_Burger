<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Commande_detail;
use Illuminate\Http\Request;

class CommandeController extends Controller
{

    public function index()
    {
        $commandes= Commande::all();
        return view('commandes.index', compact('commandes'));
    }
    public function create()
    {

        return  redirect()->route('commandes.index')->with('success', 'La commande ');
    }


    public function valider_panier(Request $request)
    {
        $validated = $request->validate([
            'numCommande' => 'required',
            'statut' => 'required',
            'burgers' => 'required|array',
            'quantite' => 'required|array'
        ]);

        // Création de la commande
        $commande = new Commande();
        $commande->numCommande = $validated['numCommande'];
        $commande->statut = $validated['statut'];
//        ou
//        $commande->statut = 0;
        $commande->save();

        // Ajout des détails de commande
        foreach ($validated['burgers'] as $index => $burger_id) {
            $commande_detail = new Commande_detail();
            $commande_detail->commande_id = $commande->id;
            $commande_detail->burger_id = $burger_id;
            $commande_detail->quantite = $validated['quantite'][$index] ?? 1;
            $commande_detail->save();
        }

        return response()->json(['message' => 'Commande validée avec succès', 'commande' => $commande], 201);
    }


    public function store(Request $request)
    {
        $validated = request()->validate([
            'num' => 'required',
            'statut' => 'required'

        ]);
        $commande = new Commande();
        $commande->statut= 0;
        $commande->numCommande= $validated['numCommande'];



        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/commandes/', $filename);
            $commande->image = 'uploads/commandes/' . $filename;
        }
        $commande->save();
        return  redirect()->route('commandes.index')->with('success', 'la commande a ete ajouter avec succes ');

    }
    public function show($id)
    {
        $commande=Commande::find($id);
        return view('commandes.show', compact('commande'));
    }
    public function edit($id )
    {
        $commande=Commande::find($id);
        return  redirect()->route('commandes.id', $commande);
    }
    public function update(Request $request, $id)
    {
        $validated = request()->validate([
            'numCommande' => 'required',
            'statut' => 'required'

        ]);

        $commande=Commande::find($id);
        $commande->statut= $validated['numCommande'];;
        $commande->numCommande= $validated['numCommande'];



        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/commandes/', $filename);
            $commande->image = 'uploads/commandes/' . $filename;
        }
        $commande->save();
        return  redirect()->route('commandes.index')->with('success', 'la commande a ete modifier avec succes ');
    }
    public function destroy($id)
    {
        $commande= Commande::find($id);
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'la commande a ete supprimer avec succes ');
    }

}
