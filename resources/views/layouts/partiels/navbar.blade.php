<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hamburger"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
{{--    <form class="d-none d-md-flex ms-4">--}}
{{--        <input class="form-control border-0" type="search" placeholder="Rechercher">--}}
{{--    </form>--}}
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-shopping-cart me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Commandes</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <!-- Si l'utilisateur est gestionnaire, afficher le lien pour voir toutes les commandes -->
                @if(auth()->user()->role === 'gestionnaire')
                    <a href="{{ route('commandes.index') }}" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa fa-clipboard-list"></i>
                            </div>
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">Voir toutes les commandes</h6>
                                <small>Gérer les commandes en cours</small>
                            </div>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                @endif

                <!-- Accessible à tous les utilisateurs connectés -->
                <a href="{{ route('commandes.create') }}" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa fa-cart-plus"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">Nouvelle commande</h6>
                            <small>Créer une commande</small>
                        </div>
                    </div>
                </a>

                <!-- Si l'utilisateur est client, afficher le lien pour voir ses propres commandes -->
                @if(auth()->user()->role === 'client' || auth()->user()->role === 'gestionnaire')
                    <hr class="dropdown-divider">
                    <a href="{{ route('commandes.mes_commandes') }}" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa fa-list"></i>
                            </div>
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">Mes commandes</h6>
                                <small>Voir mon historique</small>
                            </div>
                        </div>
                    </a>
                @endif

                <!-- Si l'utilisateur est gestionnaire, afficher le lien pour les paiements -->
                @if(auth()->user()->role === 'gestionnaire')
                    <hr class="dropdown-divider">
                    <a href="{{ route('paiements.index') }}" class="dropdown-item text-center">Voir tous les paiements</a>
                @endif
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notifications</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Nouvelle commande reçue</h6>
                    <small>Il y a 15 minutes</small>
                </a>
                <hr class="dropdown-divider">
                @if(auth()->user()->role === 'gestionnaire')
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">Stock de burgers faible</h6>
                        <small>Il y a 30 minutes</small>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">Paiement reçu</h6>
                        <small>Il y a 1 heure</small>
                    </a>
                    <hr class="dropdown-divider">
                @endif
                <a href="#" class="dropdown-item text-center">Voir toutes les notifications</a>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
{{--                <img class="rounded-circle me-lg-2" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">--}}
                <span class="d-none d-lg-inline-flex">
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fa fa-user-edit me-2 text-primary"></i>Mon Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-sign-out-alt me-2 text-danger"></i>Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
