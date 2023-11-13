@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Unite de Recherches</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Unite de Recherche</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 35px">Gestions des Unite de Recherche</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">

                @if ($unite_recherches->count() > 0)
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('Ecole_Doctorat.unite_recherche.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter une nouvelle Unite de Recherche</a></div>
                            <div class="search-bars col-md-10">
                                {{-- <form class="search-forms d-flex align-items-center" method="POST" action="#"
                                    class="row">
                                    @csrf
                                    <input type="text" name="search" id="search" placeholder="Recherche d'un niveau"
                                        onkeyup="fetchNiveau(document.getElementById('search').value)"
                                        title="Enter search keyword">
                                    <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                </form> --}}
                            </div>
                        </div>



                        <br>

                        <!-- Dark Table -->
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">intitule</th>
                                    <th scope="col">Nombre Dossier</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($unite_recherches as $unite_recherche)
                                    <tr id="sid{{ $unite_recherche->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $unite_recherche->code }}</td>
                                        <td>{{ $unite_recherche->intitule }}</td>
                                        <td>{{ $unite_recherche->dossiers->count() }}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="editUniteRecherche({{ $unite_recherche->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit"
                                                    aria-hidden="true"></i> Modifier</a>
                                            <a onclick="return confirm('Voulez vous supprimer cet unite de recherche avec tout sont contenu?')"
                                                href="{{ route('Ecole_Doctorat.unite_recherche.delete', $unite_recherche->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i> Supprimer</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="paNiveaugination justify-content-center">
                            {{ $unite_recherches->links() }}
                        </div>
                        <!-- End Dark Table -->

                    </div>
                @else
                    <div class="col-12"><a href="{{ route('Ecole_Doctorat.unite_recherche.create') }}"> <i class="fa fa-plus"
                                aria-hidden="true"></i> Ajouter une nouvelle unite de Recherche</a></div>
                    <div>Vous n'avez pas encore ajouter d'unite de recherche</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.uniteRecherche')
@endsection
@section('scripts')
    <script src="{{ asset('js/ecoleDoctorat/uniteRecherche.js') }}"></script>
@endsection
