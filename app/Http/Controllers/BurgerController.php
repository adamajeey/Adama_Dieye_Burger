<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Commande;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function index()
    {

        $burgers= Burger::all();
        return view('burgers.index', compact('burgers'));
    }

    public function create()
    {
        return view('burgers.create');
    }
    public function store(Request $request)
    {
        $validated = request()->validate([
            'libelle' => 'required',
            'prix' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
        $burger = new Burger();
        $burger->libelle= $validated['libelle'];
        $burger->prix= $validated['prix'];
        $burger->description= $validated['description'];
        $burger->stock= $validated['stock'];



        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/burgers/', $filename);
            $burger->image = 'uploads/burgers/' . $filename;
        }
        $burger->save();
        return  redirect()->route('burgers.index')->with('success', 'le burger a ete ajouter avec succes ');

    }
    public function show($id)
    {
        $burger=Burger::find($id);
        return view('burgers.show', compact('burger'));
    }
    public function edit($id )
    {
        $burger=Burger::find($id);
        return view('burgers.edit', compact('burger'));
    }
    public function update(Request $request, $id)
    {
        $validated = request()->validate([
            'libelle' => 'required',
            'prix' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'image' => 'required',

        ]);

        $burger=Burger::find($id);
        $burger->libelle= $validated['libelle'];
        $burger->prix= $validated['prix'];
        $burger->description= $validated['description'];
        $burger->stock= $validated['stock'];



        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/burgers/', $filename);
            $burger->image = 'uploads/burgers/' . $filename;
        }
        $burger->save();
        return  redirect()->route('burgers.index')->with('success', 'le burger a ete modifier avec succes ');
    }

    public function catalogue(Request $request)
    {
        $query = Burger::query();

        // Appliquer les filtres
        if ($request->has('prix_min') && is_numeric($request->prix_min)) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->has('prix_max') && is_numeric($request->prix_max)) {
            $query->where('prix', '<=', $request->prix_max);
        }

        if ($request->has('libelle') && !empty($request->libelle)) {
            $query->where('libelle', 'like', '%' . $request->libelle . '%');
        }

        // N'afficher que les burgers avec un stock positif
        $query->where('stock', '>', 0);

        $burgers = $query->orderBy('libelle')->paginate(9);

        return view('burgers.catalogue', compact('burgers'));
    }

    public function destroy($id)
    {
        $burger= Burger::find($id);
        $burger->delete();
        return redirect()->route('burgers.index')->with('success', 'le burger a ete supprimer avec succes ');
    }
}
