{{-- Modification du departement --}}
<div class="modal fade" id="editNewsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de modification d'un Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('Ecole_Doctorat.message.store') }}" method="post" id="editNewForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Titre</label>
                        <input type="text" class="form-control" required name="titre" id="titre"
                            placeholder="Entrez le titre">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Contenu</label>
                        <textarea required name="contenu" id="contenu" class="form-control" rows="5"></textarea>
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
