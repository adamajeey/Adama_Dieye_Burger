@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Espace client</h6>
                </div>
            </div>
        </div>

        <!-- Cartes de statistiques -->
        <div class="row g-4 mt-2">
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-shopping-bag fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Mes Commandes</p>
                        <h6 class="mb-0">{{ $stats['total_commandes'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-clock fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">En cours</p>
                        <h6 class="mb-0">{{ $stats['commandes_en_cours'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-wallet fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total dépensé</p>
                        <h6 class="mb-0">{{ number_format($stats['total_depense'], 0, ',', ' ') }} F CFA</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Actions rapides</h6>
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <a href="{{ route('catalogue') }}" class="text-decoration-none">
                                <div class="bg-primary rounded p-4 text-center text-white">
                                    <i class="fa fa-hamburger fa-4x mb-3"></i>
                                    <h5>Voir le catalogue</h5>
                                    <p class="mb-0">Découvrez nos burgers</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('commandes.mes_commandes') }}" class="text-decoration-none">
                                <div class="bg-success rounded p-4 text-center text-white">
                                    <i class="fa fa-list-alt fa-4x mb-3"></i>
                                    <h5>Mes commandes</h5>
                                    <p class="mb-0">Voir mon historique</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                                <div class="bg-info rounded p-4 text-center text-white">
                                    <i class="fa fa-user-edit fa-4x mb-3"></i>
                                    <h5>Mon profil</h5>
                                    <p class="mb-0">Modifier mes informations</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Mes commandes récentes</h6>
                        <a href="{{ route('commandes.mes_commandes') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-list me-2"></i>Voir toutes
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">N° commande</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($commandes_recentes as $commande)
                                <tr>
                                    <td>{{ $commande->numCommande }}</td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($commande->statut == 'En attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($commande->statut == 'En préparation')
                                            <span class="badge bg-info">En préparation</span>
                                        @elseif($commande->statut == 'Prête')
                                            <span class="badge bg-success">Prête</span>
                                        @elseif($commande->statut == 'Payée')
                                            <span class="badge bg-primary">Payée</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $total = 0;
                                            foreach($commande->details as $detail) {
                                                $total += $detail->burger->prix * $detail->quantite;
                                            }
                                        @endphp
                                        {{ number_format($total, 0, ',', ' ') }} F CFA
                                    </td>
                                    <td>
                                        <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Vous n'avez pas encore de commandes</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Burgers populaires -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Burgers à découvrir</h6>
                        <a href="{{ route('catalogue') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-hamburger me-2"></i>Voir tous
                        </a>
                    </div>
                    <div class="row">
                        @foreach($burgers_populaires as $burger)
                            <div class="col-md-4 mb-3">
                                <div class="bg-white rounded shadow-sm p-3 h-100">
                                    <div class="position-relative mb-3">
                                        <img src="{{ asset($burger->image) }}" class="img-fluid rounded" alt="{{ $burger->libelle }}" style="height: 160px; width: 100%; object-fit: cover;">
                                    </div>
                                    <h5 class="text-primary">{{ $burger->libelle }}</h5>
                                    <p>{{ Str::limit($burger->description, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="fw-bold">{{ number_format($burger->prix, 0, ',', ' ') }} F CFA</span>
                                        <a href="{{ route('catalogue') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye me-1"></i>Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
