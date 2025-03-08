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

        return  redirect()->route('burgers.index')->with('success', 'le burger ');
    }
    public function store(Request $request)
    {
        $validated = request()->validate([
            'libelle' => 'required',
            'prix' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'image' => 'required',

        ]);
        $burger = new Burger();
        $burger->libelle= $validated['libelle'];
        $burger->prix= $validated['prix'];
        $burger->desciption= $validated['description'];
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
        return  redirect()->route('burgers.id', $burger);
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
        $burger->desciption= $validated['description'];
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
    public function destroy($id)
    {
        $burger= Burger::find($id);
        $burger->delete();
        return redirect()->route('burgers.index')->with('success', 'le burger a ete supprimer avec succes ');
    }
}
