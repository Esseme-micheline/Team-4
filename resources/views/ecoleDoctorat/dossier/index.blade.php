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
           <!-- resources/views/components/breadcrumbs.blade.php -->

@php
$segments = explode('/', request()->path());
@endphp

<nav>
<ol class="breadcrumb">
    @foreach ($segments as $index => $segment)
        @php
            $path = implode('/', array_slice($segments, 0, $index + 1));
        @endphp

        <li class="breadcrumb-item {{ $index === count($segments) - 1 ? 'active' : '' }}">
            @if ($index === count($segments) - 1)
                {{ $segment }}
            @else
                <a href="{{ url($path) }}">{{ $segment }}</a>
            @endif
        </li>
    @endforeach
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
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-non-valider">Dossiers Rejetés</a>
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
                                        <th scope="col">Domaine</th>
                                        <th scope="col">Date Soumission</th>
                                        <th scope="col">Action</th>
        
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    
                                    @foreach ($unchecked_projects as $project)
                                    <tr>
                                        <td>
                                            @php
                                            
                                              $databaseId = $project->id;
                                          
                                              $code = rand(1000, 9999);
                                            @endphp
                                          
                                            {{ $code }}
                                          </td>
                                          
                                          
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>
                                            @php
                                                $theme = $project->theme;
                                                $maxCharacters = 50; // Définissez le nombre maximum de caractères que vous souhaitez afficher
                                                echo strlen($theme) > $maxCharacters ? substr($theme, 0, $maxCharacters) . '...' : $theme;
                                            @endphp
                                        </td>
                                        
                                        <td>{{$project->domaine}}</td>
                                        <td>
                                            <?php 
                                                echo date('Y-m-d', strtotime($project->created_at));
                                                echo '<br>';
                                                echo date('H:i:s', strtotime($project->created_at));
                                            ?>
                                        </td>
                                        

                                        <td>
                                            @if ($project->dossierOuvert)
                                                <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">
                                                    <i class="fa-solid fa-folder-open"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-danger" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">
                                                    <i class="fa-solid fa-folder"></i>
                                                </a>
                                               
                                            @endif
                                            <td>
                                                <form action="{{ route('Ecole_Doctorat/Dossier/rejeter', $project->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce dossier?')">
                                                        <i class="fa-solid fa-trash"></i> 
                                                    </button>
                                                </form>
                                            </td>
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
                                        <th scope="col">Domaine</th>
                                        <th scope="col">Vérifié par</th>
                                        <th scope="col">date validation</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach($checked_valid as $project)
                                    <tr>
                                        <td>
                                            @php
                                              
                                              $databaseId = $project->id;
                                          
                                              $code = rand(1000, 9999);
                                            @endphp
                                          
                                            {{ $code }}
                                          </td>
                                          
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>
                                            @php
                                                $theme = $project->theme;
                                                $maxCharacters = 50; // Définissez le nombre maximum de caractères que vous souhaitez afficher
                                                echo strlen($theme) > $maxCharacters ? substr($theme, 0, $maxCharacters) . '...' : $theme;
                                            @endphp
                                        </td>
                                        <td>{{$project->domaine}}</td>
                                        <td>{{$project->checked_by}}</td>
                                        <td>
                                            <?php
                                            $now = new DateTime();
                                            echo $now->format('Y-m-d') . '<br>';
                                            echo $now->format('H:i:s');
                                            ?>
                                            
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">
                                                <i class="fas fa-edit"></i>
                                              </a>
                                              
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
                                        <th scope="col">Domaine</th>
                                        {{-- <th scope="col">Vérifié par</th> --}}
                                        <th scope="col">Date Rejet</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach($checked_unvalid as $project)
                                    <tr>
                                        <td>
                                            @php
                                              
                                              $databaseId = $project->id;
                                        
                                              $code = rand(1000, 9999); // the code it generates is not fixed so it changes at everytime
                                            @endphp
                                          
                                            {{ $code }}
                                          </td>
                                          
                                        {{-- <td>{{$project->chef_matricule}}</td> --}}
                                        <td>
                                            @php
                                                $theme = $project->theme;
                                                $maxCharacters = 50; // Définissez le nombre maximum de caractères que vous souhaitez afficher
                                                echo strlen($theme) > $maxCharacters ? substr($theme, 0, $maxCharacters) . '...' : $theme;
                                            @endphp
                                        </td>
                                        <td>{{$project->domaine}}</td>
                                        
                                        {{-- ?\<td>{{$project->checked_by}}</td> --}}
                                        <td>
                                            <?php 
                                                echo date('Y-m-d', strtotime($project->created_at));
                                                echo '<br>';
                                                echo date('H:i:s', strtotime($project->created_at));
                                            ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('Ecole_Doctorat.dossier.voir', $project->id) }}">
                                                <i class="fas fa-edit"></i>
                                              </a>
                                              
                                        </td>
                                        <td>
                                            <form action="{{ route('Ecole_Doctorat.Dossier.supprimer', $project->id) }}" method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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