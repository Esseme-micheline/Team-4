{{-- Modification du Etudiant --}}
<div class="modal fade" id="editJuryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger bg-danger">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Formulaire de
                    Modification d'un Jury</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="editJuryForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="noms" required id="noms"
                            placeholder="SVP entrez le nom de l'Etudiant">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Email </label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Grade</label>
                        <select name="grade" id="grade" class="form-select @error('grade') is-invalid  @enderror"
                            value="{{ old('grade') }}">
                            <option value="">Selectionner un champs</option>
                            <option value="Assistant">Assistant</option>
                            <option value="charge de cours">Charge de Cours</option>
                            <option value="Maitre de Conference">Maitre de Conference</option>
                            <option value="Professeur">Professeur</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Telephone</label>
                        <input type="number" class="form-control" maxlength="9" name="telephone" id="telephone">
                    </div>
                    <div class="mb-3">
                        <label for="textereadescription" class="form-label">Universite </label>
                        <select name="universite" id="universite"
                            class="form-select @error('universite') is-invalid  @enderror">
                            <option value="">selectionner un champs</option>
                            <option value="UY1">Universite de Yaounde I</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="textereadescription" class="form-label"> Faculte</label>
                        <select name="faculte" id="faculte"
                            class="form-select @error('faculte') is-invalid  @enderror">
                            <option value="">selectionner un champs</option>
                            <option value="FACSCIENCE">Faculte de Science</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="textereadescription" class="form-label">Departement </label>
                        <select name="departement" id="departement"
                            class="form-select @error('departement') is-invalid  @enderror">
                            <option value="">Selectionner un champs</option>
                            @foreach ($departements as $departement)
                                <option value="{{ $departement->code }}">{{ $departement->intitule }}</option>
                            @endforeach
                        </select>
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
