@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <!-- Titre et bouton retour -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Modifier le Paiement</h6>
                    <div>
                        <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-secondary me-2">
                            <i class="fa fa-eye me-1"></i>Voir détails
                        </a>
                        <a href="{{ route('paiements.index') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left me-1"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <form action="{{ route('paiements.update', $paiement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="commande_id" class="form-label">Commande</label>
                                <select class="form-select @error('commande_id') is-invalid @enderror" name="commande_id" id="commande_id" required>
                                    <option value="">Sélectionner une commande</option>
                                    @foreach(\App\Models\Commande::orderBy('created_at', 'desc')->get() as $commande)
                                        <option value="{{ $commande->id }}" {{ (old('commande_id') ?? $paiement->commande_id) == $commande->id ? 'selected' : '' }}>
                                            #{{ $commande->numCommande }} ({{ number_format($commande->details->sum(function($detail) {
                                                return $detail->burger->prix * $detail->quantite;
                                            }), 0, ',', ' ') }} F CFA)
                                        </option>
                                    @endforeach
                                </select>
                                @error('commande_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="montant" class="form-label">Montant</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('montant') is-invalid @enderror"
                                           id="montant" name="montant" value="{{ old('montant') ?? $paiement->montant }}" required>
                                    <span class="input-group-text">F CFA</span>
                                    @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="url_pdf" class="form-label">Reçu de paiement (PDF)</label>
                            <input type="file" class="form-control @error('url_pdf') is-invalid @enderror"
                                   id="url_pdf" name="url_pdf" accept=".pdf">
                            @error('url_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                @if($paiement->url_pdf)
                                    <div class="mt-2">
                                        <span class="text-success"><i class="fa fa-check-circle me-1"></i>Un reçu est déjà téléchargé.</span>
                                        <a href="{{ asset($paiement->url_pdf) }}" target="_blank" class="ms-2">Voir le reçu actuel</a>
                                    </div>
                                @endif
                                Ne téléchargez un nouveau reçu que si vous souhaitez remplacer l'existant.
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-danger me-md-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa fa-trash me-1"></i>Supprimer
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // JavaScript supplémentaire si nécessaire
    });
</script>
@section('scripts')

@endsection
