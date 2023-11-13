@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Seances de TD</h1>
            @if (isset($isTdSpecial) && $isTdSpecial == true)
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item"> TD Speciale</li>
                        <li class="breadcrumb-item">Groupe TD Speciale</li>
                        <li class="breadcrumb-item active">Sceance Groupe TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item">TD</li>
                        <li class="breadcrumb-item">Groupe TD</li>
                        <li class="breadcrumb-item active">Sceance Groupe TD</li>
                    </ol>
                </nav>
            @endif

        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des Seances de TDs
                    </h1>

                </div>
            </div>
            <div class="card">



                <div class="card-body">
                    <br>



                    @if (isset($groupe_td_id))
                        <a href="{{ route('Admin.sceanceTd.create', $groupe_td_id) }}"><i class="fa fa-plus"
                                aria-hidden="true"></i>Ajouter une Seance</a>
                    @endif

                    @if (Auth::user()->profil_id != 5 && Auth::user()->profil_id != 3)
                        <br><br>
                        <div class="row ">
                            <div class="col-md-7 ">
                                <form action="{{ route('Admin.sceanceTd.show') }}" method="get"
                                    class="row d-flex align-items-center">
                                    @csrf
                                    <div class="col-6 row ">
                                        <div class="col-12">
                                            <label for="" class="form-label">Groupe TD:</label>
                                            <select name="groupe_td_id" id="" class="form-select">
                                                <option value="">Selectionner un champ</option>
                                                @if (isset($groupe_td_id))
                                                    @foreach ($groupe_tds as $groupe_td)
                                                        @if ($groupe_td->id == $groupe_td_id)
                                                            <option value="{{ $groupe_td->id }}" selected>
                                                                {{ $groupe_td->intitule }}</option>
                                                        @else
                                                            <option value="{{ $groupe_td->id }}">
                                                                {{ $groupe_td->intitule }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($groupe_tds as $groupe_td)
                                                        <option value="{{ $groupe_td->id }}">{{ $groupe_td->intitule }}
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

                    @if ($sceance_tds->count() > 0)
                        <br>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Intitule</th>
                                    <th scope="col">description</th>
                                    <th scope="col">date</th>
                                    <th scope="col">heure</th>
                                    <th scope="col">Salle</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">

                                @foreach ($sceance_tds as $sceance_td)
                                    <tr id="sid{{ $sceance_td->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:10rem">{{ $sceance_td->intitule }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-eye"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li class="text-break" style="width:50rem">
                                                        <div id="description_sean{{ $sceance_td->id }}">
                                                            {{ $sceance_td->description }}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        {{-- <td class=" text-break" style="width:14rem"></td> --}}
                                        <td class=" text-break">{{ $sceance_td->date }}</td>
                                        <td class=" text-break">
                                            {{ $sceance_td->heureDebut }}H-{{ $sceance_td->heureFin }}H</td>
                                        <td class=" text-break">{{ $sceance_td->salle }}</td>

                                        <td><a href="{{ route('Admin.Presencesceance.index', $sceance_td->id) }}"
                                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Liste de presence</a>&ensp;
                                            <a href="javascript:void(0)" onclick="editSceanceTd({{ $sceance_td->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit"
                                                    aria-hidden="true"></i>Update</a>&ensp;
                                            <a onclick="return confirm('Voulez vous supprimer cette sceance  de TD et avec tout sont contenu?')"
                                                href="{{ route('Admin.sceanceTd.delete', $sceance_td->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $sceance_tds->links() }}
                        </div>


                </div>
            @else
                <div>Vous n'avez pas encore ajouter de sceance de TD</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionSceanceTD')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionSceance.js') }}"></script>
@endsection
