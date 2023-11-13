@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Groupe de TDs</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">TD</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Listes des Actions d'un TD
                    </h1>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br>



                    <br>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Option</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbodys">
                            <tr>
                                <th scope="row">1</th>
                                <td>Groupe TD</td>
                                @if (isset($tdSpecial_id))
                                    <td>
                                        <a href="{{ route('Admin.GroupeTD.TDSpeciale.index', $id) }}"
                                            class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i>
                                            Afficher</a>
                                        @if (Auth::user()->profil_id != 5)
                                            <a href="{{ route('Admin.GroupeTD.TDSpeciale.create', $id) }}"
                                                class="btn btn-secondary"><i class="fa fa-plus-circle"
                                                    aria-hidden="true"></i>
                                                Ajouter</a>
                                        @endif
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ route('Admin.GroupeTD.TD.index', $id) }}" class="btn btn-primary"><i
                                                class="fa fa-list" aria-hidden="true"></i> Afficher</a>
                                        @if (Auth::user()->profil_id != 5)
                                            <a href="{{ route('Admin.GroupeTD.TD.create', $id) }}"
                                                class="btn btn-secondary"><i class="fa fa-plus-circle"
                                                    aria-hidden="true"></i> Ajouter</a>
                                        @endif
                                    </td>
                                @endif

                            </tr>

                        </tbody>
                    </table>

                </div>


            </div>
        </section>

    </main>
@endsection
