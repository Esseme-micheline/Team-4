@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarAdminIndex')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion Utilisateur</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Liste </li>
                    <li class="breadcrumb-item active">Utilisateur</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->profil_id==2)
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Charges de TD
                    </h1>
                    @else
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Utilisateurs
                    </h1>
                    @endif

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($utilisateurs->count() > 0)
                        <br>



                        <br>

                        <!-- Dark Table -->
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Poste</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($utilisateurs as $utilisateur)
                                    <tr id="sid{{ $utilisateur->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:15rem">{{ $utilisateur->name }}</td>
                                        <td>{{ $utilisateur->email }}</td>
                                        @if ($utilisateur->profil_id == 0)
                                            <td>Super Admin</td>
                                        @elseif ($utilisateur->profil_id == 1)
                                            <td>Doyen Ecole Doctorat</td>
                                        @elseif ($utilisateur->profil_id == 2)
                                            <td>Chef du departement</td>
                                        @elseif ($utilisateur->profil_id == 3)
                                            <td>Enseignant</td>
                                        @elseif ($utilisateur->profil_id == 4)
                                            <td>Secretaire</td>
                                        @elseif($utilisateur->profil_id == 5)
                                            <td>Charge de Td</td>
                                        @else
                                            <td>Aucun profil</td>
                                        @endif
                                        <td>
                                            <a onclick="return confirm('Voulez vous supprimer cet utilisateur et avec tout sont contenu?')"
                                                href="{{ route('Admin.Utilisateur.delete', $utilisateur->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $utilisateurs->links() }}
                        </div>
                        <!-- End Dark Table -->
                    @else
                        <br>

                        <div>Vous n'avez pas encore ajouter d'utilisateur</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
