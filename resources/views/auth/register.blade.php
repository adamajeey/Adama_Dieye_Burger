@extends('layouts.master')
@section('contenu')
    <section class="h-100 h-custom" style="background-color: #f8f9fa;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10 col-xl-8">
                    <div class="card rounded-3 shadow-lg">
                        <div class="row g-0">
                            <div class="col-md-6 d-none d-md-block">
                                <img src="{{asset('build/assets/images/bg.jpg')}}" class="img-fluid rounded-start h-100 w-100" alt="Burger Image" style="object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body p-4">
                                    <h3 class="mb-4 text-center">Inscription</h3>
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input id="prenom" class="form-control" type="text" name="prenom" value="{{ old('prenom') }}" required autofocus>
                                                @error('prenom') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input id="nom" class="form-control" type="text" name="nom" value="{{ old('nom') }}" required>
                                                @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Téléphone</label>
                                            <input id="telephone" class="form-control" type="text" name="telephone" value="{{ old('telephone') }}" required>
                                            @error('telephone') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="password" class="form-label">Mot de passe</label>
                                                <input id="password" class="form-control" type="password" name="password" required>
                                                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="password_confirmation" class="form-label">Confirmation</label>
                                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                                                @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <a href="{{ route('login') }}" class="text-muted">Déjà inscrit ?</a>
                                            <button type="submit" class="btn btn-primary">S'inscrire</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
