@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Etudiants</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Etudiants</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Etudiants</h1>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br>
                    @if ($etudiants != null)
                        <div class="col-12 text-center p-3 d-flex justify-content-center"><a
                                href="{{ route('Admin.Etudiant.formImport') }}" class="btn btn-primary"> <i
                                    class="fa fa-download" aria-hidden="true"></i> Importer</a>&ensp;
                            @if ($etudiants->count() > 0)
                                <form action="{{ route('Admin.etudiant.formExport') }}" method="get">
                                    @if (isset($filiere_id) && isset($niveau_id))
                                        @csrf
                                        <input type="hidden" name="niveau_id" value="{{ $niveau_id }}">
                                        <input type="hidden" name="filiere_id" value="{{ $filiere_id }}">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Exporter</button>
                                    @elseif (isset($filiere_id) && !isset($niveau_id))
                                        @csrf
                                        <input type="hidden" name="filiere_id" value="{{ $filiere_id }}">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Exporter</button>
                                    @elseif (!isset($filiere_id) && isset($niveau_id))
                                        @csrf
                                        <input type="hidden" name="niveau_id" value="{{ $niveau_id }}">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Exporter</button>
                                    @else
                                        @csrf
                                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Exporter</button>
                                    @endif
                                </form>
                            @endif
                        </div>
                        <div class="col-12"><a href="{{ route('Admin.etudiant.create') }}"> <i class="fa fa-plus"
                                    aria-hidden="true"></i> Ajouter un nouveau Etudiant</a>
                        </div>


                        <div class="row ">
                            <div class="col-md-7 ">
                                <form action="{{ route('Admin.etudiant.show') }}" method="get"
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

                            <div class="search-barss col-md-5">
                                @if ($etudiants->count() > 0)
                                    <br>
                                    <form class="search-forms d-flex w-100 align-items-center" method="GET" action="#"
                                        class="row">
                                        @csrf
                                        <input type="text" name="search" id="search"
                                            placeholder="Recherche d'un etudiant"
                                            onkeyup="fetchEtudiant(document.getElementById('search').value)"
                                            title="Enter search keyword" class="w-100">
                                        <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                    </form>
                                @endif

                            </div>
                        </div>

                        @if (isset($ajout_nom))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $ajout_nom }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- {{ URL() }} --}}
                        {{-- <a href="{{ url()->previous() }}">her</a> --}}

                        <br>
                        @if ($etudiants->count() > 0)
                            <!-- Dark Table -->
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Noms</th>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">filiere</th>
                                        <th scope="col">Niveau</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($etudiants as $etudiant)
                                        <tr id="sid{{ $etudiant->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td>{{ $etudiant->noms }}</td>
                                            <td>{{ $etudiant->matricule }}</td>
                                            <td>{{ $etudiant->filiere->code }}</td>
                                            <td>{{ $etudiant->niveau->code }}&ensp; &ensp; <a href="javascript:void(0)" onclick="editNiveauEtudiant({{ $etudiant->id }})"><i class="fa-solid fa-plus-minus text-danger fs-6"></i></a></td>
                                            <td><a onclick="return confirm('Voulez vous reinitialiser le mot de passe de cet etudiant ?')"
                                                    href="{{ route('Admin.etudiant.reset', $etudiant->id) }}"
                                                    class="btn btn-warning"><i class="fa-solid fa-repeat"></i>
                                                     </a>&ensp;&ensp;
                                                <a href="javascript:void(0)" onclick="editEtudiant({{ $etudiant->id }})"
                                                    class="btn btn-danger"><i class="fa fa-edit"
                                                        aria-hidden="true"></i></a>&ensp;&ensp;&ensp;
                                                <a onclick="return confirm('Voulez vous supprimer cet etudiant et avec tout sont contenu?')"
                                                    href="{{ route('Admin.etudiant.delete', $etudiant->id) }}"
                                                    class="btn btn-secondary"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></i></a>
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-center" id="pagination">
                                    {{ $etudiants->links() }}
                                    {{-- {{ url()->full() }} --}}
                            </div>
                        @else
                            <div>Vous n'avez pas encore ajouter d'etudiant

                            </div>
                        @endif
                    @else
                        <div>R.A.S</div>
                    @endif

                </div>


            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionEtudiant')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionEtudiant.js') }}"></script>
@endsection
