<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Affiche la liste des paiements
     */
    public function index()
    {
        $paiements = Paiement::all();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Affiche le formulaire de création de paiement
     */
    public function create()
    {
        $commandes = Commande::all();
        return view('paiements.create', compact('commandes'));
    }

    /**
     * Enregistre un nouveau paiement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url_pdf' => 'required|file|mimes:pdf|max:2048',
            'montant' => 'required|numeric|min:0',
            'commande_id' => 'required|exists:commandes,id'
        ]);

        $paiement = new Paiement();
        $paiement->montant = $validated['montant'];
        $paiement->commande_id = $validated['commande_id'];

        if ($request->hasFile('url_pdf')) {
            $file = $request->file('url_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/paiements/', $filename);
            $paiement->url_pdf = 'uploads/paiements/' . $filename;
        }

        $paiement->save();
        return redirect()->route('paiements.index')->with('success', 'Le paiement a été ajouté avec succès');
    }

    /**
     * Affiche les détails d'un paiement
     */
    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Affiche le formulaire de modification d'un paiement
     */
    public function edit($id)
    {
        $paiement = Paiement::findOrFail($id);
        $commandes = Commande::all();
        return view('paiements.edit', compact('paiement', 'commandes'));
    }

    /**
     * Met à jour un paiement existant
     */
    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'commande_id' => 'required|exists:commandes,id',
            'url_pdf' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        $paiement->montant = $validated['montant'];
        $paiement->commande_id = $validated['commande_id'];

        if ($request->hasFile('url_pdf')) {
            // Supprimer l'ancien fichier si nécessaire
            if ($paiement->url_pdf && file_exists(public_path($paiement->url_pdf))) {
                unlink(public_path($paiement->url_pdf));
            }

            $file = $request->file('url_pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/paiements/', $filename);
            $paiement->url_pdf = 'uploads/paiements/' . $filename;
        }

        $paiement->save();
        return redirect()->route('paiements.index')->with('success', 'Le paiement a été modifié avec succès');
    }

    /**
     * Supprime un paiement
     */
    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);

        // Supprimer le fichier PDF associé si existant
        if ($paiement->url_pdf && file_exists(public_path($paiement->url_pdf))) {
            unlink(public_path($paiement->url_pdf));
        }

        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Le paiement a été supprimé avec succès');
    }
}
