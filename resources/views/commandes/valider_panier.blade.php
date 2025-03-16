@extends('layouts.master')

@section('contenu')
    <!-- Titre de la page -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0"><i class="fa fa-shopping-cart me-2"></i>Validation du panier</h3>
                    <a href="{{ route('burgers.index') }}" class="btn btn-primary">
                        <i class="fa fa-arrow-left me-1"></i> Retour au catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Récapitulatif du panier -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <h5 class="mb-4"><i class="fa fa-list me-2"></i>Récapitulatif de votre commande</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead>
                            <tr class="text-dark">
{{--                                <th width="80">Image</th>--}}
                                <th>Burger</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="panier-items">
                            <!-- Les éléments du panier seront affichés ici via JavaScript -->
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Chargement...</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total</th>
                                <th id="panier-total">0.00 €</th>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations de commande -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-md-8">
                <div class="bg-light rounded p-4">
                    <h5 class="mb-4"><i class="fa fa-info-circle me-2"></i>Informations de la commande</h5>
                    <form id="form-valider-panier">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numCommande" name="numCommande" value="CMD-{{ time() }}" readonly>
                                    <label for="numCommande">Numéro de commande</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Instructions spéciales" id="instructions" name="instructions" style="height: 100px"></textarea>
                                    <label for="instructions">Instructions spéciales (facultatif)</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light rounded p-4 h-100">
                    <h5 class="mb-4"><i class="fa fa-credit-card me-2"></i>Paiement</h5>
                    <div class="d-flex flex-column h-100">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total:</span>
                                <span id="sous-total">0.00 €</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>TVA (20%):</span>
                                <span id="tva">0.00 €</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Total:</strong>
                                <strong id="total-with-tax" class="text-primary">0.00 €</strong>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="alert alert-info mb-3">
                                <i class="fa fa-info-circle me-2"></i>Le paiement se fera à la livraison ou sur place.
                            </div>
                            <button id="btn-valider-commande" class="btn btn-primary w-100">
                                <i class="fa fa-check me-1"></i> Confirmer la commande
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer le panier depuis localStorage
        const panier = JSON.parse(localStorage.getItem('panier')) || [];
        const panierItems = document.getElementById('panier-items');
        const panierTotal = document.getElementById('panier-total');
        const sousTotal = document.getElementById('sous-total');
        const tva = document.getElementById('tva');
        const totalWithTax = document.getElementById('total-with-tax');

        // Afficher les éléments du panier
        function renderPanier() {
            if (panier.length === 0) {
                panierItems.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="alert alert-info mb-0">
                            <i class="fa fa-info-circle me-2"></i>Votre panier est vide
                        </div>
                        <a href="{{ route('burgers.index') }}" class="btn btn-primary mt-3">
                            <i class="fa fa-hamburger me-1"></i> Retour au catalogue
                        </a>
                    </td>
                </tr>
            `;
                panierTotal.innerText = '0.00 €';
                sousTotal.innerText = '0.00 €';
                tva.innerText = '0.00 €';
                totalWithTax.innerText = '0.00 €';
                return;
            }

            let html = '';
            let total = 0;

            for (let index = 0; index < panier.length; index++) {
                const item = panier[index];
                const itemPrix = parseFloat(item.prix);
                const itemQuantite = parseInt(item.quantite);
                const itemNom = item.nom;
                const itemTotal = itemPrix * itemQuantite;
                total += itemTotal;

                html += `
            <tr>
                <td>
                    <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded mx-auto" style="width: 50px; height: 50px;">
                        <i class="fa fa-hamburger"></i>
                    </div>
                </td>
                <td>${itemNom}</td>
                <td>${itemPrix.toFixed(2)} €</td>
                <td>
                    <div class="input-group input-group-sm w-75 mx-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary diminuerQuantite" data-index="${index}">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="text" class="form-control text-center" value="${itemQuantite}" readonly>
                        <button type="button" class="btn btn-sm btn-outline-primary augmenterQuantite" data-index="${index}">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </td>
                <td>${itemTotal.toFixed(2)} €</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger supprimerItem" data-index="${index}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            `;
            }

            panierItems.innerHTML = html;
            panierTotal.innerText = total.toFixed(2) + ' €';
            sousTotal.innerText = total.toFixed(2) + ' €';

            const taxAmount = total * 0.2;
            tva.innerText = taxAmount.toFixed(2) + ' €';

            const totalWithTaxAmount = total + taxAmount;
            totalWithTax.innerText = totalWithTaxAmount.toFixed(2) + ' €';

            // Ajouter les événements aux boutons
            var diminuerButtons = document.querySelectorAll('.diminuerQuantite');
            for (var i = 0; i < diminuerButtons.length; i++) {
                diminuerButtons[i].addEventListener('click', function() {
                    var buttonIndex = parseInt(this.getAttribute('data-index'));
                    if (panier[buttonIndex].quantite > 1) {
                        panier[buttonIndex].quantite--;
                        localStorage.setItem('panier', JSON.stringify(panier));
                        renderPanier();
                    }
                });
            }

            var augmenterButtons = document.querySelectorAll('.augmenterQuantite');
            for (var j = 0; j < augmenterButtons.length; j++) {
                augmenterButtons[j].addEventListener('click', function() {
                    var buttonIndex = parseInt(this.getAttribute('data-index'));
                    panier[buttonIndex].quantite++;
                    localStorage.setItem('panier', JSON.stringify(panier));
                    renderPanier();
                });
            }

            var supprimerButtons = document.querySelectorAll('.supprimerItem');
            for (var k = 0; k < supprimerButtons.length; k++) {
                supprimerButtons[k].addEventListener('click', function() {
                    var buttonIndex = parseInt(this.getAttribute('data-index'));
                    panier.splice(buttonIndex, 1);
                    localStorage.setItem('panier', JSON.stringify(panier));
                    renderPanier();
                });
            }
        }

        // Valider la commande
        document.getElementById('btn-valider-commande').addEventListener('click', function() {
            if (panier.length === 0) {
                alert('Votre panier est vide.');
                return;
            }

            // Préparer les données pour l'API
            var burgers = [];
            var quantiteArray = [];

            for (var i = 0; i < panier.length; i++) {
                burgers.push(panier[i].id);
                quantiteArray.push(panier[i].quantite);
            }

            // Envoyer la commande à l'API
            fetch('{{ route("valider_panier") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    numCommande: document.getElementById('numCommande').value,
                    statut: 'En attente',
                    burgers: burgers,
                    quantite: quantiteArray
                })
            })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.message) {
                        // Vider le panier après succès
                        localStorage.removeItem('panier');

                        // Afficher un message de succès
                        alert(data.message);

                        // Rediriger vers la page des commandes
                        window.location.href = '{{ route("commandes.mes_commandes") }}';
                    }
                })
                .catch(function(error) {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la validation de votre commande.');
                });
        });

        // Initialiser l'affichage du panier
        renderPanier();
    });
</script>
@section('scripts')

@endsection
