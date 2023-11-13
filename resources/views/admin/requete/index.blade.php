@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Requetes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Requete</li>
                </ol>

            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des Requetes
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <br>
                <div class="card-body">
                    @if ($requetes != null)


                        @if ($requetes->count() > 0)
                            <br>



                            <br>

                            <!-- Dark Table -->
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Noms</th>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Objet</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($requetes as $requete)
                                        <tr id="sid{{ $requete->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td class=" text-break" style="width:10rem">{{ $requete->etudiant['noms'] }}
                                            </td>
                                            <td>{{ $requete->etudiant['matricule'] }}</td>
                                            <td class=" text-break" style="width:15rem">{{ $requete->objet }}</td>
                                            <td><a href="{{ route('Admin.requete.voir', $requete->id) }}"
                                                    class="btn btn-success"><i class="fa fa-plus-circle"
                                                        aria-hidden="true"></i>
                                                    Voir plus</a>
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-center">
                                {{ $requetes->links() }}
                            </div>
                            <!-- End Dark Table -->
                        @else
                            <div>Il n'y a pas de requete pour le moment</div>
                        @endif
                    @else
                        <div>R.A.S</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
{{-- @section('modals')
    @include('layouts.modals.gestionrequete')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionrequete.js') }}"></script>
@endsection --}}
