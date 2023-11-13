@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Niveaux</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Niveaux</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 35px">Gestions des Niveaux</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">

                @if ($niveaux->count() > 0)
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('Admin.niveau.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un nouveau niveau</a></div>
                            <div class="search-bars col-md-10">
                                <form class="search-forms d-flex align-items-center" method="GET" action="#"
                                    class="row">
                                    @csrf
                                    <input type="text" name="search" id="search" placeholder="Recherche d'un niveau"
                                        onkeyup="fetchNiveau(document.getElementById('search').value)"
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
                                @foreach ($niveaux as $niveau)
                                    <tr id="sid{{ $niveau->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $niveau->code }}</td>
                                        <td>{{ $niveau->intitule }}</td>
                                        <td><a href="{{ route('Admin.indexNiv', $niveau->id) }}" class="btn btn-success"><i
                                                    class="fa fa-plus-circle" aria-hidden="true"></i> Voir plus</a>
                                            <a href="javascript:void(0)" onclick="editNiveau({{ $niveau->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit"
                                                    aria-hidden="true"></i>Update</a>
                                            <a onclick="return confirm('Voulez vous supprimer se niveaux avec tout sont contenu?')"
                                                href="{{ route('Admin.niveau.delete', $niveau->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $niveaux->links() }}
                        </div>
                        <!-- End Dark Table -->

                    </div>
                @else
                    <div class="col-12"><a href="{{ route('Admin.niveau.create') }}"> <i class="fa fa-plus"
                                aria-hidden="true"></i> Ajouter un nouveau niveau</a></div>
                    <div>Vous n'avez pas encore ajouter de niveau</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionNiveau')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionNiveau.js') }}"></script>
@endsection
