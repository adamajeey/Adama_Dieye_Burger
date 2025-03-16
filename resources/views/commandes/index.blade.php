@extends('layouts.master')

@section('contenu')
    <!-- Titre de la page -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0"><i class="fa fa-shopping-bag me-2"></i>Gestion des Commandes</h3>
                    <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Nouvelle Commande
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr class="text-dark">
                                <th scope="col">Numéro</th>
                                <th scope="col">Client</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Date</th>
                                <th scope="col">Total</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->numCommande }}</td>
                                    <td>{{ $commande->user->name ?? 'N/A' }}</td>
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
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @php
                                            $total = 0;
                                            foreach($commande->details as $detail) {
                                                $total += $detail->burger->prix * $detail->quantite;
                                            }
                                        @endphp
                                        {{ number_format($total, 2, ',', ' ') }} F CFA
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editStatutModal{{ $commande->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Modal pour modifier le statut -->
                                        <div class="modal fade" id="editStatutModal{{ $commande->id }}" tabindex="-1" aria-labelledby="editStatutModalLabel{{ $commande->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="editStatutModalLabel{{ $commande->id }}">Modifier le statut de la commande #{{ $commande->numCommande }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="numCommande" value="{{ $commande->numCommande }}">
                                                            <div class="mb-3">
                                                                <label for="statut" class="form-label">Statut</label>
                                                                <select class="form-select" name="statut" id="statut" required>
                                                                    <option value="En attente" {{ $commande->statut == 'En attente' ? 'selected' : '' }}>En attente</option>
                                                                    <option value="En préparation" {{ $commande->statut == 'En préparation' ? 'selected' : '' }}>En préparation</option>
                                                                    <option value="Prête" {{ $commande->statut == 'Prête' ? 'selected' : '' }}>Prête</option>
                                                                    <option value="Payée" {{ $commande->statut == 'Payée' ? 'selected' : '' }}>Payée</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="fa fa-info-circle me-2"></i>Aucune commande trouvée
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
