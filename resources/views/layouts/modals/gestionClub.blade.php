{{-- Modification du departement --}}
<div class="modal fade" id="editClubModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'un Club</h5>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editClubForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">code</label>
                        <input type="text" class="form-control" required name="code" id="code"
                            placeholder="SVP Entrez le code du club">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">intitule</label>
                        <input type="text" class="form-control" name="intitule" required id="intitule" placeholder="SVP entrez l'intitule du Club">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
