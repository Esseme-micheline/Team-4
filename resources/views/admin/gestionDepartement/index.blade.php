@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des departements</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Departement</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des departements
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">

                @if ($departements->count() > 0)
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('Admin.departement.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un nouveau departement</a></div>
                            <div class="search-bars col-md-10">
                                <form class="search-forms d-flex align-items-center" method="GET" action="#"
                                    class="row">
                                    @csrf
                                    <input type="text" name="search" id="search"
                                        placeholder="Recherche d'un departement"
                                        onkeyup="fetchDepartement(document.getElementById('search').value)"
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
                                    <th scope="col">Code</th>
                                    <th scope="col">intitule</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($departements as $departement)
                                    <tr id="sid{{ $departement->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $departement->code }}</td>
                                        <td>{{ $departement->intitule }}</td>
                                        @if (Auth::user()->profil_id == 0)

                                        <td><a href="{{ route('Admin.indexDept', $departement->id) }}"
                                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Voir plus</a>
                                            <a href="javascript:void(0)" onclick="editDepartement({{ $departement->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit"
                                                    aria-hidden="true"></i>Update</a>
                                            <a onclick="return confirm('Voulez vous supprimer se departement et avec tout sont contenu?')"
                                                href="{{ route('Admin.departement.delete', $departement->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>
                                        @else
                                            <td>-</td>
                                        @endif

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $departements->links() }}
                        </div>
                        <!-- End Dark Table -->

                    </div>
                @else
                    <div class="col-12"><a href="{{ route('Admin.departement.create') }}"> <i class="fa fa-plus"
                                aria-hidden="true"></i> Ajouter un nouveau departement</a></div>
                    <div>Vous n'avez pas encore ajouter de departement</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionDepartement')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionDepartement.js') }}"></script>
@endsection
