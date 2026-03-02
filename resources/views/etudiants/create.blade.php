@extends('layouts.app')

@section('content')

<h4>Ajouter un Etudiant</h4>

<form action="{{ route('etudiants.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control">
    </div>

    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Retour</a>

</form>

@endsection