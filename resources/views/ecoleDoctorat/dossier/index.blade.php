@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        @if (session('success'))
            <div class="alert alert-success">
                <p>{{session('success')}}</p>
            </div>
        @elseif(session('erreur'))
            <div class="alert alert-danger">
                <p>{{session('erreur')}}</p>
            </div>
        @endif
        <div class="pagetitle">
            <h1>Liste de Thèmes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Dossier</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Liste de Thèmes</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <br><br>
                    <div class="row ">
                        <div class="col-md-7 ">
                            <!-- The code goes here---->
                        </div>
                        <div class="search-barss col-md-5 row">
                            <br>
                            {{-- <div class="col-12">

                            </div> --}}
                            <div class="col-12">
                                <button type="button" class="btn btn-info text-light" data-bs-toggle="modal"
                                    data-bs-target="#formNewsModal"> News</button>
                            </div>

                        </div>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-soumis">Dossiers Soumis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-valider">Dossiers Validés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-non-valider">Dossiers Non-Validés</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-soumis">
                            @if($unchecked_projects->count() > 0)
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        {{-- <th scope="col">Matricule Du Chef</th> --}}
                                        <th scope="col">Thème</th>
                                        <th scope="col">Encadreur</th>
                                        <th scope="col">Année</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($unchecked_projects as $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>{{$project->theme}}</td>
                                        <td>{{$project->encadreur_email}}</td>
                                        <td><?php echo(date('Y', strtotime($project->created_at)))?></td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">
                                                <i class="fa-solid fa-folder-open"></i>Voir plus
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-success"><b>Pas de thèmes non vérifiés pour l'instant</b></p>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="tab-valider">
                            @if($checked_valid->count() > 0)
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        {{-- <th scope="col">Matricule Du Chef</th> --}}
                                        <th scope="col">Thème</th>
                                        <th scope="col">Encadreur</th>
                                        <th scope="col">Vérifié par</th>
                                        <th scope="col">Année</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach($checked_valid as $project)
                                    <tr>
                                        <td>{{$project->id}}</td>
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>{{$project->theme}}</td>
                                        <td>{{$project->encadreur_email}}</td>
                                        <td>{{$project->checked_by}}</td>
                                        <td><?php echo(date('Y', strtotime($project->created_at)))?></td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">Revoir</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-success"><b>Pas de thèmes déjà validés pour l'instant</b></p>
                            @endif
                        </div>
    
                        <div class="tab-pane fade" id="tab-non-valider">
                            @if($checked_unvalid->count() > 0)
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        {{-- <th scope="col">Matricule Du Chef</th> --}}
                                        <th scope="col">Thème</th>
                                        <th scope="col">Encadreur</th>
                                        <th scope="col">Vérifié par</th>
                                        <th scope="col">Année</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach($checked_unvalid as $project)
                                    <tr>
                                        <td>{{$project->id}}</td>
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>{{$project->theme}}</td>
                                        <td>{{$project->encadreur_email}}</td>
                                        <td>{{$project->checked_by}}</td>
                                        <td><?php echo(date('Y', strtotime($project->created_at)))?></td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">Revoir</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-success"><b>Pas de thèmes resoummis pour l'instant</b></p>
                            @endif
                        
                        </div>
                    </div>
                </div>
    
                <!-- End Dark Table -->
    
            </div>
            </div>
        </section>
        
    </main>
    @endsection

@section('modals') @include('layouts.modals.dossierjury') @include('layouts.modals.dossierNew') @endsection

@section('scripts') <script src="{{ asset('js/ecoleDoctorat/dossier.js') }}"></script> @endsection