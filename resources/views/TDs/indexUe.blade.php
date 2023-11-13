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
                alt="logo de l'UY1" width="60" srcset="">&ensp; <span>Faculté de Sciences</span></h1>
    </header>
    <main id="mains" class="main">
        <section class="section container">
            <h1 class="text-center text-danger">Inscriptions en ligne aux Travaux Pratiques et Travaux Dirigés</h1>
            <hr>
            <hr>

            <div class="card">
                <div class="card-body">
                    <dl>
                        <dt>Pour vous inscrire à un groupe :</dt>
                        <dd>
                            <ol>
                                <li>cliquez sur le lien correspondant à l'unité d'enseignement pour afficher le
                                    planning.
                                </li>
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
            <p>Pour consulter les groupes dans lesquels vous êtes inscris, cliquez <a href="">ici</a></p>
            <hr>
            <h4 class="text-center">N.B. : Les salles, groupes, dates et heures de passage sont à respecter
                scrupuleusement!!! </h4>
            <hr>

            <div class="card">
                <div class="card-body">
                    {{-- Ci-dessous, la liste des unités d'enseignements: --}}
                    <dl id="espace_">
                        <dt>Ci-dessous, la liste des unités d'enseignements:
                        </dt>
                        <dd>
                            <ul>
                                @foreach ($ues as $ue)
                                    @if (count($ue->tds) != 0)
                                        @foreach ($ue->tds as $td)
                                            @if (count($td->groupeTds) != 0)
                                                <li><a href="{{ route('Inscription.showTdUe', $ue->id) }}">{{ $ue->code }}
                                                        - {{ $ue->intitule }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
            <hr>
        </section>
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Te-sea 2022</span></strong>. All Rights Reserved
            </div>
        </footer>
    </main>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('js/jquery.js') }}"></script>
    {{-- <script src="{{ asset('js/Tds/affiche_ue.js') }}"></script> --}}
</body>

</html>
{{-- <li>
    <a href="javascript:void(0)"
        onclick="handleFetchingNiv({{ $filiere->id }})" >{{ $filiere->code }}&ensp;-&ensp;{{ $filiere->intitule }}</a>
    <div>
        <ul id="espace_chang{{ $filiere->id }}"></ul>
    </div>
</li>
 --}}
