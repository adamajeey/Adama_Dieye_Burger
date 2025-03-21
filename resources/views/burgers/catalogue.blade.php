@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <!-- Titre et bouton panier -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h6 class="mb-0">Catalogue des Burgers</h6>
                    <button type="button" class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#panierOffcanvas">
                        <i class="fa fa-shopping-cart me-2"></i>Mon Panier
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="panierCount">0</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-3">Filtrer les burgers</h6>
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-4">
                            <label for="prix_min" class="form-label">Prix minimum</label>
                            <input type="number" class="form-control" id="prix_min" name="prix_min" min="0" step="500" value="{{ request('prix_min') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="prix_max" class="form-label">Prix maximum</label>
                            <input type="number" class="form-control" id="prix_max" name="prix_max" min="0" step="500" value="{{ request('prix_max') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="libelle" class="form-label">Nom du burger</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Rechercher..." value="{{ request('libelle') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fa fa-search me-1"></i>Filtrer
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fa fa-sync me-1"></i>Réinitialiser
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse ($burgers as $burger)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="bg-light rounded h-100 p-4">
                        <div class="position-relative mb-3">
                            <img src="{{ asset($burger->image) }}" class="img-fluid rounded w-100" alt="{{ $burger->libelle }}" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($burger->stock > 0)
                                    <span class="badge bg-success">En stock</span>
                                @else
                                    <span class="badge bg-danger">Rupture</span>
                                @endif
                            </div>
                        </div>
                        <h5 class="text-primary">{{ $burger->libelle }}</h5>
                        <p class="mb-3">{{ Str::limit($burger->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">{{ number_format($burger->prix, 0, ',', ' ') }} F CFA</h5>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#burgerModal{{ $burger->id }}">
                                    <i class="fa fa-eye me-1"></i>Détails
                                </button>
                                <button type="button" class="btn btn-sm btn-primary ajouterPanier" data-id="{{ $burger->id }}" data-libelle="{{ $burger->libelle }}" data-prix="{{ $burger->prix }}" {{ $burger->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-cart-plus me-1"></i>Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Détails -->
                <div class="modal fade" id="burgerModal{{ $burger->id }}" tabindex="-1" aria-labelledby="burgerModalLabel{{ $burger->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="burgerModalLabel{{ $burger->id }}">{{ $burger->libelle }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <img src="{{ asset($burger->image) }}" class="img-fluid rounded" alt="{{ $burger->libelle }}" style="max-height: 200px;">
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-primary"><i class="fa fa-info-circle me-2"></i>Description:</h6>
                                    <p>{{ $burger->description }}</p>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-primary"><i class="fa fa-tag me-2"></i>Prix:</h6>
                                        <p class="h4 text-primary">{{ number_format($burger->prix, 0, ',', ' ') }} F CFA</p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-primary"><i class="fa fa-cubes me-2"></i>Disponibilité:</h6>
                                        @if($burger->stock > 0)
                                            <span class="badge bg-success p-2">Disponible</span>
                                        @else
                                            <span class="badge bg-danger p-2">Indisponible</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-primary ajouterPanier" data-id="{{ $burger->id }}" data-libelle="{{ $burger->libelle }}" data-prix="{{ $burger->prix }}" {{ $burger->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fa fa-cart-plus me-1"></i>Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>Aucun burger disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($burgers) && $burgers->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $burgers->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Panier Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="panierOffcanvas" aria-labelledby="panierOffcanvasLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title" id="panierOffcanvasLabel"><i class="fa fa-shopping-cart me-2"></i>Votre Panier</h5>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="panierItems">
                <!-- Les items du panier seront affichés ici via JavaScript -->
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>Votre panier est vide
                </div>
            </div>
            <div class="border-top pt-3 mt-3">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Total:</h5>
                    <h5 id="panierTotal" class="text-primary">0 F CFA</h5>
                </div>
                <div class="d-grid gap-2">
                    <button id="viderPanier" class="btn btn-outline-danger">
                        <i class="fa fa-trash me-1"></i>Vider le panier
                    </button>
                    <button id="validerCommande" class="btn btn-success">
                        <i class="fa fa-check me-1"></i>Valider la commande
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variable globale pour stocker les articles du panier
        // Récupération depuis le localStorage ou création d'un tableau vide
        let panier = JSON.parse(localStorage.getItem('panier')) || [];

        /**
         * Met à jour l'affichage du panier dans l'interface
         * Calcule le nombre total d'articles et le montant total
         */
        function updatePanierDisplay() {
            const panierCount = document.getElementById('panierCount');
            const panierItems = document.getElementById('panierItems');
            const panierTotal = document.getElementById('panierTotal');

            // Vérification de l'existence des éléments DOM
            if (!panierCount || !panierItems || !panierTotal) {
                console.error("Éléments du panier non trouvés dans le DOM");
                return;
            }

            // Calcul et affichage du nombre total d'articles dans le badge
            panierCount.textContent = panier.reduce(function(total, item) {
                return total + parseInt(item.quantite);
            }, 0);

            // Affichage d'un message si le panier est vide
            if (panier.length === 0) {
                panierItems.innerHTML = '<div class="alert alert-info"><i class="fa fa-info-circle me-2"></i>Votre panier est vide</div>';
                panierTotal.textContent = '0 F CFA';
                return;
            }

            // Génération du HTML pour chaque article du panier
            let html = '';
            let total = 0;

            for (let i = 0; i < panier.length; i++) {
                const item = panier[i];
                const itemTotal = parseFloat(item.prix) * parseInt(item.quantite);
                total += itemTotal;

                html += `
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">${item.libelle}</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger retirerItem" data-index="${i}">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted">${parseInt(item.prix).toLocaleString('fr-FR')} F CFA x </span>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary diminuerQuantite" data-index="${i}">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <span class="btn btn-outline-primary">${item.quantite}</span>
                                    <button type="button" class="btn btn-outline-primary augmenterQuantite" data-index="${i}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <span class="fw-bold">${itemTotal.toLocaleString('fr-FR')} F CFA</span>
                        </div>
                    </div>`;
            }

            // Mise à jour du HTML et du total
            panierItems.innerHTML = html;
            panierTotal.textContent = total.toLocaleString('fr-FR') + ' F CFA';

            // Attachement des écouteurs d'événements aux boutons du panier
            attachPanierEventListeners();
        }

        /**
         * Attache les gestionnaires d'événements aux boutons du panier
         * en utilisant la délégation d'événements pour optimiser les performances
         */
        function attachPanierEventListeners() {
            const panierItems = document.getElementById('panierItems');
            if (!panierItems) return;

            // Utiliser la délégation d'événements pour tous les boutons dans le panier
            panierItems.addEventListener('click', function(event) {
                // Trouve le bouton le plus proche qui a été cliqué
                const target = event.target.closest('.retirerItem, .diminuerQuantite, .augmenterQuantite');
                if (!target) return;

                // Récupère l'index de l'article dans le panier
                const index = parseInt(target.getAttribute('data-index'));

                // Exécute l'action correspondante au bouton cliqué
                if (target.classList.contains('retirerItem')) {
                    // Supprime l'article du panier
                    panier.splice(index, 1);
                } else if (target.classList.contains('diminuerQuantite')) {
                    // Diminue la quantité mais pas en dessous de 1
                    if (panier[index].quantite > 1) {
                        panier[index].quantite--;
                    }
                } else if (target.classList.contains('augmenterQuantite')) {
                    // Augmente la quantité
                    panier[index].quantite++;
                }

                // Sauvegarde et met à jour l'affichage
                savePanier();
                updatePanierDisplay();
            });
        }

        /**
         * Sauvegarde le panier dans le localStorage
         * Gère les erreurs potentielles (ex: stockage plein)
         */
        function savePanier() {
            try {
                localStorage.setItem('panier', JSON.stringify(panier));
            } catch (e) {
                console.error("Erreur lors de la sauvegarde du panier:", e);
            }
        }

        /**
         * Initialise les boutons d'ajout au panier
         * pour tous les produits affichés sur la page
         */
        function initAjouterButtons() {
            const ajouterBoutons = document.querySelectorAll('.ajouterPanier');
            if (!ajouterBoutons.length) {
                console.warn("Aucun bouton d'ajout au panier trouvé");
                return;
            }

            // Ajoute un écouteur d'événement à chaque bouton
            ajouterBoutons.forEach(button => {
                button.addEventListener('click', function() {
                    // Récupère les données du produit depuis les attributs data-*
                    const id = parseInt(this.getAttribute('data-id'));
                    const libelle = this.getAttribute('data-libelle');
                    const prix = parseFloat(this.getAttribute('data-prix'));

                    // Vérifie si le produit est déjà dans le panier
                    const existingItemIndex = panier.findIndex(item => item.id === id);

                    if (existingItemIndex !== -1) {
                        // Si le produit existe, augmente la quantité
                        panier[existingItemIndex].quantite++;
                    } else {
                        // Sinon, ajoute un nouvel article au panier
                        panier.push({
                            id: id,
                            libelle: libelle,
                            prix: prix,
                            quantite: 1
                        });
                    }

                    // Sauvegarde le panier, met à jour l'affichage et montre une notification
                    savePanier();
                    updatePanierDisplay();
                    showToast(libelle);
                });
            });
        }

        /**
         * Affiche une notification temporaire après l'ajout d'un produit
         * @param {string} libelle - Nom du produit ajouté
         */
        function showToast(libelle) {
            // Créer l'élément toast
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '5';
            toast.innerHTML = `
                    <div class="toast show bg-white" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-success text-white">
                            <strong class="me-auto">ISI BURGER</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <i class="fa fa-check-circle text-success me-2"></i> ${libelle} a été ajouté au panier.
                        </div>
                    </div>`;

            // Ajoute le toast au document
            document.body.appendChild(toast);

            // Supprime le toast après 3 secondes
            setTimeout(function() {
                if (toast && toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
        }

        /**
         * Initialise les boutons du panier (vider et valider)
         */
        function initPanierButtons() {
            const viderPanierBtn = document.getElementById('viderPanier');
            const validerCommandeBtn = document.getElementById('validerCommande');

            // Gestionnaire d'événement pour vider le panier
            if (viderPanierBtn) {
                viderPanierBtn.addEventListener('click', function () {
                    if (confirm('Êtes-vous sûr de vouloir vider le panier ?')) {
                        // Vide le panier et met à jour l'affichage
                        panier = [];
                        savePanier();
                        updatePanierDisplay();
                    }
                });
            }

            // Gestionnaire d'événement pour valider la commande
            if (validerCommandeBtn) {
                validerCommandeBtn.addEventListener('click', function () {
                    // Vérifie si le panier est vide
                    if (panier.length === 0) {
                        alert("Votre panier est vide !");
                        return;
                    }

                    // Désactive le bouton et affiche l'indicateur de chargement
                    validerCommandeBtn.disabled = true;
                    validerCommandeBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...';

                    // Envoie la requête au serveur avec le jeton CSRF
                    fetch("{{ route('valider_panier') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({ panier: panier }),
                    })
                        .then(response => {
                            // Vérifie si la réponse est OK
                            if (!response.ok) {
                                throw new Error('Erreur réseau: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Réponse du serveur:", data);

                            // Traitement en cas de succès
                            if (data.status === "success" || data.message) {
                                // Crée une notification toast de succès
                                const toast = document.createElement('div');
                                toast.className = 'position-fixed top-0 end-0 p-3';
                                toast.style.zIndex = '5';
                                toast.innerHTML = `
                                <div class="toast show bg-white" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header bg-success text-white">
                                        <strong class="me-auto">ISI BURGER</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        <i class="fa fa-check-circle text-success me-2"></i> ${data.message || "Commande validée avec succès!"}
                                    </div>
                                </div>`;
                                document.body.appendChild(toast);

                                // Vide le panier complètement
                                panier = [];
                                localStorage.removeItem("panier");
                                updatePanierDisplay();

                                // Ferme l'offcanvas après un court délai
                                setTimeout(() => {
                                    const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('panierOffcanvas'));
                                    if (offcanvas) {
                                        offcanvas.hide();
                                    }

                                    // Restaure le bouton
                                    validerCommandeBtn.disabled = false;
                                    validerCommandeBtn.innerHTML = '<i class="fa fa-check me-1"></i>Valider la commande';

                                    // Note: La redirection a été supprimée, on reste sur la page actuelle
                                }, 1500);
                            } else {
                                // Traitement en cas d'erreur côté serveur
                                alert("Erreur : " + (data.message || "Une erreur est survenue"));

                                // Restaure le bouton
                                validerCommandeBtn.disabled = false;
                                validerCommandeBtn.innerHTML = '<i class="fa fa-check me-1"></i>Valider la commande';
                            }
                        })
                        .catch(error => {
                            // Gestion des erreurs réseau ou autres
                            console.error("Erreur lors de la validation:", error);
                            alert("Une erreur est survenue lors de la validation de votre commande.");

                            // Restaure le bouton
                            validerCommandeBtn.disabled = false;
                            validerCommandeBtn.innerHTML = '<i class="fa fa-check me-1"></i>Valider la commande';
                        });
                });
            }
        }

        /**
         * Initialise le formulaire de filtre des produits
         */
        function initFilterForm() {
            const filterForm = document.getElementById('filterForm');
            if (!filterForm) return;

            // Gestion de la soumission du formulaire
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupère les valeurs des filtres
                const prixMin = document.getElementById('prix_min').value;
                const prixMax = document.getElementById('prix_max').value;
                const libelle = document.getElementById('libelle').value;

                // Construit l'URL avec les paramètres
                let url = '{{ route("catalogue") }}?';
                if (prixMin) url += `prix_min=${prixMin}&`;
                if (prixMax) url += `prix_max=${prixMax}&`;
                if (libelle) url += `libelle=${encodeURIComponent(libelle)}`;

                // Redirige avec les filtres
                window.location.href = url;
            });

            // Gestion du bouton de réinitialisation
            const resetButton = filterForm.querySelector('button[type="reset"]');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    window.location.href = '{{ route("catalogue") }}';
                });
            }
        }

        // Initialisation de l'application
        try {
            console.log("Initialisation de l'application de catalogue de burgers...");

            // Initialise tous les composants dans l'ordre
            initAjouterButtons();
            initPanierButtons();
            initFilterForm();
            updatePanierDisplay();

            console.log("Application initialisée avec succès");
        } catch (error) {
            console.error("Erreur lors de l'initialisation de l'application:", error);
        }
    });
</script>

@section('scripts')
@endsection
