@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Détails du Burger</h6>
                        <div>
                            <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-primary me-2">
                                <i class="fa fa-edit me-2"></i>Modifier
                            </a>
                            <a href="{{ route('burgers.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-4">
                                <img src="{{ asset($burger->image) }}" alt="{{ $burger->libelle }}"
                                     class="img-fluid rounded-3 shadow-sm" style="max-height: 200px;">
                            </div>

                            <div class="bg-white rounded p-3 shadow-sm mb-4">
                                <h4 class="text-primary mb-0">{{ $burger->prix }} F CFA</h4>
                                <p class="mb-2">Prix unitaire</p>

                                <div class="d-flex justify-content-center align-items-center">
                                    <h6 class="mb-0 me-2">Stock :</h6>
                                    @if($burger->stock > 10)
                                        <span class="badge bg-success">{{ $burger->stock }} disponibles</span>
                                    @elseif($burger->stock > 0)
                                        <span class="badge bg-warning">{{ $burger->stock }} restants</span>
                                    @else
                                        <span class="badge bg-danger">Épuisé</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="bg-white rounded p-4 shadow-sm h-100">
                                <h3 class="text-primary mb-3">{{ $burger->libelle }}</h3>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Description</h6>
                                    <p>{{ $burger->description }}</p>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-muted mb-2">Ajouté le</h6>
                                        <p>{{ $burger->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-muted mb-2">Dernière mise à jour</h6>
                                        <p>{{ $burger->updated_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>

                                <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST"
                                      class="text-end mt-4" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce burger?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash me-2"></i>Supprimer ce burger
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
