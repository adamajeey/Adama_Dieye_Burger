@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <!-- Titre et bouton retour -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Nouveau Paiement</h6>
                    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire de création -->
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <form action="{{ route('paiements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="commande_id" class="form-label">Commande</label>
                                <select class="form-select @error('commande_id') is-invalid @enderror" name="commande_id" id="commande_id" required>
                                    <option value="">Sélectionner une commande</option>
                                    @foreach(\App\Models\Commande::orderBy('created_at', 'desc')->get() as $commande)
                                        <option value="{{ $commande->id }}" {{ old('commande_id') == $commande->id ? 'selected' : '' }}>
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
                                           id="montant" name="montant" value="{{ old('montant') }}" required>
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
                                   id="url_pdf" name="url_pdf" accept=".pdf" required>
                            @error('url_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Veuillez télécharger le reçu de paiement au format PDF.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-light me-md-2">
                                <i class="fa fa-refresh me-1"></i>Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-1"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vous pouvez ajouter du JavaScript personnalisé ici
        // Par exemple, pour mettre à jour automatiquement le montant en fonction de la commande sélectionnée
        const commandeSelect = document.getElementById('commande_id');
        const montantInput = document.getElementById('montant');

        commandeSelect.addEventListener('change', function() {
            // Vous pourriez utiliser AJAX ici pour récupérer le montant total de la commande
            // ou pré-stocker les montants dans des attributs data-* sur les options
        });
    });
</script>

@section('scripts')

@endsection
