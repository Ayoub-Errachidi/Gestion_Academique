@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Liste des Etudiants</h2>

    {{-- Bouton Ajouter + Recherche --}}
    <div class="d-flex justify-content-between mb-3">

        <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
            + Ajouter Etudiant
        </a>

        <form method="GET" action="{{ route('etudiants.index') }}" class="d-flex">
            <input type="text" name="search"
                   class="form-control me-2"
                   placeholder="Rechercher par nom..."
                   value="{{ request('search') }}">

            <select name="classe_id" class="form-select me-2">
                <option value="">Toutes les classes</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" 
                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline-success">
                Rechercher
            </button>
        </form>

    </div>

    {{-- Filtres --}}
    <div class="mb-3">
        <a href="{{ route('etudiants.index') }}"
           class="btn btn-secondary btn-sm">
            Tous
        </a>

        <a href="{{ route('etudiants.index', array_merge(request()->all(), ['status' => 'active'])) }}"
           class="btn btn-success btn-sm">
            Actifs
        </a>

        <a href="{{ route('etudiants.index', array_merge(request()->all(), ['status' => 'deleted'])) }}"
           class="btn btn-danger btn-sm">
            Supprimés
        </a>
    </div>

    {{-- Table --}}
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>
                    <a href="{{ route('etudiants.index', array_merge(request()->all(), ['sort' => 'nom', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                        Nom
                    </a>
                </th>
                <th>Prénom</th>
                <th>
                    <a href="{{ route('etudiants.index', array_merge(request()->all(), ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                        Email
                    </a>
                </th>
                <th>Age</th>
                <th>
                    <a href="{{ route('etudiants.index', array_merge(request()->all(), ['sort' => 'classe_id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}">
                        Classe
                    </a>
                </th>
                <th>Matières (Notes)</th>
                <th>Moyenne</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($etudiants as $etudiant)
            <tr class="{{ $etudiant->deleted_at ? 'table-danger' : '' }}">
                <td>{{ $etudiant->id }}</td>
                <td>{{ $etudiant->nom }}</td>
                <td>{{ $etudiant->prenom }}</td>
                <td>{{ $etudiant->email }}</td>
                <td>{{ $etudiant->age }}</td>
                <td>{{ $etudiant->classe->nom ?? 'Non affectée' }}</td>

                {{-- Matières et Notes --}}
                <td>
                    @foreach($etudiant->matieres as $matiere)
                        {{ $matiere->nom }} ({{ $matiere->pivot->note ?? '-' }})
                        @if (!$loop->last), @endif
                    @endforeach
                </td>

                {{-- Moyenne --}}
                <td>
                    {{ $etudiant->moyenne() !== null ? round($etudiant->moyenne(), 2) : '-' }}
                </td>

                {{-- Statut --}}
                <td>
                    @if($etudiant->deleted_at)
                        <span class="badge bg-danger">Supprimé</span>
                    @else
                        <span class="badge bg-success">Actif</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td>
                    @if(!$etudiant->deleted_at)
                        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    @else
                        <form action="{{ route('etudiants.restore', $etudiant->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Restaurer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Aucun étudiant trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Bootstrap --}}
    <div class="d-flex justify-content-center">
        {{ $etudiants->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection