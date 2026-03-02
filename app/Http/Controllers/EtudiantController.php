<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // READ
    public function index()
    {
        $etudiants = Etudiant::all();
        return view('etudiants.index', compact('etudiants'));
    }

    // FORM CREATE
    public function create()
    {
        return view('etudiants.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:etudiants',
            'age' => 'required|integer|min:1'
        ]);

        Etudiant::create($request->all());

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant ajouté avec succès');
    }

    // EDIT FORM
    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.edit', compact('etudiant'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $id,
            'age' => 'required|integer|min:1'
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant modifié avec succès');
    }

    // DELETE
    public function destroy($id)
    {
        Etudiant::destroy($id);

        return redirect()->route('etudiants.index')
                         ->with('success', 'Etudiant supprimé avec succès');
    }
}