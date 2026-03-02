@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des Enseignants</h2>

    <a href="{{ route('enseignants.create') }}" class="btn btn-primary mb-3">+ Ajouter Enseignant</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Spécialité</th>
                <th>Matières (Nombre étudiants)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enseignants as $enseignant)
            <tr>
                <td>{{ $enseignant->id }}</td>
                <td>{{ $enseignant->nom }}</td>
                <td>{{ $enseignant->email }}</td>
                <td>{{ $enseignant->specialite }}</td>
                <td>
                    @foreach($enseignant->matieres as $matiere)
                        {{ $matiere->nom }} ({{ $matiere->etudiants->count() }})<br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                    <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Aucun enseignant trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $enseignants->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection