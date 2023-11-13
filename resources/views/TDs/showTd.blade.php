<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travaux pratique</title>
    <link href="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>

<body id="body">
    <!-- ======= Header ======= -->
    <header id="header" class="header h-25 fixed-top text-center d-flex align-items-center">
        <h1 class="text-center w-100 container text_universite"><span class="univ_text">Université de Youndé
                I</span>&ensp; <img class="univ_logo" src="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}"
                alt="logo de l'UY1" width="60" srcset="">&ensp; <span class="faculte_text">Faculté de
                Sciences</span></h1>
    </header>
    <main id="mains" class="main">
        <section class="section container">
            <h1 class="text-center text-danger">Inscriptions en ligne aux Travaux Pratiques(ou Dirigés) de
                {{ $ue->code }} - {{ $ue->intitule }}</h1>
            <hr>
            <h4 class="text-center text-info">Filiere {{ $ue->filiere->intitule }} Uniquement</h4>
            <hr>
            @if (isset($inscription_reussi))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $inscription_reussi }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
            @endif
            @if (isset($inscription_deja))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ $inscription_deja }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
            @endif
            @if (isset($inscription_plein))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ $inscription_plein }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
            @endif
            @if (isset($inscription_erreur))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $inscription_erreur }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
            @endif
            @if ($errors->has('mdp'))
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                <hr>
            @endif
            @if (isset($ajout_nouv))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $ajout_nouv }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <hr>
            @endif
            <div class="card">
                <div class="card-body">
                    <dl>
                        <dt>Pour vous inscrire à un groupe :</dt>
                        <dd>
                            <ol>
                                <li>Choisissez votre groupe s'il ya encore des places disponibles en cliquant sur le
                                    lien
                                    disponible.</li>
                                <li>Confirmez vos informations personnelles et votre inscriptions au groupe en cliquant
                                    sur
                                    le bouton prévu à cet effet.</li>
                                <li>En cas de difficulté, rapprochez-vous de votre enseignant!
                                </li>
                            </ol>
                        </dd>
                    </dl>
                </div>
            </div>
            <hr>
            <h4 class="text-center">N.B. : Les salles, groupes, dates et heures de passage sont à respecter
                scrupuleusement!!! </h4>
            <hr>
            <div class="card">
                <div class="card-body">
                    {{-- Ci-dessous, la liste des unités d'enseignements: --}}
                    @if ($groupeTds->count() == 0)
                        <br>
                        <div>Aucun TD n'a encore été programmée pour cette UE</div>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Salle</th>
                                    <th scope="col">Periode</th>
                                    <th scope="col">Nombre total de places</th>
                                    <th scope="col">Nombres de places encore disponibles</th>
                                    <th scope="col">/</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupeTds as $groupeTd)
                                    <tr>
                                        <th scope="row">{{ $groupeTd->salle }}</th>
                                        <td>{{ $groupeTd->periode }}</td>
                                        <td>{{ $groupeTd->capacite }}</td>
                                        <td>{{ $groupeTd->capacite - $etudiant_groupe_td[$groupeTd->id] }}</td>
                                        {{-- 21Q2291 --}}
                                        @if ($groupeTd->capacite - $etudiant_groupe_td[$groupeTd->id] > 0)
                                            <td><a href="javascript:void(0)"
                                                    onclick="inscriptionEtudiant({{ $groupeTd->id }})">S'inscrire</a>
                                                {{-- {{ route('Inscription.signTd', $groupeTd->id) }} --}}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>
    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Te-sea 2022</span></strong>. All Rights Reserved
        </div>
    </footer>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/Tds/affiche_ue.js') }}"></script>
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
    <script>
        function inscriptionEtudiant(id) {
            document.getElementById('id').value = id;
            $('#InscriptionEtudiantModal').modal('toggle');
        }
    </script>
    @include('TDs.modalLogin')
</body>

</html>
