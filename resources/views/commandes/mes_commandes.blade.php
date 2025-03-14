@extends('layouts.master')

@section('contenu')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Mes Commandes</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($commandes as $commande)
                                    <tr>
                                        <td>{{ $commande->numCommande }}</td>
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
                                            {{ number_format($total, 2, ',', ' ') }} €
                                        </td>
                                        <td>
                                            <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Détails
                                            </a>
                                            @if($commande->statut == 'Prête')
                                                <a href="#" class="btn btn-sm btn-success" onclick="window.open('{{ route('factures.telecharger', $commande->id) }}', '_blank')">
                                                    <i class="fas fa-file-pdf"></i> Facture
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Vous n'avez pas encore passé de commande</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('catalogue') }}" class="btn btn-primary">
                                <i class="fas fa-burger"></i> Commander des burgers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
