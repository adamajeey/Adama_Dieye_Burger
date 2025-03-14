<!-- Sidebar for Guests Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">ISI BURGER</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Invité</h6>
                <span>Non connecté</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i>Accueil
            </a>
            <a href="{{ route('login') }}" class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="fa fa-sign-in-alt me-2"></i>Connexion
            </a>
            <a href="{{ route('register') }}" class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
                <i class="fa fa-user-plus me-2"></i>Inscription
            </a>
        </div>
    </nav>
</div>
<!-- Sidebar for Guests End -->
