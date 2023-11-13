{{-- Modification d'un groupe de Td --}}
<div class="modal fade" id="editTdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-capitalize text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'un td</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editTdForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">code</label>
                        <input type="text" class="form-control" required name="code" id="code"
                            placeholder="SVP Entrez le code du group de td">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">intitule</label>
                        <input type="text" class="form-control" name="intitule" required id="intitule" placeholder="SVP entrez l'intitule du groupe de td">
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
{{-- Modification d'un groupe de Td --}}
<div class="modal fade" id="editdSpecialModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-capitalize text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'un groupe de td Special</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editTdSpecialeForm">
                    @csrf
                    <input type="hidden" name="idT" id="idT">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">code</label>
                        <input type="text" class="form-control" required name="codeT" id="codeT"
                            placeholder="SVP Entrez le code du groupe Td Special">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">intitule</label>
                        <input type="text" class="form-control" name="intituleT" required id="intituleT" placeholder="SVP entrez l'intitule du groupe de Td Special">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">prix</label>
                        <input type="number" class="form-control" name="prix" required id="prix" placeholder="SVP entrez le prix du groupe de TD">
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

