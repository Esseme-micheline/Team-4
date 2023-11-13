@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Filieres</h1>
            <nav>
                @if (isset($id))
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item "><a href="{{ route('Admin.departement.index') }}">Departement</a></li>
                        <li class="breadcrumb-item active">Filiere</li>
                    </ol>
                @else
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item active">Filiere</li>
                    </ol>
                @endif

            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des filieres
                    </h1>

                </div>
            </div>
            <div class="card">

                @if ($departements->count() > 0)
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-12">
                                @if (Auth::user()->profil_id == 0)
                                    @if (isset($id))
                                        <a href="{{ route('Admin.filiere.create', $id) }}"><i class="fa fa-plus"
                                                aria-hidden="true"></i> Ajouter une filiere</a>
                                    @else
                                        <a href="{{ route('Admin.filiere.createFil') }}"><i class="fa fa-plus"
                                                aria-hidden="true"></i> Ajouter une filiere</a>
                                    @endif
                                @elseif (Auth::user()->profil_id == 2 || Auth::user()->profil_id == 4)
                                    <a href="{{ route('Admin.filiere.create', Auth::user()->departement_id) }}"><i
                                            class="fa fa-plus" aria-hidden="true"></i> Ajouter une filiere</a>
                                @endif
                            </div>
                            @if (Auth::user()->profil_id == 0)
                                <div class="col-md-7 ">
                                    <form action="{{ route('Admin.filiere.show') }}" method="get"
                                        class="row d-flex align-items-center">
                                        @csrf
                                        <div class="col-6">

                                            <label for="departement" class="form-label">Departement:</label>
                                            <select name="departement_id" id="" class="form-select">
                                                <option value="">Selectionner un champ</option>
                                                @if (isset($id))
                                                    @foreach ($departements as $departement)
                                                        @if ($departement->id == $id)
                                                            <option value="{{ $departement->id }}" selected>
                                                                {{ $departement->intitule }}</option>
                                                        @else
                                                            <option value="{{ $departement->id }}">
                                                                {{ $departement->intitule }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($departements as $departement)
                                                        <option value="{{ $departement->id }}">
                                                            {{ $departement->intitule }}
                                                        </option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn text-light"
                                                style="background: #012970;">Filtrer</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="search-barss col-md-5">
                                    <form class="search-forms d-flex align-items-center" method="GET" action="#"
                                        class="row">
                                        @csrf
                                        <input type="text" name="search" id="search"
                                            placeholder="Recherche d'une filiere"
                                            onkeyup="fetchFiliere(document.getElementById('search').value)"
                                            title="Enter search keyword">
                                        <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>



                        <br>

                        <!-- Dark Table -->
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">intitule</th>
                                    <th scope="col">Departement</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($filieres as $filiere)
                                    <tr id="sid{{ $filiere->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $filiere->code }}</td>
                                        <td>{{ $filiere->intitule }}</td>
                                        <td>{{ $filiere->departement['code'] }}</td>
                                        <td><a href="{{ route('Admin.indexFil', $filiere->id) }}"
                                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Voir plus</a>
                                            <a href="javascript:void(0)" onclick="editFiliere({{ $filiere->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit"
                                                    aria-hidden="true"></i>Update</a>
                                            <a onclick="return confirm('Voulez vous supprimer cette filiere et avec tout sont contenu?')"
                                                href="{{ route('Admin.filiere.delete', $filiere->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $filieres->links() }}
                        </div>
                        <!-- End Dark Table -->

                    </div>
                @else
                    <div>Vous n'avez pas encore ajouter de Filiere</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionFiliere')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionFiliere.js') }}"></script>
@endsection
