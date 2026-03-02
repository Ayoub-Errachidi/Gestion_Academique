@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ isset($etudiant) ? 'Modifier' : 'Ajouter' }} Étudiant</h2>

    <form action="{{ isset($etudiant) ? route('etudiants.update', $etudiant->id) : route('etudiants.store') }}" method="POST">
        @csrf
        @if(isset($etudiant))
            @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $etudiant->nom ?? '') }}">
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Prénom --}}
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $etudiant->prenom ?? '') }}">
            @error('prenom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $etudiant->email ?? '') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Age --}}
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $etudiant->age ?? '') }}">
            @error('age')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Classe --}}
        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id" class="form-select">
                <option value="">Sélectionner une classe</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ old('classe_id', $etudiant->classe_id ?? '') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
            @error('classe_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Matières (select multiple) --}}
        <div class="mb-3">
            <label for="matieres" class="form-label">Matières</label>
            <select name="matieres[]" class="form-select" multiple>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}"
                        {{ (isset($etudiant) && $etudiant->matieres->contains($matiere->id)) || (collect(old('matieres'))->contains($matiere->id)) ? 'selected' : '' }}>
                        {{ $matiere->nom }} ({{ $matiere->coefficient }})
                    </option>
                @endforeach
            </select>
            @error('matieres')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ isset($etudiant) ? 'Modifier' : 'Ajouter' }}</button>
        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection