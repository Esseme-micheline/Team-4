@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des UEs</h1>
            @if (isset($filiere_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.departement.index') }}">Departement</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.filiere.index') }}">Filiere</a></li>
                        <li class="breadcrumb-item active">UE</li>
                    </ol>
                </nav>
            @else
                @if (isset($niveau_id))
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                            <li class="breadcrumb-item">Faculte</li>
                            <li class="breadcrumb-item"><a href="{{ route('Admin.niveau.index') }}">Niveau</a></li>
                            <li class="breadcrumb-item active">UE</li>
                        </ol>
                    </nav>
                @else
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                            <li class="breadcrumb-item">Faculte</li>
                            <li class="breadcrumb-item active">UE</li>
                        </ol>
                    </nav>
                @endif
            @endif
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des UEs
                    </h1>

                </div>
            </div>
            <div class="card">



                <div class="card-body">
                    <br>
                    @if ($ues != null)
                        @if ($filieres->count() > 0)
                            @if (Auth::user()->profil_id != 3)


                                @if (isset($filiere_id))
                                    <a href="{{ route('Admin.ue.create', $filiere_id) }}"><i class="fa fa-plus"
                                            aria-hidden="true"></i>
                                        Ajouter une UE</a>
                                @else
                                    @if (isset($niveau_id))
                                        <a href="{{ route('Admin.ue.createNiv', $niveau_id) }}"><i class="fa fa-plus"
                                                aria-hidden="true"></i> Ajouter une UE</a>
                                    @endif
                                @endif
                                <br><br>
                                <div class="row ">
                                    <div class="col-md-7 ">
                                        <form action="{{ route('Admin.ue.show') }}" method="get"
                                            class="row d-flex align-items-center">
                                            @csrf
                                            <div class="col-6 row ">
                                                <div class="col-12">
                                                    <label for="" class="form-label">Filiere:</label>
                                                    <select name="filiere_id" id="" class="form-select">
                                                        <option value="">Selectionner un champ</option>
                                                        @if (isset($filiere_id))
                                                            @foreach ($filieres as $filiere)
                                                                @if ($filiere->id == $filiere_id)
                                                                    <option value="{{ $filiere->id }}" selected>
                                                                        {{ $filiere->intitule }}</option>
                                                                @else
                                                                    <option value="{{ $filiere->id }}">
                                                                        {{ $filiere->intitule }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach ($filieres as $filiere)
                                                                <option value="{{ $filiere->id }}">
                                                                    {{ $filiere->intitule }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label for="" class="form-label">Niveau :</label>
                                                    <select name="niveau_id" id="" class="form-select">
                                                        <option value="">Selectionner Un champs</option>
                                                        @if (isset($niveau_id))
                                                            @foreach ($niveaux as $niveau)
                                                                @if ($niveau->id == $niveau_id)
                                                                    <option value="{{ $niveau->id }}" selected>
                                                                        {{ $niveau->intitule }}</option>
                                                                @else
                                                                    <option value="{{ $niveau->id }}">
                                                                        {{ $niveau->intitule }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach ($niveaux as $niveau)
                                                                <option value="{{ $niveau->id }}">
                                                                    {{ $niveau->intitule }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn text-light"
                                                    style="background: #012970;">Filtrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif



                            <br>
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Intitule</th>
                                        <th scope="col">Filiere</th>
                                        <th scope="col">Niveau</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($ues as $ue)
                                        <tr id="sid{{ $ue->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td>{{ $ue->code }}</td>
                                            <td class=" text-break" style="width:10rem">{{ $ue->intitule }}</td>
                                            <td>{{ $ue->filiere['code'] }}</td>
                                            <td>{{ $ue->niveau['code'] }}</td>
                                            <td><a href="{{ route('Admin.indexUE', $ue->id) }}" class="btn btn-success"><i
                                                        class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    Voir plus</a>
                                                @if (Auth::user()->profil_id != 3)
                                                    &ensp; <a href="javascript:void(0)"
                                                        onclick="editUe({{ $ue->id }})" class="btn btn-danger"><i
                                                            class="fa fa-edit" aria-hidden="true"></i>Update</a>&ensp;
                                                    <a onclick="return confirm('Voulez vous supprimer cette UE et avec tout sont contenu?')"
                                                        href="{{ route('Admin.ue.delete', $ue->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></i>Delete</a>
                                                @endif
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-center">
                                {{ $ues->links() }}
                            </div>
                            <!-- End Dark Table -->
                        @else
                            <div>Vous n'avez pas encore ajouter de UEs</div>
                        @endif
                    @else
                        <div>Aucune Ues present</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionue')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionue.js') }}"></script>
@endsection
