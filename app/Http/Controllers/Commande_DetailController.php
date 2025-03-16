<?php

namespace App\Http\Controllers;

use App\Models\Commande_detail;
use Illuminate\Http\Request;

class Commande_DetailController extends Controller
{

    public function index ()
    {
        $commande_details = Commande_detail::all();
        return view('commande_detail.index', compact('commande_details'));
    }

    public function create()
    {
        return view('commande_detail.create');

    }
//    public function store(Request $request)
//    {
//        $request->validate([
//            'commande_id' => 'required',
//            'burger*' => 'array|required',
//            'quantite' => 'required',
//        ]);
//        $commande_detail = new Commande_detail();
//        $commande_detail->commande_id=request('commande_id');
//        $commande_detail->quantite=request('quantite');
//
//
//
//        $commande_detail->save();
//
//    }
    public function show(Commande_Detail $commande_Detail)
    {
        return view('commande_detail.show', compact('commande_Detail'));
    }
    public function edit(Commande_Detail $commande_Detail)
    {
        return view('commande_detail.edit', compact('commande_Detail'));
    }

    public function update(Request $request, Commande_Detail $commande_Detail)
    {
        $validated = $request->validate([
            'quantite' => 'required|numeric|min:1'
        ]);

        $commande_Detail->quantite = $validated['quantite'];
        $commande_Detail->save();

        return redirect()->route('commande_detail.index')
            ->with('success', 'Quantité mise à jour avec succès');
    }

    public function destroy(Commande_Detail $commande_Detail)
    {
        $commande_Detail->delete();
        return redirect()->route('commande_detail.index')
            ->with('success', 'Article supprimé de la commande');
    }
}
