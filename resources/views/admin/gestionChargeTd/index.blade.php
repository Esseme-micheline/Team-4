@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion Charge De TD</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Charge de Td</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Charges de TD
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($ChargeTds->count() > 0)
                        <br>
                        <div class="row">
                            <div class="col-md-4"><a href="{{ route('Admin.ChargeTd.create') }}"> <i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un nouveau Charge de TD</a></div>
                            <div class="search-bars col-md-10">
                                <form class="search-forms d-flex align-items-center" method="GET" action="#"
                                    class="row">
                                    @csrf
                                    <input type="text" name="search" id="search"
                                        placeholder="Recherche d'un charge de Td"
                                        onkeyup="fetchChargeTd(document.getElementById('search').value)"
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($ChargeTds as $ChargeTd)
                                    <tr id="sid{{ $ChargeTd->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:15rem">{{ $ChargeTd->noms }}</td>
                                        <td>{{ $ChargeTd->telephone }}</td>
                                        <td>
                                            {{-- <a href="{{ route('Admin.indexDept', $ChargeTd->id) }}"
                                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Voir plus</a> --}}
                                            <a onclick="return confirm('Voulez vous supprimer cet ChargeTd et avec tout sont contenu?')"
                                                href="{{ route('Admin.ChargeTd.delete', $ChargeTd->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $ChargeTds->links() }}
                        </div>
                        <!-- End Dark Table -->
                    @else
                        <br>
                        <div class="col-12"><a href="{{ route('Admin.ChargeTd.create') }}"> <i class="fa fa-plus"
                                    aria-hidden="true"></i> Ajouter un nouveau Charge de Td</a></div>
                        <div>Vous n'avez pas encore ajouter de Charge de Td</div>
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
