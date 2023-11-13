@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Liste de Dossiers</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Dossier</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Liste de Dossiers</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br><br>
                    <div class="row ">
                        <div class="col-md-7 ">
                            <form action="{{ route('Ecole_Doctorat.dossier.show') }}" method="get"
                                class="row d-flex align-items-center">
                                @csrf
                                <div class="col-6 row ">
                                    <div class="col-12">
                                        <label for="" class="form-label">Filiere:</label>
                                        <select name="filiere_id" id="" class="form-select">
                                            <option value="">Selectionner un champ</option>
                                            @if (isset($filiere_id))
                                                @foreach ($filieres as $filiere)
                                                    @if ($filiere->id == $filiere_id)
                                                        <option value="{{ $filiere->id }}" selected>
                                                            {{ $filiere->intitule }}</option>
                                                    @else
                                                        <option value="{{ $filiere->id }}">{{ $filiere->intitule }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($filieres as $filiere)
                                                    <option value="{{ $filiere->id }}">{{ $filiere->intitule }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Niveau :</label>
                                        <select name="niveau_id" id="" class="form-select">
                                            <option value="">Selectionner Un champs</option>
                                            @if (isset($niveau_id))
                                                @foreach ($niveaux as $niveau)
                                                    @if ($niveau->id == $niveau_id)
                                                        <option value="{{ $niveau->id }}" selected>
                                                            {{ $niveau->intitule }}</option>
                                                    @else
                                                        <option value="{{ $niveau->id }}">
                                                            {{ $niveau->intitule }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($niveaux as $niveau)
                                                    <option value="{{ $niveau->id }}">{{ $niveau->intitule }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="form-label">Etat:</label>
                                        <select name="status" id="" class="form-select">
                                            <option value="">Selectionner Un champs</option>
                                            @if (isset($status))
                                                @if ($status == 1)
                                                    <option value="1" selected>
                                                        Inscription</option>
                                                    <option value="2">Changement</option>
                                                    <option value="3">Authorisation</option>
                                                    <option value="4">Classement</option>
                                                @elseif($status == 2)
                                                    <option value="1">Inscription</option>
                                                    <option value="2" selected>
                                                        Changement
                                                    </option>
                                                    <option value="3">Authorisation</option>
                                                    <option value="4">Classement</option>
                                                @elseif($status == 3)
                                                    <option value="1">Inscription</option>
                                                    <option value="2">Changement</option>
                                                    <option value="3" selected>Authorisation</option>
                                                    <option value="4">Classement</option>
                                                @else
                                                    <option value="1">Inscription</option>
                                                    <option value="2">Changement</option>
                                                    <option value="3">Authorisation</option>
                                                    <option value="4" selected>Classement</option>
                                                @endif
                                            @else
                                                <option value="1">Inscription</option>
                                                <option value="2">Changement</option>
                                                <option value="3">Authorisation</option>
                                                <option value="4">Classement</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <button type="submit" class="btn text-light"
                                        style="background: #012970;">Filtrer</button>
                                </div>
                            </form>
                        </div>

                        <div class="search-barss col-md-5 row">
                            <br>
                            {{-- <div class="col-12">
                                @if ($dossiers->count() > 0)
                                    <form class="search-forms d-flex w-100 align-items-center" method="POST" action="#"
                                        class="row">
                                        @csrf
                                        <input type="text" name="search" id="search"
                                            placeholder="Recherche d'un etudiant"
                                            onkeyup="fetchEtudiant(document.getElementById('search').value)"
                                            title="Enter search keyword" class="w-100">
                                        <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                    </form>
                                @endif
                            </div> --}}
                            <div class="col-12">
                                <button type="button" class="btn btn-info text-light" data-bs-toggle="modal"
                                    data-bs-target="#formNewsModal"> News</button>
                            </div>

                        </div>
                    </div>
                    @if ($dossiers->count() > 0)
                        <br>

                        @if (isset($email_valide))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $email_valide }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (isset($echec_email_pr) || isset($echec_email_en) || isset($echec_email_ex))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @if ($echec_email_pr !=null)
                                {{ $echec_email_pr }} <br>
                                @endif
                                @if ($echec_email_en !=null)
                                {{ $echec_email_en }} <br>
                                @endif
                                 {{ $echec_email_ex }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <br>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Noms & Prenom</th>
                                    <th scope="col">Matricule</th>
                                    <th scope="col">Unite de Recherche</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Theme</th>
                                    <th scope="col">Encadreur</th>
                                    <th scope="col">Jury</th>
                                    <th scope="col">Etat</th>
                                    <th scope="col">Année</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($dossiers as $dossier)
                                    <tr id="sid{{ $dossier->id }}"
                                        @if ($dossier->status == 1) class="text-secondary"
                                    @elseif ($dossier->status == 2)
                                        class="text-danger"
                                    @elseif ($dossier->status == 3)
                                        class="text-warning"
                                    @elseif ($dossier->status == 4)
                                        class="text-dark"
                                    @elseif($dossier->status == 5)
                                            class="text-primary"
                                    @elseif($dossier->status == 6)
                                            class="text-dark"
                                    @elseif($dossier->status == 7)
                                        class="text-dark"
                                    @elseif($dossier->status == 8)
                                        class="text-success"
                                    @else @endif>
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $dossier->etudiant['noms'] }}</td>
                                        <td>{{ $dossier->etudiant['matricule'] }}</td>
                                        <td>{{ $dossier->unite_recherche['code'] }}</td>
                                        <td class=" text-break" style="width:15rem">{{ $dossier->niveau->code }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-eye"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item">{{ $dossier->theme_recherche }} &ensp; <a
                                                            href="javascript:void(0)"
                                                            onclick="editTheme({{ $dossier->id }})"> <i
                                                                class="fa fa-edit text-danger" aria-hidden="true"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa-solid fa-users"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><span id="encadreur{{ $dossier->id }}"><a class="dropdown-item"
                                                                href="{{ route('Ecole_Doctorat.jury.voir', $dossier->encadreur->id) }}">{{ $dossier->encadreur['noms'] }}</a></span>
                                                        &ensp;
                                                        &ensp; <a href="javascript:void(0)"
                                                            onclick="ajoutJuryPre({{ $dossier->id }}, 'encadreur')"> <i
                                                                class="fa fa-edit text-danger" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                    @if ($dossier->coEncadreur != null)
                                                        <li><span id="coencadreur{{ $dossier->id }}"><a
                                                                    class="dropdown-item"
                                                                    href="{{ route('Ecole_Doctorat.jury.voir', $dossier->coEncadreur->id) }}">{{ $dossier->coEncadreur['noms'] }}</a></span>&ensp;
                                                            &ensp;<a href="javascript:void(0)"
                                                                onclick="ajoutJuryPre({{ $dossier->id }}, 'coencadreur')">
                                                                <i class="fa fa-edit text-danger" aria-hidden="true"></i>
                                                            </a> &ensp; &ensp; <a
                                                                onclick="return confirm('Voulez vous supprimer se co-Encadreur?')"
                                                                href="/Ecole_Doctorat/Dossier/delete/{{ $dossier->id }}/coencadreur"><i
                                                                    class="fa fa-trash text-secondary"
                                                                    aria-hidden="true"></i></a>
                                                        </li>
                                                    @else
                                                        <li><span id="coencadreur{{ $dossier->id }}"> <a
                                                                    class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="ajoutJuryPre({{ $dossier->id }}, 'coencadreur')">Ajouter
                                                                    un co-Encadreur</a></span>
                                                        </li>
                                                    @endif

                                                    @if ($dossier->cooEncadreur != null)
                                                        <li id="cooencadreur{{ $dossier->id }}"><a class="dropdown-item"
                                                                href="{{ route('Ecole_Doctorat.jury.voir', $dossier->cooEncadreur->id) }}">{{ $dossier->cooEncadreur['noms'] }}</a>
                                                            &ensp; &ensp;
                                                            <a href="javascript:void(0)"
                                                                onclick="ajoutJuryPre({{ $dossier->id }}, 'cooencadreur')">
                                                                @if ($dossier->status == 1)
                                        <td> Inscription</td>
                                    @elseif ($dossier->status == 2)
                                        <td>Changement</td>
                                    @elseif ($dossier->status == 3)
                                        <td>Authorisation</td>
                                    @elseif ($dossier->status == 4)
                                        @if ($dossier->examinateur_jury == null && $dossier->president_jury == null)
                                            <td>Authorisation</td>
                                        @else
                                            <td>Authorisation</td>
                                        @endif
                                    @elseif($dossier->status == 5)
                                        <td>Authorisation</td>
                                    @elseif($dossier->status == 6)
                                        <td>Authorisation</td>
                                    @elseif($dossier->status == 7)
                                        <td>Authorisation</td>
                                    @elseif($dossier->status == 8)
                                        <td>Classement</td>
                                    @else
                                        <td>-</td>
                                @endif <i class="fa fa-edit text-danger" aria-hidden="true"></i>
                                </a>&ensp;&ensp;<a onclick="return confirm('Voulez vous supprimer se coo-Encadreur?')"
                                    href="/Ecole_Doctorat/Dossier/delete/{{ $dossier->id }}/cooencadreur"><i
                                        class="fa fa-trash text-secondary" aria-hidden="true"></i></a>
                                </li>
                            @else
                                <li id="cooencadreur{{ $dossier->id }}"><a class="dropdown-item"
                                        href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'cooencadreur')">Ajouter
                                        un coo-Encadreur</a>
                                </li>
                    @endif
                    </ul>
                </div>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="fa-solid fa-users"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @if ($dossier->president_jury != null)
                                <li id="president_jury{{ $dossier->id }}"><a class="dropdown-item"
                                        href="{{ route('Ecole_Doctorat.jury.voir', $dossier->president_jury->id) }}">{{ $dossier->president_jury['noms'] }}</a>&ensp;
                                    &ensp;
                                    <a href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'president_jury')">
                                        <i class="fa fa-edit text-danger" aria-hidden="true"></i>
                                    </a>&ensp;&ensp;<a
                                        onclick="return confirm('Voulez vous supprimer se President du jury?')"
                                        href="/Ecole_Doctorat/Dossier/delete/{{ $dossier->id }}/president_jury"><i
                                            class="fa fa-trash text-secondary" aria-hidden="true"></i></a>
                                </li>
                            @else
                                <li id="president_jury{{ $dossier->id }}"><a class="dropdown-item"
                                        href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'president_jury')">Ajouter
                                        le president du jury</a>
                                </li>
                            @endif
                            @if ($dossier->examinateur_jury != null)
                                <li id="examinateur{{ $dossier->id }}"><a class="dropdown-item"
                                        href="{{ route('Ecole_Doctorat.jury.voir', $dossier->examinateur_jury->id) }}">{{ $dossier->examinateur_jury['noms'] }}</a>&ensp;
                                    &ensp;
                                    <a href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'examinateur')">
                                        <i class="fa fa-edit text-danger" aria-hidden="true"></i>
                                    </a>&ensp;&ensp;<a onclick="return confirm('Voulez vous supprimer cet examinateur ?')"
                                        href="/Ecole_Doctorat/Dossier/delete/{{ $dossier->id }}/examinateur"><i
                                            class="fa fa-trash text-secondary" aria-hidden="true"></i></a>
                                </li>
                            @else
                                <li id="examinateur{{ $dossier->id }}"><a class="dropdown-item"
                                        href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'examinateur')">Ajouter
                                        un Examinateur</a>
                                </li>
                            @endif
                            @if ($dossier->coexaminateur_jury != null)
                                <li id="coexaminateur{{ $dossier->id }}"><a class="dropdown-item"
                                        href="{{ route('Ecole_Doctorat.jury.voir', $dossier->coexaminateur_jury->id) }}">{{ $dossier->coexaminateur_jury['noms'] }}</a>&ensp;
                                    &ensp;
                                    <a href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'coexaminateur')">
                                        <i class="fa fa-edit text-danger" aria-hidden="true"></i>
                                    </a>&ensp;&ensp;<a
                                        onclick="return confirm('Voulez vous supprimer se co-examinateur ?')"
                                        href="/Ecole_Doctorat/Dossier/delete/{{ $dossier->id }}/coexaminateur"><i
                                            class="fa fa-trash text-secondary" aria-hidden="true"></i></a>
                                </li>
                            @else
                                <li id="coexaminateur{{ $dossier->id }}"><a class="dropdown-item"
                                        href="javascript:void(0)"
                                        onclick="ajoutJuryPre({{ $dossier->id }}, 'coexaminateur')">Ajouter
                                        un co Examinateur</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </td>
                @if ($dossier->status == 1)
                    <td> Inscription</td>
                @elseif ($dossier->status == 2)
                    <td>Changement</td>
                @elseif ($dossier->status == 3)
                    <td>Authorisation</td>
                @elseif ($dossier->status == 4)
                    @if ($dossier->examinateur_jury == null && $dossier->president_jury == null)
                        <td>Authorisation</td>
                    @else
                        <td>Authorisation</td>
                    @endif
                @elseif($dossier->status == 5)
                    <td>Authorisation</td>
                @elseif($dossier->status == 6)
                    <td>Authorisation</td>
                @elseif($dossier->status == 7)
                    <td>Authorisation</td>
                @elseif($dossier->status == 8)
                    <td>Classement</td>
                @else
                    <td>-</td>
                @endif
                <td class=" text-break" style="width:15rem">{{ $dossier->annee['libelle'] }}</td>
                <td>
                    <a href="{{ route('Ecole_Doctorat.etudiantDos.index', $dossier->id) }}"><i
                            class="fa fa-folder text-primary" aria-hidden="true"></i></a>&ensp;
                    &ensp;
                    @if ($dossier->status == 1)
                        <i class="fa-solid fa-envelope-circle-check text-secondary"></i>
                    @elseif ($dossier->status == 2)
                        <i class="fa-solid fa-envelope-circle-check text-secondary"></i>
                    @elseif ($dossier->status == 3)
                        <i class="fa-solid fa-envelope-circle-check text-secondary"></i>
                    @elseif ($dossier->status == 4)
                        @if ($dossier->examinateur_jury == null || $dossier->president_jury == null)
                            <i class="fa-solid fa-envelope-circle-check text-secondary"></i>
                        @else
                            <a onclick="return confirm('Voulez vous envoyer se dossier au membre de jury?')"
                                href="{{ route('Ecole_Doctorat.email.index', $dossier->id) }}"><i
                                    class="fa-solid fa-envelope-circle-check text-success"></i></a>
                        @endif
                    @elseif($dossier->status == 5 || $dossier->status == 6 || $dossier->status == 7)
                        <i class="fa-solid fa-envelope-circle-check text-danger"></i>
                    @elseif($dossier->status == 8)
                        <i class="fa-solid fa-envelope-circle-check text-dark"></i>
                    @elseif ($dossier->status == 9)
                        <i class="fa-solid fa-envelope-circle-check text-dark"></i>
                    @else
                        <i class="fa-solid fa-envelope-circle-check text-dark"></i>
                    @endif &ensp;
                    &ensp;
                    <i class="fa-solid fa-book-open-reader text-warning"></i>
                </td>

                </tr>
                <div style="display:none;">{{ $n += 1 }}</div>
                @endforeach
                </tbody>
                </table>
                <div class="pagination justify-content-center">
                    {{ $dossiers->links() }}
                </div>
                <!-- End Dark Table -->
            @else
                <div>Pas de dossier pour le moment</div>
                @endif
            </div>
            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.dossierjury')
    @include('layouts.modals.dossierNew')
@endsection
@section('scripts')
    <script src="{{ asset('js/ecoleDoctorat/dossier.js') }}"></script>
@endsection
