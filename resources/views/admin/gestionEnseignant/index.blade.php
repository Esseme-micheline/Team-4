@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion Enseignant</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Enseignant</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Enseignant</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($enseignants != null)
                        @if ($enseignants->count() > 0)
                            <br>
                            <div class="row">
                                <div class="col-md-4"><a href="{{ route('Admin.enseignant.create') }}"> <i
                                            class="fa fa-plus" aria-hidden="true"></i> Ajouter un nouveau Enseignant</a>
                                </div>
                                <div class="search-bars col-md-10">
                                    <form class="search-forms d-flex align-items-center" method="GET" action="#"
                                        class="row">
                                        @csrf
                                        <input type="text" name="search" id="search"
                                            placeholder="Recherche d'un Enseignant"
                                            onkeyup="fetchEnseignant(document.getElementById('search').value)"
                                            title="Enter search keyword">
                                        <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                    </form>
                                </div>
                            </div>



                            <br>

                            <!-- Dark Table -->
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">telephone</th>
                                        <th scope="col">Nombre de UE</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($enseignants as $enseignant)
                                        <tr id="sid{{ $enseignant->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td class=" text-break" style="width:15rem">{{ $enseignant->noms }}</td>
                                            <td class=" text-break"
                                                style="width:7                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      rem">
                                                {{ $enseignant->telephone }}</td>
                                            <td>{{ $enseignant->attributions->count() }}</td>
                                            <td>
                                                <a href="{{ route('Admin.enseignant.voir', $enseignant->id) }}"
                                                    class="btn btn-warning"><i
                                                        class="fa-solid fa-person-circle-plus"></i>Voir
                                                    plus</a>&ensp;
                                                <a href="{{ route('Admin.attribution.create', $enseignant->id) }}"
                                                    class="btn btn-success"><i class="fa fa-plus-circle"
                                                        aria-hidden="true"></i>
                                                    Attribuer</a>&ensp;
                                                @if (Auth::user()->profil_id == 0)
                                                    <a onclick="return confirm('Voulez vous supprimer cet enseignant et avec tout sont contenu?')"
                                                        href="{{ route('Admin.enseignant.delete', $enseignant->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></i>Delete</a>
                                                @endif
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-center">
                                {{ $enseignants->links() }}
                            </div>
                            <!-- End Dark Table -->
                        @else
                            <div class="col-12"><a href="{{ route('Admin.enseignant.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un nouveau enseignant</a></div>
                            <div>Vous n'avez pas encore ajouter d'Enseignant</div>
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
    {{-- @include('layouts.modals.gestionDepartement') --}}
@endsection
@section('scripts')
    {{-- <script src="{{ asset('js/admin/gestionDepartement.js') }}">
    </script> --}}
@endsection
