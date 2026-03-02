@extends('layouts.app')

@section('content')

<a href="{{ route('etudiants.create') }}" class="btn btn-primary mb-3">
    Ajouter Etudiant
</a>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($etudiants as $etudiant)
        <tr>
            <td>{{ $etudiant->id }}</td>
            <td>{{ $etudiant->nom }}</td>
            <td>{{ $etudiant->prenom }}</td>
            <td>{{ $etudiant->email }}</td>
            <td>{{ $etudiant->age }}</td>
            <td>
                <a href="{{ route('etudiants.edit', $etudiant->id) }}" 
                   class="btn btn-warning btn-sm">
                   Modifier
                </a>

                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" 
                      method="POST" 
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Supprimer ?')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection