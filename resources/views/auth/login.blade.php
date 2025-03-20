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
    <div class="content pgcon">
        @if (!request()->routeIs('login') && !request()->routeIs('register')) {{-- Si ce n'est ni la page de connexion ni la page d'inscription --}}
        @include('layouts.partiels.navbar')
        @endif

            <div class="container-fluid">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-7">
                        <div class="bg-white rounded shadow-lg p-0 my-4 mx-3">
                            <div class="row g-0">
                                <!-- Image côté gauche (visible seulement sur tablette/desktop) -->
                                <div class="col-md-5 d-none d-md-block">
                                    <img src="{{asset('build/assets/images/bg.jpg')}}"
                                         class="img-fluid rounded-start h-100"
                                         alt="Burger Image"
                                         style="object-fit: cover;">
                                </div>

                                <!-- Formulaire côté droit -->
                                <div class="col-md-7">
                                    <div class="p-4 p-xl-5">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <a href="{{ url('/') }}" class="text-decoration-none">
                                                <h3 class="text-primary fw-bold mb-0"></i>ISI BURGER</h3>
                                            </a>
                                            <h3 class="fw-bold text-dark mb-0">Connexion</h3>
                                        </div>

                                        <x-auth-session-status class="alert alert-info mb-4" :status="session('status')" />

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="form-floating mb-4">
                                                <x-text-input id="email" class="form-control border-0 border-bottom rounded-0 @error('email') is-invalid @enderror"
                                                              type="email" name="email" :value="old('email')" required autofocus
                                                              autocomplete="username" placeholder="name@example.com" />
                                                <label for="email" class="text-muted">
                                                    <i class="fa fa-envelope text-primary me-2"></i>Adresse email
                                                </label>
                                                <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                                            </div>

                                            <div class="form-floating mb-4">
                                                <x-text-input id="password" class="form-control border-0 border-bottom rounded-0 @error('password') is-invalid @enderror"
                                                              type="password" name="password" required
                                                              autocomplete="current-password" placeholder="Password" />
                                                <label for="password" class="text-muted">
                                                    <i class="fa fa-lock text-primary me-2"></i>Mot de passe
                                                </label>
                                                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="form-check">
                                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                                    <label class="form-check-label text-muted" for="remember_me">Se souvenir de moi</label>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                                                        Mot de passe oublié?
                                                    </a>
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4 rounded-pill fw-bold">
                                                <i class="fa fa-sign-in-alt me-2"></i>Connexion
                                            </button>

                                            <p class="text-center mb-0 text-muted">
                                                Pas encore de compte?
                                                <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                                                    Inscription
                                                </a>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3 text-muted">
                            <small>&copy; ISI-BURGER - Tous droits réservés</small>
                        </div>
                    </div>
                </div>
            </div>

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
