

<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">ISI BURGER</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                    {{ strtoupper(substr(auth()->user()->prenom, 0, 1) . substr(auth()->user()->nom, 0, 1)) }}
                </div>
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::check() ? Auth::user()->prenom.' '.Auth::user()->nom : 'Invité' }}</h6>
                <span>{{ Auth::check() ? Auth::user()->role : 'Non connecté' }}</span>
            </div>
        </div>

        @if(Auth::check())
            <div class="navbar-nav w-100">
                <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i>Tableau de bord
                </a>

                <!-- Menu Burgers - Différent pour client et gestionnaire -->
                @if(Auth::user()->role === 'gestionnaire')
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('burgers.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-hamburger me-2"></i>Gestion Burgers
                        </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('burgers.index') }}" class="dropdown-item">Liste des burgers</a>
                            <a href="{{ route('burgers.create') }}" class="dropdown-item">Ajouter un burger</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('catalogue') }}" class="nav-item nav-link {{ request()->routeIs('catalogue') ? 'active' : '' }}">
                        <i class="fa fa-hamburger me-2"></i>Catalogue
                    </a>
                @endif

                <!-- Menu Commandes - Différent pour client et gestionnaire -->
                @if(Auth::user()->role === 'gestionnaire')
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('commandes.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-shopping-cart me-2"></i>Gestion Commandes
                        </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('commandes.index') }}" class="dropdown-item">Toutes les commandes</a>
                            <a href="{{ route('commandes.create') }}" class="dropdown-item">Nouvelle commande</a>
                        </div>
                    </div>
                @else
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('commandes.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fa fa-shopping-cart me-2"></i>Mes Commandes
                        </a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('commandes.mes_commandes') }}" class="dropdown-item">Historique commandes</a>
                            <a href="{{ route('catalogue') }}" class="dropdown-item">Commander</a>
                        </div>
                    </div>
                @endif

                <!-- Paiements - uniquement pour les gestionnaires -->
                @if(Auth::user()->role === 'gestionnaire')
                    <a href="{{ route('paiements.index') }}" class="nav-item nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                        <i class="fa fa-credit-card me-2"></i>Paiements
                    </a>
                @endif

                <!-- Compte utilisateur -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('profile.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                        <i class="fa fa-user-cog me-2"></i>Mon compte
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fa fa-user-edit me-2 text-primary"></i>Modifier profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa fa-sign-out-alt me-2"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Menu pour les utilisateurs non connectés -->
            <div class="navbar-nav w-100">
                <a href="{{ route('login') }}" class="nav-item nav-link">
                    <i class="fa fa-sign-in-alt me-2"></i>Connexion
                </a>
                <a href="{{ route('register') }}" class="nav-item nav-link">
                    <i class="fa fa-user-plus me-2"></i>Inscription
                </a>
            </div>
        @endif
    </nav>
</div>
<!-- Sidebar End -->
