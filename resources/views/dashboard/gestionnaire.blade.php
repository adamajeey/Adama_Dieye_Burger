@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Tableau de bord gestionnaire</h6>
                </div>
            </div>
        </div>

        <!-- Cartes de statistiques -->
        <div class="row g-4 mt-2">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Ventes Aujourd'hui</p>
                        <h6 class="mb-0">{{ $stats['commandes_jour'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Revenus Aujourd'hui</p>
                        <h6 class="mb-0">{{ number_format($stats['revenus_jour'], 0, ',', ' ') }} F CFA</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Commandes</p>
                        <h6 class="mb-0">{{ $stats['total_commandes'] }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Commandes en cours</p>
                        <h6 class="mb-0">{{ $stats['commandes_en_cours'] }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row g-4 mt-2">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Commandes par statut</h6>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Commandes par mois</h6>
                    <canvas id="commandesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Burgers en rupture / faible stock -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Burgers en rupture ou faible stock</h6>
                        <a href="{{ route('burgers.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-cog me-2"></i>Gérer les stocks
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Libellé</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($low_stock_burgers as $burger)
                                <tr>
                                    <td>
                                        <img src="{{ asset($burger->image) }}" alt="{{ $burger->libelle }}"
                                             class="rounded" width="50" height="50">
                                    </td>
                                    <td>{{ $burger->libelle }}</td>
                                    <td>{{ number_format($burger->prix, 0, ',', ' ') }} F CFA</td>
                                    <td>
                                        @if($burger->stock == 0)
                                            <span class="badge bg-danger">Épuisé</span>
                                        @else
                                            <span class="badge bg-warning">{{ $burger->stock }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Modifier stock
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tous les burgers ont un stock suffisant</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0">Commandes récentes</h6>
                        <a href="{{ route('commandes.index') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-list me-2"></i>Voir toutes les commandes
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Numéro</th>
                                <th scope="col">Client</th>
                                <th scope="col">Date</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recent_orders as $commande)
                                <tr>
                                    <td>{{ $commande->numCommande }}</td>
                                    <td>{{ $commande->user->prenom }} {{ $commande->user->nom }}</td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($commande->statut == 'En attente' || $commande->statut == 0)
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($commande->statut == 'En préparation' || $commande->statut == 1)
                                            <span class="badge bg-info">En préparation</span>
                                        @elseif($commande->statut == 'Prête' || $commande->statut == 2)
                                            <span class="badge bg-success">Prête</span>
                                        @elseif($commande->statut == 'Payée' || $commande->statut == 3)
                                            <span class="badge bg-primary">Payée</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $commande->statut }}</span>
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
                                    <td colspan="6" class="text-center">Aucune commande récente</td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des statuts de commandes
        var statusCtx = document.getElementById('statusChart');
        var statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'En préparation', 'Prête', 'Payée'],
                datasets: [{
                    data: [
                        {{ $stats['statut_attente'] }},
                        {{ $stats['statut_preparation'] }},
                        {{ $stats['statut_prete'] }},
                        {{ $stats['statut_payee'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(0, 123, 255, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Graphique des commandes par mois
        var commandesCtx = document.getElementById('commandesChart');
        var commandesChart = new Chart(commandesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($commandes_par_mois['mois_labels']) !!},
                datasets: [{
                    label: 'Nombre de commandes',
                    data: {!! json_encode($commandes_par_mois['commandes_par_mois']) !!},
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@section('scripts')
@endsection
