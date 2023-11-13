{{-- Modification d'un groupe de TD --}}
<div class="modal fade" id="editSceanceTDModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'une Sceance de TD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editSceanceTDForm">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">intitule</label>
                        <input type="text" class="form-control" name="intitule" required id="intitule"
                            placeholder="SVP entrez l'intitule du groupe">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">description</label>
                        <textarea name="description" required class="form-control" id="description" cols="30" rows="3"></textarea>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">date</label>
                            <input type="date" class="form-control" name="date" required id="date">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="" class="form-label">Salle</label>
                                <input type="text" name="salle" required id="salle" class="form-control">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <label for="exampleFormControlTextarea1" class="form-label">heure Debut</label>
                                <input type="time" class="form-control" name="heureDebut" required id="heureDebut">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleFormControlTextarea1" class="form-label">heure Fin</label>
                                <input type="time" class="form-control" name="heureFin" required id="heureFin">
                            </div>
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
