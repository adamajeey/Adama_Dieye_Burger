@extends('layouts.master')

@section('contenu')
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="bg-white rounded shadow-lg p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <h3 class="text-primary fw-bold mb-0"></i>ISI BURGER</h3>
                        </a>
                        <h3 class="fw-bold text-dark mb-0">Inscription</h3>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <!-- Prénom -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="prenom" class="form-control border-0 border-bottom rounded-0 @error('prenom') is-invalid @enderror"
                                           type="text" name="prenom" value="{{ old('prenom') }}"
                                           required autofocus placeholder="Prénom">
                                    <label for="prenom" class="text-muted">
                                        <i class="fa fa-user text-primary me-2"></i>Prénom
                                    </label>
                                    @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="nom" class="form-control border-0 border-bottom rounded-0 @error('nom') is-invalid @enderror"
                                           type="text" name="nom" value="{{ old('nom') }}"
                                           required placeholder="Nom">
                                    <label for="nom" class="text-muted">
                                        <i class="fa fa-user-tag text-primary me-2"></i>Nom
                                    </label>
                                    @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input id="email" class="form-control border-0 border-bottom rounded-0 @error('email') is-invalid @enderror"
                                   type="email" name="email" value="{{ old('email') }}"
                                   required placeholder="Email">
                            <label for="email" class="text-muted">
                                <i class="fa fa-envelope text-primary me-2"></i>Email
                            </label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="form-floating mb-3">
                            <input id="telephone" class="form-control border-0 border-bottom rounded-0 @error('telephone') is-invalid @enderror"
                                   type="text" name="telephone" value="{{ old('telephone') }}"
                                   required placeholder="Téléphone">
                            <label for="telephone" class="text-muted">
                                <i class="fa fa-phone text-primary me-2"></i>Téléphone
                            </label>
                            @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Mot de passe -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="password" class="form-control border-0 border-bottom rounded-0 @error('password') is-invalid @enderror"
                                           type="password" name="password"
                                           required placeholder="Mot de passe">
                                    <label for="password" class="text-muted">
                                        <i class="fa fa-lock text-primary me-2"></i>Mot de passe
                                    </label>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="password_confirmation" class="form-control border-0 border-bottom rounded-0"
                                           type="password" name="password_confirmation"
                                           required placeholder="Confirmation">
                                    <label for="password_confirmation" class="text-muted">
                                        <i class="fa fa-check-circle text-primary me-2"></i>Confirmation
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                                <i class="fa fa-arrow-left me-1"></i> Déjà inscrit ?
                            </a>
                            <button type="submit" class="btn btn-primary py-2 px-4 rounded-pill fw-bold">
                                <i class="fa fa-user-plus me-2"></i>S'inscrire
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-3 text-muted">
                    <small>&copy; 2025 DASHMIN - Tous droits réservés</small>
                </div>
            </div>
        </div>
    </div>
@endsection
