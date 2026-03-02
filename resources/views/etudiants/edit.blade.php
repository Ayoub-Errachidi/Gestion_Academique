@extends('layouts.app')

@section('content')

<h4>Modifier Etudiant</h4>

<form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" value="{{ $etudiant->nom }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="prenom" value="{{ $etudiant->prenom }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $etudiant->email }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" value="{{ $etudiant->age }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Classe</label>
        <select name="classe_id" class="form-control">
            <option value="">-- Sélectionner --</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}" 
                    {{ $etudiant->classe_id == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Retour</a>

</form>

@endsection