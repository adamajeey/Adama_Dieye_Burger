@extends('layouts.master')

@section('contenu')
    <!-- Titre de la page -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0"><i class="fa fa-clipboard-list me-2"></i>Détails de la commande #{{ $commande->numCommande }}</h3>
                    <div>
                        @if(auth()->user()->role === 'gestionnaire')
                            <a href="{{ route('commandes.index') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left me-1"></i> Retour aux commandes
                            </a>
                        @else
                            <a href="{{ route('commandes.mes_commandes') }}" class="btn btn-primary">
                                <i class="fa fa-arrow-left me-1"></i> Retour à mes commandes
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations générales de la commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-light rounded p-4 h-100">
                    <h5 class="mb-4"><i class="fa fa-info-circle me-2"></i>Informations de la commande</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Numéro de commande</th>
                                <td>{{ $commande->numCommande }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Client</th>
                                <td>{{ $commande->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                <span class="badge {{
                                    $commande->statut == 'En attente' ? 'bg-warning' :
                                    ($commande->statut == 'En préparation' ? 'bg-info' :
                                    ($commande->statut == 'Prête' ? 'bg-success' :
                                    ($commande->statut == 'Payée' ? 'bg-primary' : 'bg-secondary')))
                                }}">
                                    {{ $commande->statut }}
                                </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @if(auth()->user()->role === 'gestionnaire' && $commande->statut !== 'Payée')
                    <div class="bg-light rounded p-4 h-100">
                        <h5 class="mb-4"><i class="fa fa-edit me-2"></i>Modifier le statut</h5>
                        <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="numCommande" value="{{ $commande->numCommande }}">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="statut" id="statut" required>
                                    <option value="En attente" {{ $commande->statut == 'En attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="En préparation" {{ $commande->statut == 'En préparation' ? 'selected' : '' }}>En préparation</option>
                                    <option value="Prête" {{ $commande->statut == 'Prête' ? 'selected' : '' }}>Prête</option>
                                    <option value="Payée" {{ $commande->statut == 'Payée' ? 'selected' : '' }}>Payée</option>
                                </select>
                                <label for="statut">Statut</label>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i> Mettre à jour
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-light rounded p-4 h-100">
                        <h5 class="mb-4"><i class="fa fa-chart-bar me-2"></i>Récapitulatif</h5>
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total articles:</span>
                                    <span>
                                @php
                                    $totalArticles = 0;
                                    foreach($commande->details as $detail) {
                                        $totalArticles += $detail->quantite;
                                    }
                                @endphp
                                        {{ $totalArticles }}
                            </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Date de commande:</span>
                                    <span>{{ $commande->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Statut:</span>
                                    <span class="badge {{
                                $commande->statut == 'En attente' ? 'bg-warning' :
                                ($commande->statut == 'En préparation' ? 'bg-info' :
                                ($commande->statut == 'Prête' ? 'bg-success' :
                                ($commande->statut == 'Payée' ? 'bg-primary' : 'bg-secondary')))
                            }}">
                                {{ $commande->statut }}
                            </span>
                                </div>
                            </div>

                            @if($commande->statut == 'Prête')
                                <div class="mt-auto">
                                    <a href="#" class="btn btn-success w-100">
                                        <i class="fa fa-file-pdf me-1"></i> Télécharger la facture
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Détails de la commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <h5 class="mb-4"><i class="fa fa-list me-2"></i>Détails de la commande</h5>
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

    <!-- Gestion du paiement (gestionnaires uniquement) -->
    @if(auth()->user()->role === 'gestionnaire' && $commande->statut == 'Prête')
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded p-4">
                        <h5 class="mb-4"><i class="fa fa-credit-card me-2"></i>Enregistrer le paiement</h5>
                        <form action="{{ route('paiements.store') }}" method="POST" class="row">
                            @csrf
                            <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                            <input type="hidden" name="montant" value="{{ $grandTotal }}">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" name="methode_paiement" id="methode_paiement" required>
                                        <option value="Espèces">Espèces</option>
                                        <option value="Carte Bancaire">Carte Bancaire</option>
                                    </select>
                                    <label for="methode_paiement">Méthode de paiement</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check me-1"></i> Confirmer le paiement ({{ number_format($grandTotal, 2, ',', ' ') }} €)
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
