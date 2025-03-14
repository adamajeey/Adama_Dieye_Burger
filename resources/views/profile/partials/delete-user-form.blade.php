<!-- resources/views/profile/partials/delete-user-form.blade.php -->
<section>
    <div class="alert alert-danger mb-4">
        <h6 class="fw-bold mb-2">Êtes-vous sûr de vouloir supprimer votre compte ?</h6>
        <p class="mb-0">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
            Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
        </p>
    </div>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <i class="fa fa-trash-alt me-2"></i>Supprimer le compte
    </button>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-3">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">Êtes-vous sûr ?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Cette action est irréversible. Veuillez confirmer en saisissant votre mot de passe.</p>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" name="password" type="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="Mot de passe" required>
                            @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash-alt me-2"></i>Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
