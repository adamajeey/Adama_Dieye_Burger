<!DOCTYPE html>
<html lang="en">
@include('layouts.partiels.head')

<body>
<div class="container-fluid position-relative bg-white d-flex p-0">
    @if (!request()->routeIs('login') && !request()->routeIs('register')) {{-- Si ce n'est ni la page de connexion ni la page d'inscription --}}
    @include('layouts.partiels.spinner')
    @auth
        @include('layouts.partiels.sidebar')
    @else
        @include('layouts.partiels.guest-sidebar')
    @endauth
    @endif

    <!-- Content Start -->
    <div class="content">
        @if (!request()->routeIs('login') && !request()->routeIs('register')) {{-- Si ce n'est ni la page de connexion ni la page d'inscription --}}
        @include('layouts.partiels.navbar')
        @endif

        @yield('contenu')

        @if (!request()->routeIs('login') && !request()->routeIs('register')) {{-- Si ce n'est ni la page de connexion ni la page d'inscription --}}
        @include('layouts.partiels.footer')
        @endif
    </div>
    <!-- Content End -->

    <!-- Back to Top -->
    <a href= "#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
@include('layouts.partiels.scripts')
</body>
</html>
