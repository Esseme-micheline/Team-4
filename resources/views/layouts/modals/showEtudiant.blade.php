{{-- Modification du Etudiant --}}
<div class="modal fade" id="showEtudiantsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Information Personnelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">matricule</label>
                        <input type="text" readonly class="form-control" id="matricule"
                            placeholder="SVP Entrez le matricule de l'Etudiant">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Nom</label>
                        <input type="text" readonly class="form-control" id="noms"
                            placeholder="SVP entrez le nom de l'Etudiant">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Telephone</label>
                        <input type="number" class="form-control" id="telephone" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Email </label>
                        <input type="email" class="form-control" id="email" readonly>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>
