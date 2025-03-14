<!-- resources/views/profile/partials/update-password-form.blade.php -->
<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-2">
        @csrf
        @method('put')

        <!-- Mot de passe actuel -->
        <div class="mb-3">
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password"
                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nouveau mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" name="password" type="password"
                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                   autocomplete="new-password">
            @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
            @if (session('status') === 'password-updated')
                <div class="alert alert-success me-3 mb-0 py-2 px-3">
                    Enregistré.
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-key me-2"></i>Mettre à jour
            </button>
        </div>
    </form>
</section>
