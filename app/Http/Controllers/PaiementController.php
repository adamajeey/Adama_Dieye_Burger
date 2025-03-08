<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements= Paiement::all();
        return view('paiements.index', compact('paiements'));
    }
    public function create()
    {

        return  redirect()->route('paiements.index')->with('success', 'le paiement ');
    }
    public function store(Request $request)
    {
        $validated = request()->validate([
            'url_pdf' => 'required',
            'montant' => 'required',
            'commande_id' => 'required'

        ]);
        $paiement = new Paiement();
        $paiement->montant= $validated['montant'];
        $paiement->commande_id= $validated['commande_id'];



        if ($request->hasfile('url_pdf')) {
            $file = $request->file('url_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/paiements/', $filename);
            $paiement->url_pdf = 'uploads/paiements/' . $filename;
        }
        $paiement->save();
        return  redirect()->route('paiements.index')->with('success', 'le paiement a ete ajouter avec succes ');

    }
    public function show($id)
    {
        $paiement=Paiement::find($id);
        return view('paiements.show', compact('paiement'));
    }
    public function edit($id )
    {
        $paiement=Paiement::find($id);
        return  redirect()->route('paiements.id', $paiement);
    }
    public function update(Request $request, $id)
    {
        $validated = request()->validate([
            'url_pdf' => 'required',
            'montant' => 'required',
            'commande_id' => 'required'

        ]);

        $paiement=Paiement::find($id);
        $paiement->montant= $validated['montant'];
        $paiement->commande_id= $validated['commande_id'];



        if ($request->hasfile('url_pdf')) {
            $file = $request->file('url_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/paiements/', $filename);
            $paiement->url_pdf = 'uploads/paiements/' . $filename;
        }
        $paiement->save();
        return  redirect()->route('paiements.index')->with('success', 'le paiement a ete modifier avec succes ');
    }
    public function destroy($id)
    {
        $paiement= Paiement::find($id);
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'le paiement a ete supprimer avec succes ');
    }
}
