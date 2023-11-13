@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Liste de Demande d'Inscription</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Inscription</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Liste de Demande
                        D'Inscription</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br><br>
                    <div class="row ">
                        <div class="col-md-7 ">
                            <form action="{{ route('Ecole_Doctorat.Inscription.show') }}" method="get"
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
                                </div>

                                <div class="col-6">
                                    <button type="submit" class="btn text-light"
                                        style="background: #012970;">Filtrer</button>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="search-barss col-md-5">
                            @if ($inscriptions->count() > 0)
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
                    </div>
                    @if ($inscriptions->count() > 0)
                        <br>



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
                                    <th scope="col">Année</th>
                                    <th scope="col">Validation</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($inscriptions as $inscription)
                                    <tr id="sid{{ $inscription->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td >{{ $inscription->etudiant['noms'] }}
                                        </td>
                                        <td>{{ $inscription->etudiant['matricule'] }}</td>
                                        <td>{{ $inscription->unite_recherche['code'] }}</td>
                                        <td class=" text-break" style="width:15rem">{{ $inscription->niveau->code }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-eye"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item">{{ $inscription->theme_recherche }}
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
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('Ecole_Doctorat.jury.voir', $inscription->encadreur->id) }}">{{ $inscription->encadreur['noms'] }}</a>
                                                    </li>
                                                    @if ($inscription->coEncadreur != null)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Ecole_Doctorat.jury.voir', $inscription->coEncadreur->id) }}">{{ $inscription->coEncadreur['noms'] }}</a>
                                                        </li>
                                                    @endif
                                                    @if ($inscription->cooEncadreur != null)
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Ecole_Doctorat.jury.voir', $inscription->cooEncadreur->id) }}">{{ $inscription->cooEncadreur['noms'] }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td class=" text-break" style="width:15rem">{{ $inscription->annee['libelle'] }}
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Voulez vous enregistre se dossier ?')"
                                                href="{{ route('Ecole_Doctorat.Inscription.update', $inscription->id) }}"><i
                                                    class="fa fa-check text-success" aria-hidden="true"></i></a>&ensp;
                                            &ensp;
                                            <a onclick="return confirm('Voulez vous supprimer se dossier?')"
                                                href="{{ route('Ecole_Doctorat.Inscription.delete', $inscription->id) }}"><i
                                                    class="fa-solid fa-circle-xmark text-danger"></i> </a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $inscriptions->links() }}
                        </div>
                        <!-- End Dark Table -->
                    @else
                        <div>Pas d'inscription pour le moment</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
{{-- @section('modals')
    @include('layouts.modals.jury')
@endsection
@section('scripts')
    <script src="{{ asset('js/ecoleDoctorat/jury.js') }}">
    </script>
@endsection --}}
