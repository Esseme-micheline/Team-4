@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Filiere</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Filiere</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Listes  des Actions d'une Filiere
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br>



                    <br>

                    <!-- Dark Table -->
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
                                <td>UE</td>
                                <td>
                                    <a href="{{ route('Admin.ue.showFil', $id) }}" class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i> Afficher</a>
                                    <a href="{{ route('Admin.ue.create', $id) }}" class="btn btn-secondary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Etudiant</td>
                                <td>
                                    <a href="{{ route('Admin.etudiant.index') }}" class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i> Afficher</a>
                                    <a href="{{ route('Admin.etudiant.createFil', $id) }}" class="btn btn-secondary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!-- End Dark Table -->

                </div>


            </div>
        </section>

    </main>
@endsection
