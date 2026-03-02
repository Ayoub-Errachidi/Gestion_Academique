<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Matiere;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    // Liste des enseignants
    public function index()
    {
        $enseignants = Enseignant::with('matieres.etudiants')->paginate(5);
        return view('enseignants.index', compact('enseignants'));
    }

    // Formulaire création
    public function create()
    {
        $matieres = Matiere::all();
        return view('enseignants.create', compact('matieres'));
    }

    // Stocker un nouvel enseignant
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:enseignants',
            'specialite' => 'required',
            'matieres' => 'array',
            'matieres.*' => 'exists:matieres,id'
        ]);

        $enseignant = Enseignant::create($request->only('nom','email','specialite'));

        if($request->matieres){
            $enseignant->matieres()->attach($request->matieres);
        }

        return redirect()->route('enseignants.index')->with('success','Enseignant ajouté avec succès');
    }

    // Formulaire édition
    public function edit($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $matieres = Matiere::all();
        return view('enseignants.edit', compact('enseignant','matieres'));
    }

    // Mettre à jour un enseignant
    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:enseignants,email,' . $id,
            'specialite' => 'required',
            'matieres' => 'array',
            'matieres.*' => 'exists:matieres,id'
        ]);

        $enseignant->update($request->only('nom','email','specialite'));

        // Synchroniser matières
        $enseignant->matieres()->sync($request->matieres ?? []);

        return redirect()->route('enseignants.index')->with('success','Enseignant modifié avec succès');
    }

    // Supprimer un enseignant
    public function destroy($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $enseignant->delete();
        return redirect()->route('enseignants.index')->with('success','Enseignant supprimé');
    }
}
