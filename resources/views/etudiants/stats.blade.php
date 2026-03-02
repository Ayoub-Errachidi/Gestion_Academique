@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Statistiques des étudiants</h2>

    {{-- Par Classe --}}
    <h4>Nombre d'étudiants par classe</h4>
    <table class="table table-bordered mb-4">
        <thead class="table-dark">
            <tr>
                <th>Classe</th>
                <th>Nombre d'étudiants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->nom }}</td>
                <td>{{ $classe->etudiants_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Par Matière --}}
    <h4>Nombre d'étudiants par matière</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Matière</th>
                <th>Nombre d'étudiants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matieres as $matiere)
            <tr>
                <td>{{ $matiere->nom }}</td>
                <td>{{ $matiere->etudiants_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection