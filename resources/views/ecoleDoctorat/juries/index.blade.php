@extends('layouts.admin.body')
@section('content')
@include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Liste des Jurys</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Jurys</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Liste des Jurys</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($juries->count() > 0)
                        <br>
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('Ecole_Doctorat.jury.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un nouveau jury</a></div>
                            {{-- <div class="search-bars col-md-10">
                                <form class="search-forms d-flex align-items-center" method="POST" action="#"
                                    class="row">
                                    @csrf
                                    <input type="text" name="search" id="search"
                                        placeholder="Recherche d'un jury"
                                        onkeyup="fetchjury(document.getElementById('search').value)"
                                        title="Enter search keyword">
                                    <button type="submit" title="Searchs"><i class="bi bi-search"></i></button>
                                </form>
                            </div> --}}
                        </div>



                        <br>

                        <!-- Dark Table -->
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($juries as $jury)
                                    <tr id="sid{{ $jury->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:15rem">{{ $jury->noms }}</td>
                                        <td>{{ $jury->email }}</td>
                                        <td>
                                            <a href="{{ route('Ecole_Doctorat.jury.voir', $jury->id) }}" class="btn btn-success"><i class="fa-solid fa-person-circle-plus"></i>Voir plus</a>&ensp;
                                            <a href="javascript:void(0)" onclick="editJury({{ $jury->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit" aria-hidden="true"></i> Update</a>&ensp;
                                            <a onclick="return confirm('Voulez vous supprimer se jury et avec tout sont contenu?')"
                                                href="{{ route('Ecole_Doctorat.jury.delete', $jury->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $juries->links() }}
                        </div>
                        <!-- End Dark Table -->
                    @else
                        <div class="col-12"><a href="{{ route('Ecole_Doctorat.jury.create') }}"> <i class="fa fa-plus"
                                    aria-hidden="true"></i> Ajouter un nouveau jury</a></div>
                        <div>Vous n'avez pas encore ajouter de jury</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.jury')
@endsection
@section('scripts')
    <script src="{{ asset('js/ecoleDoctorat/jury.js') }}">
    </script>
@endsection
