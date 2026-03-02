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
            'notes' => 'array',
            'notes.*' => 'nullable|numeric|min:0|max:20', // notes entre 0 et 20
        ]);

        $etudiant = Etudiant::create($request->only('nom','prenom','email','age','classe_id'));

        // Ajouter matières + notes
        if($request->matieres){
            $data = [];
            foreach($request->matieres as $matiere_id){
                $data[$matiere_id] = ['note' => $request->notes[$matiere_id] ?? null];
            }
            $etudiant->matieres()->sync($data);
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
    public function update(Request $request, $id){
        $etudiant = Etudiant::findOrFail($id);

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $id,
            'age' => 'required|integer|min:1',
            'classe_id' => 'required|exists:classes,id',
            'matieres' => 'array',
            'matieres.*' => 'exists:matieres,id',
            'notes' => 'array',
            'notes.*' => 'nullable|numeric|min:0|max:20',
        ]);

        // Mettre à jour l'étudiant
        $etudiant->update($request->only('nom','prenom','email','age','classe_id'));

        // Synchroniser matières + notes
        if($request->matieres){
            $data = [];
            foreach($request->matieres as $matiere_id){
                $data[$matiere_id] = ['note' => $request->notes[$matiere_id] ?? null];
            }
            $etudiant->matieres()->sync($data);
        } else {
            $etudiant->matieres()->detach();
        }

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