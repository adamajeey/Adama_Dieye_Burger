<!DOCTYPE html>
<html lang="en">
@include('layouts.partiels.head')



<body>
<div class="container-fluid position-relative bg-white d-flex p-0">
    @if (!request()->routeIs('login')) {{-- Si ce n'est PAS la page de connexion --}}
    @include('layouts.partiels.spinner')
    @include('layouts.partiels.sidebar')
    @endif

    <!-- Content Start -->
    <div class="content">
        @if (!request()->routeIs('login')) {{-- Si ce n'est PAS la page de connexion --}}
        @include('layouts.partiels.navbar')
        @endif

        @yield('contenu')

        @if (!request()->routeIs('login')) {{-- Si ce n'est PAS la page de connexion --}}
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
