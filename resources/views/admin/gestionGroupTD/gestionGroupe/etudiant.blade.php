@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Groupes de TD</h1>
            @if (isset($tdSpecial_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item"> TD Speciale</li>
                        <li class="breadcrumb-item">Groupe TD Speciale</li>
                        <li class="breadcrumb-item active">Etudiant</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item">TD</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.GroupeTD.voir', $id) }}">voir</a></li>
                        <li class="breadcrumb-item active"> Etudiant</li>
                    </ol>
                </nav>
            @endif

        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Listes des Etudiants du
                        Groupe {{ $groupe_td_nom }}
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br>



                    <br>
                    @if ($etudiants_groupes_tds_count->count() > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">matricule</th>
                                    <th scope="col">Noms</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etudiants_groupes_tds as $etudiants_groupes_td)
                                    <tr>
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $etudiants_groupes_td['matricule'] }}</td>
                                        <td class="listes">{{ $etudiants_groupes_td['noms'] }}</td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                onclick="showEtudiant({{ $etudiants_groupes_td['etudiant_id'] }})"
                                                class="btn btn-success"><i class="fa fa-eye"
                                                    aria-hidden="true"></i></a>&ensp;&ensp;<a
                                                onclick="return confirm('Voulez vous supprimer cet etudiant de se groupe?')"
                                                href="{{ route('Admin.GroupeTD.unsubscribeEtudiant', $etudiants_groupes_td['id']) }}"
                                                class="btn btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- <div class="pagination justify-content-center" id="pagination">
                            {{ $etudiants_groupes_tds->links() }}
                        </div> --}}
                    @else
                        <div>Pas encore d'etudiant inscrit</div>
                    @endif


                </div>


            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.showEtudiant')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionGroupeTD.js') }}"></script>
@endsection
