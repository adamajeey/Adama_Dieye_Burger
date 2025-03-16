@extends('layouts.master')

@section('contenu')
    <!-- Titre de la page -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0"><i class="fa fa-plus-circle me-2"></i>Créer une nouvelle commande</h3>
                    <a href="{{ route('commandes.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left me-1"></i> Retour aux commandes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de création de commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <form action="{{ route('commandes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('numCommande') is-invalid @enderror" name="numCommande" id="numCommande" value="{{ old('numCommande', 'CMD-' . time()) }}" placeholder="Numéro de commande" required>
                                    <label for="numCommande">Numéro de commande</label>
                                    @error('numCommande')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                                        <option value="En attente" selected>En attente</option>
                                        <option value="En préparation">En préparation</option>
                                        <option value="Prête">Prête</option>
                                        <option value="Payée">Payée</option>
                                    </select>
                                    <label for="statut">Statut</label>
                                    @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image (facultatif)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            Cette commande sera créée pour l'utilisateur actuellement connecté. Pour ajouter des produits à cette commande, utilisez la section "Détails de la commande" après sa création.
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Créer la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
