@extends('layouts.admin')

@section('title', 'Gestion des Associations')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Associations</h6>
            <a href="{{ route('admin.associations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Ajouter une association
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($associations as $association)
                        <tr>
                            <td>{{ $association->name }}</td>
                            <td>
                                @if($association->main_image)
                                    <img src="{{ asset('storage/' . $association->main_image) }}" alt="{{ $association->name }}" width="80">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($association->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.associations.show', $association) }}" class="btn btn-info btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.associations.edit', $association) }}" class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.associations.destroy', $association) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?')">
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
                {{ $associations->links() }}
            </div>
        </div>
    </div>
@endsection