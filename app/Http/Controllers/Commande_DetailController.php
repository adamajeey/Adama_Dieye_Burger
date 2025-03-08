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
//        C 'est le panier
    }
    public function store(Request $request)
    {
        $request->validate([
            'commande_id' => 'required',
            'burger*' => 'array|required',
            'quantite' => 'required',
        ]);
        $commande_detail = new Commande_detail();
        $commande_detail->commande_id=request('commande_id');
        $commande_detail->quantite=request('quantite');

        foreach (request('burger') as $burger)
        {

        }

        $commande_detail->save();

    }
    public function show(Commande_Detail $commande_Detail)
    {

    }
    public function edit(Commande_Detail $commande_Detail)
    {

    }

    public function update(Request $request, Commande_Detail $commande_Detail)
    {

    }

    public function destroy(Commande_Detail $commande_Detail)
    {

    }
}
