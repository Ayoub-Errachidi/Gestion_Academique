@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">
        {{ isset($etudiant) ? 'Modifier Etudiant' : 'Ajouter Etudiant' }}
    </h2>

    {{-- Affichage messages erreurs globaux --}}
    @if($errors->any())
        <div class="alert alert-danger">
            Veuillez corriger les erreurs ci-dessous.
        </div>
    @endif

    <form action="{{ isset($etudiant) ? route('etudiants.update', $etudiant->id) : route('etudiants.store') }}"
          method="POST">
        @csrf
        @if(isset($etudiant))
            @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text"
                   class="form-control @error('nom') is-invalid @enderror"
                   name="nom"
                   value="{{ old('nom', $etudiant->nom ?? '') }}">
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Prénom --}}
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text"
                   class="form-control @error('prenom') is-invalid @enderror"
                   name="prenom"
                   value="{{ old('prenom', $etudiant->prenom ?? '') }}">
            @error('prenom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email"
                   value="{{ old('email', $etudiant->email ?? '') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Age --}}
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number"
                   class="form-control @error('age') is-invalid @enderror"
                   name="age"
                   value="{{ old('age', $etudiant->age ?? '') }}">
            @error('age')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Classe --}}
        <div class="mb-3">
            <label for="classe_id" class="form-label">Classe</label>
            <select name="classe_id"
                    class="form-select @error('classe_id') is-invalid @enderror">
                <option value="">-- Sélectionner une classe --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ old('classe_id', $etudiant->classe_id ?? '') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }} ({{ $classe->niveau }})
                    </option>
                @endforeach
            </select>
            @error('classe_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bouton --}}
        <button type="submit" class="btn btn-success">
            {{ isset($etudiant) ? 'Modifier' : 'Ajouter' }}
        </button>
        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

@endsection