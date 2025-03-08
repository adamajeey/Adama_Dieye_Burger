<?php

namespace App\Http\Controllers;

use App\Models\Commande;
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


    public function valider_panier (Request $request)
    {
        $validated = request()->validate([
            'numComande' => 'required',
            'statut' => 'required',
            'burgers*' => 'array|required',
            'quantite*' => 'array|required'
        ]);
        $commande = new Commande();
        $commande->numCommande= $validated['numCommande'];
        $commande->statut= $validated['statut'];
        $commande->save();

        foreach ($validated['burgers'] as $burger) {

        }
        $commande_detail= new Commande_Detail();

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
