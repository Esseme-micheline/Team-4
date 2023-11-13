<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Connexion</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/customClass.css') }}">
    <!-- Template Main CSS File -->
    <link href="/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

</head>

<body>

    <main>

        <div class="container-fluid bg-light d-flex justify-content-center border-bottom shadow w-100" style="">
            <nav class="navbar navbar-expand-lg">
                <div class="navbar navbar-brand d-block d-md-flex">
                    <img src="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}" style="height:auto;width:70px"
                        class="mx-auto d-block">&ensp;
                    <div class="text-center">
                        <span class="text-black fs-4">Université de Yaoundé I</span><br>
                        <span class="fs-5">Faculté des sciences</span>
                    </div>
                </div><br>
            </nav>
        </div>

        {{-- <div class=""> --}}
        <div class="container-fluid">
            {{-- <div class=""> --}}
            <div class="d-lg-inline-flex justify-content-evenly mt-5 w-100">

                <!-- MENU ECOLE DOCTORAT -->
                <div class="col-lg-3 d-flex justify-content-center">


                </div>

                <!-- CONNEXION ETUDIANT -->
                <div class="col-lg-5 d-flex justify-content-center">

                    <div class="card mb-3 alert alert-secondary alert-dismissible fade show">

                        <div class="card-body ">
                            <div>
                                @if ($errors->has('username'))
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                @endif

                            </div>
                            @if (isset($ajout_nouv))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ $ajout_nouv }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Svp Remplissez se formulaire pour termine
                                    votre inscription</h5>
                                <p class="text-center small">Entrer votre matricule ou Numero de telephone & mot de
                                    passe pour s'inscrire</p>
                            </div>

                            <form method="post" class="row g-3 needs-validation"
                                action="{{ route('Inscription.RegistrationTD', $id) }}" novalidate>
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $id }}">
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Matricule ou Telephone</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-user"
                                                aria-hidden="true"></i></span>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            id="yourUsername" value="{{ old('username') }}" required>
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
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="yourPassword" value="{{ old('password') }}" required>
                                        <div class="invalid-feedback">Veuillez renseigner votre mot de passe
                                        </div>
                                    </div>

                                </div>
                                @if ($errors->has('mdp'))
                                    @foreach ($errors->all() as $error)
                                        <p class="alert alert-danger">{{ $error }}</p>
                                    @endforeach
                                @endif


                                <div class="col-12 text-center">
                                    <button class="btn btn-primary w-50" type="submit"> <i class="fa fa-sign-in"
                                            aria-hidden="true"></i> S'inscrire</button>
                                </div>
                            </form>


                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                Vous n'avez pas de Matricule ? cliquez <a
                                    href="{{ route('Inscription.form.createForm', $id) }}">ici</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- COMMUNIQUES -->
                <div class="col-lg-3 d-flex justify-content-center">


                </div>

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        var needsValidation = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(needsValidation)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    </script>

</body>

</html>
