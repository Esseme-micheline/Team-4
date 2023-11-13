{{-- Modification du Etudiant --}}
<div class="modal fade" id="InscriptionEtudiantModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title h3 text-lg-start text-center text-light" style=" font-weight:bolder;">Svp
                    Remplissez se formulaire pour termine
                    votre inscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center small">Entrer votre matricule ou Numero de telephone & mot de
                    passe pour s'inscrire</p>
                <form method="post" class="row g-3 needs-validation"
                    action="{{ route('Inscription.RegistrationTD', $ue->id) }}" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Matricule ou Telephone</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-user"
                                    aria-hidden="true"></i></span>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="yourUsername"
                                value="{{ old('username') }}" required>
                            <div class="invalid-feedback">Veuillez rensigner votre matricule ou Numero de
                                telephone</div>
                        </div>
                        <div style="color:red" class="invalid_feedback">
                            @if ($errors->has('matricule'))
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            @endif
                        </div>

                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-key"
                                    aria-hidden="true"></i></span>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="yourPassword"
                                value="{{ old('password') }}" required>
                            <div class="invalid-feedback">Veuillez renseigner votre mot de passe
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary" type="submit"> <i class="fa fa-sign-in" aria-hidden="true"></i>
                            S'inscrire</button>
                    </div>
                </form>
                <div class="col-12">
                    <div class="form-check">
                        Vous n'avez pas de Matricule ? cliquez <a
                            href="{{ route('Inscription.form.createForm', $ue->id) }}">ici</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
