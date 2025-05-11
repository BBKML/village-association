@extends('layouts.admin')

@section('title', 'Gestion des Projets')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Projets</h6>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Ajouter un projet
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Statut</th>
                            <th>Dates</th>
                            <th>Besoins</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                            <td>
                                <span class="badge badge-{{ $project->status_class }}">
                                    {{ $project->status_label }}
                                </span>
                            </td>
                            <td>
                                {{ $project->start_date->format('d/m/Y') }}
                                @if($project->end_date)
                                    <br>au {{ $project->end_date->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>
                                @if($project->needs_volunteers)
                                    <span class="badge badge-info">Bénévoles</span>
                                @endif
                                @if($project->needs_donations)
                                    <span class="badge badge-success">Dons</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-info btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection