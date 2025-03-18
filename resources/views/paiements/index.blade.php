@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <!-- Titre et bouton d'ajout -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Liste des Paiements</h6>
                    <a href="{{ route('paiements.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Nouveau Paiement
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tableau des paiements -->
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Commande</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Reçu</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->id }}</td>
                                    <td>{{ $paiement->commande->numCommande ?? 'N/A' }}</td>
                                    <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</td>
                                    <td>
                                        @if($paiement->url_pdf)
                                            <a href="{{ asset($paiement->url_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-file-pdf me-1"></i>Voir
                                            </a>
                                        @else
                                            <span class="badge bg-warning">Non disponible</span>
                                        @endif
                                    </td>
                                    <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $paiement->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de suppression -->
                                        <div class="modal fade" id="deleteModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $paiement->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $paiement->id }}">Confirmation de suppression</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir supprimer ce paiement ?</p>
                                                        <p><strong>Montant:</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</p>
                                                        <p><strong>Commande:</strong> {{ $paiement->commande->numCommande ?? 'N/A' }}</p>
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle me-2"></i>Aucun paiement enregistré pour le moment.
                                        </div>
                                    </td>
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
