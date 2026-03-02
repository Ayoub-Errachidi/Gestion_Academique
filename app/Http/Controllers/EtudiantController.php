<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // READ
    public function index(Request $request){
        $query = Etudiant::with('classe');

        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $etudiants = $query->paginate(5);

        $etudiants->appends($request->only('search'));

        return view('etudiants.index', compact('etudiants'));
    }

    // FORM CREATE
    public function create()
    {
        $classes = Classe::all(); // pour le select
        return view('etudiants.create', compact('classes'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:etudiants',
            'age' => 'required|integer|min:1',
            'classe_id' => 'required|exists:classes,id',
        ]);

        Etudiant::create($request->all());

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant ajouté avec succès');
    }

    // EDIT FORM
    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $classes = Classe::all();
        return view('etudiants.edit', compact('etudiant', 'classes'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $id,
            'age' => 'required|integer|min:1',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant modifié avec succès');
    }

    // DELETE
    public function destroy($id){
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete(); // soft delete
        return redirect()->route('etudiants.index')
                        ->with('success', 'Etudiant supprimé (soft delete)');
    }

    public function restore($id){
        $etudiant = Etudiant::withTrashed()->findOrFail($id);
        $etudiant->restore();
        return redirect()->route('etudiants.index')
                        ->with('success', 'Etudiant restauré avec succès');
    }
}