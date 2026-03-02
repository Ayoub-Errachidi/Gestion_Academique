@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('etudiants.create') }}" class="btn btn-primary">Ajouter Etudiant</a>

    <!-- Formulaire recherche -->
    <form method="GET" action="{{ route('etudiants.index') }}" class="d-flex">
        <input type="text" name="search" class="form-control me-2" 
               placeholder="Rechercher..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-success">Rechercher</button>
    </form>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Age</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($etudiants as $etudiant)
        <tr>
            <td>{{ $etudiant->id }}</td>
            <td>{{ $etudiant->nom }}</td>
            <td>{{ $etudiant->prenom }}</td>
            <td>{{ $etudiant->email }}</td>
            <td>{{ $etudiant->age }}</td>
            <td>{{ $etudiant->classe->nom ?? 'Non affectée' }}</td>
            <td>
                <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" 
                            onclick="return confirm('Supprimer ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Aucun étudiant trouvé</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination Bootstrap -->
<div class="d-flex justify-content-center">
    {{ $etudiants->links('pagination::bootstrap-5') }}
</div>

@endsection