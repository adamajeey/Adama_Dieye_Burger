@extends('layouts.master')

@section('contenu')
    <div class="container-fluid pt-4 px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-light rounded d-flex justify-content-between align-items-center p-4">
                    <h3 class="mb-0">Mon Profil</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Informations du profil -->
            <div class="col-12 col-xl-6">
                <div class="bg-white rounded shadow-sm h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fa fa-user-edit me-2 text-primary"></i>Informations du profil</h5>
                    </div>

                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Mise à jour du mot de passe -->
            <div class="col-12 col-xl-6">
                <div class="bg-white rounded shadow-sm h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fa fa-lock me-2 text-primary"></i>Mise à jour du mot de passe</h5>
                    </div>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Suppression du compte -->
            <div class="col-12">
                <div class="bg-white rounded shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 text-danger"><i class="fa fa-trash-alt me-2"></i>Supprimer mon compte</h5>
                    </div>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
