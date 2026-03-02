<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // READ
    public function index(Request $request){

        //Relation Classe et SoftDeletes
        $query = Etudiant::with(['classe', 'matieres'])->withTrashed();

        if ($request->search) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtrage par statut
        if ($request->status == 'deleted') {
            $query->onlyTrashed();
        } elseif ($request->status == 'active') {
            $query->whereNull('deleted_at');
        }


        // Filtre par classe
        if ($request->classe_id) {
            $query->where('classe_id', $request->classe_id);
        }

        // Tri dynamique
        if ($request->sort) {
            $query->orderBy($request->sort, $request->direction ?? 'asc');
        }

        $etudiants = $query->paginate(5);

        // Search
        $etudiants->appends($request->only(['search', 'classe_id', 'status', 'sort', 'direction']));

        // Pour le select filtre
        $classes = Classe::all();

        return view('etudiants.index', compact('etudiants', 'classes'));
    }

    // FORM CREATE
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all(); // toutes les matières
        return view('etudiants.create', compact('classes','matieres'));
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
            'matieres' => 'array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        $etudiant = Etudiant::create($request->only('nom','prenom','email','age','classe_id'));

        // Ajouter matières sélectionnées
        if($request->matieres){
            $etudiant->matieres()->attach($request->matieres);
        }

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant ajouté avec succès');
    }

    // EDIT FORM
    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $classes = Classe::all();
        $matieres = Matiere::all();
        return view('etudiants.edit', compact('etudiant', 'classes', 'matieres'));
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
            'matieres' => 'array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        $etudiant->update($request->only('nom','prenom','email','age','classe_id'));

        // Synchroniser matières sélectionnées
        $etudiant->matieres()->sync($request->matieres ?? []);

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