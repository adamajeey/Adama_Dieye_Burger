@extends('layouts.master')

@section('contenu')
    <!-- Titre de la page -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0"><i class="fa fa-edit me-2"></i>Modifier la commande #{{ $commande->numCommande }}</h3>
                    <a href="{{ route('commandes.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left me-1"></i> Retour aux commandes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire d'édition de commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <form action="{{ route('commandes.update', $commande->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('numCommande') is-invalid @enderror" name="numCommande" id="numCommande" value="{{ old('numCommande', $commande->numCommande) }}" placeholder="Numéro de commande" required>
                                    <label for="numCommande">Numéro de commande</label>
                                    @error('numCommande')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                                        <option value="En attente" {{ $commande->statut == 'En attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="En préparation" {{ $commande->statut == 'En préparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="Prête" {{ $commande->statut == 'Prête' ? 'selected' : '' }}>Prête</option>
                                        <option value="Payée" {{ $commande->statut == 'Payée' ? 'selected' : '' }}>Payée</option>
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
                            @if($commande->image)
                                <div class="mb-2">
                                    <img src="{{ asset($commande->image) }}" alt="Image de la commande" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                            <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Mettre à jour la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Détails de la commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5><i class="fa fa-list me-2"></i>Détails de la commande</h5>
                        <a href="{{ route('commande_details.index', $commande->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-pencil-alt me-1"></i> Gérer les détails
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead>
                            <tr class="text-dark">
                                <th width="80">Image</th>
                                <th>Burger</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse ($commande->details as $detail)
                                @php
                                    $total = $detail->burger->prix * $detail->quantite;
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td>
                                        @if($detail->burger->image)
                                            <img src="{{ asset($detail->burger->image) }}" alt="{{ $detail->burger->nom }}" class="img-fluid rounded" width="50">
                                        @else
                                            <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded" style="width: 50px; height: 50px;">
                                                <i class="fa fa-hamburger"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $detail->burger->nom }}</td>
                                    <td>{{ number_format($detail->burger->prix, 2, ',', ' ') }} €</td>
                                    <td>{{ $detail->quantite }}</td>
                                    <td>{{ number_format($total, 2, ',', ' ') }} €</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle me-2"></i>Aucun détail trouvé pour cette commande
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th>{{ number_format($grandTotal, 2, ',', ' ') }} €</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
