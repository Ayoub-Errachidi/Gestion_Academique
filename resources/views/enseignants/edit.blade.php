@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{ isset($enseignant) ? 'Modifier' : 'Ajouter' }} Enseignant</h2>

    <form action="{{ isset($enseignant) ? route('enseignants.update', $enseignant->id) : route('enseignants.store') }}" method="POST">
        @csrf
        @if(isset($enseignant))
            @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $enseignant->nom ?? '') }}">
            @error('nom')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $enseignant->email ?? '') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Spécialité --}}
        <div class="mb-3">
            <label for="specialite" class="form-label">Spécialité</label>
            <input type="text" name="specialite" class="form-control" value="{{ old('specialite', $enseignant->specialite ?? '') }}">
            @error('specialite')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Matières --}}
        <div class="mb-3">
            <label for="matieres" class="form-label">Matières</label>
            <select name="matieres[]" class="form-select" multiple>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}"
                        {{ (isset($enseignant) && $enseignant->matieres->contains($matiere->id)) || collect(old('matieres'))->contains($matiere->id) ? 'selected' : '' }}>
                        {{ $matiere->nom }}
                    </option>
                @endforeach
            </select>
            @error('matieres')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ isset($enseignant) ? 'Modifier' : 'Ajouter' }}</button>
        <a href="{{ route('enseignants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection