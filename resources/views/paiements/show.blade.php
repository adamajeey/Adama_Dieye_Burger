@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <!-- Titre et boutons d'action -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Détails du Paiement</h6>
                    <div>
                        <a href="{{ route('paiements.index') }}" class="btn btn-secondary me-2">
                            <i class="fa fa-arrow-left me-1"></i>Retour
                        </a>
                        <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-warning me-2">
                            <i class="fa fa-edit me-1"></i>Modifier
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fa fa-trash me-1"></i>Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails du paiement -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="bg-light rounded p-4 h-100">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <h5 class="text-primary"><i class="fa fa-money-bill me-2"></i>Informations du paiement</h5>
                        <span class="badge bg-success p-2">Validé</span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Référence paiement :</p>
                            <p class="h5">PAY-{{ $paiement->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Date de paiement :</p>
                            <p class="h5">{{ $paiement->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Montant payé :</p>
                            <p class="h4 text-primary">{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Commande liée :</p>
                            <p class="h5">
                                @if ($paiement->commande)
                                    <a href="{{ route('commandes.show', $paiement->commande->id) }}" class="text-decoration-none">
                                        #{{ $paiement->commande->numCommande }}
                                    </a>
                                @else
                                    <span class="text-danger">Commande non trouvée</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-1 text-muted">Reçu de paiement :</p>
                            @if ($paiement->url_pdf)
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="{{ asset($paiement->url_pdf) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fa fa-file-pdf me-1"></i>Voir le reçu
                                    </a>
                                    <a href="{{ asset($paiement->url_pdf) }}" download class="btn btn-outline-secondary">
                                        <i class="fa fa-download me-1"></i>Télécharger le reçu
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle me-2"></i>Aucun reçu disponible pour ce paiement.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-light rounded p-4 h-100">
                    <h5 class="text-primary border-bottom pb-3 mb-3"><i class="fa fa-user me-2"></i>Client</h5>

                    @if($paiement->commande && $paiement->commande->user)
                        <div class="mb-3">
                            <p class="mb-1 text-muted">Nom complet :</p>
                            <p class="h5">{{ $paiement->commande->user->prenom }} {{ $paiement->commande->user->nom }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted">Email :</p>
                            <p>{{ $paiement->commande->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted">Téléphone :</p>
                            <p>{{ $paiement->commande->user->telephone }}</p>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>Informations client non disponibles.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce paiement ?</p>
                    <p><strong>Montant:</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</p>
                    <p><strong>Référence:</strong> PAY-{{ $paiement->id }}</p>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle me-2"></i>Cette action est irréversible.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
