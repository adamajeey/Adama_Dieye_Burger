@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Liste des Burgers</h6>
                        <a href="{{ route('burgers.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Ajouter un burger
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Libellé</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($burgers as $burger)
                                <tr>
                                    <td>
                                        <img src="{{ asset($burger->image) }}" alt="{{ $burger->libelle }}"
                                             class="rounded" width="50" height="50">
                                    </td>
                                    <td>{{ $burger->libelle }}</td>
                                    <td>{{ $burger->prix }} F CFA</td>
                                    <td>
                                        @if($burger->stock > 10)
                                            <span class="badge bg-success">{{ $burger->stock }}</span>
                                        @elseif($burger->stock > 0)
                                            <span class="badge bg-warning">{{ $burger->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Épuisé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('burgers.show', $burger->id) }}" class="btn btn-sm btn-info me-2">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-sm btn-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce burger?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucun burger disponible</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
