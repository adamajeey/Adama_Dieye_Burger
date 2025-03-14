<!-- resources/views/profile/partials/update-profile-information-form.blade.php -->
<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-2">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted mb-2">
                        Votre adresse email n'est pas vérifiée.

                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-primary">
                            Cliquez ici pour renvoyer l'email de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2">
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-end mt-4">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success me-3 mb-0 py-2 px-3">
                    Enregistré.
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-2"></i>Enregistrer
            </button>
        </div>
    </form>
</section>
