{{-- Modification d'un groupe de TD --}}
<div class="modal fade" id="editGroupeTDModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'un Groupe de TD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editGroupeTDForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">intitule</label>
                        <input type="text" class="form-control" name="intitule" required id="intitule" placeholder="SVP entrez l'intitule du groupe">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">periode</label>
                        <input type="text" class="form-control" name="periode" required id="periode" >
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">capacite</label>
                        <input type="number" class="form-control" name="capacite" required id="capacite" >
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">salle</label>
                        <input type="text" class="form-control" name="salle" required id="salle" >
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
