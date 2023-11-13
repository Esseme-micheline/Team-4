@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des TD</h1>
            @if (isset($ue_tdSpecial_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item active">TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item active">TD</li>
                    </ol>
                </nav>
            @endif

        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des TDs
                    </h1>

                </div>
            </div>
            <div class="card">



                <div class="card-body">
                    <br>
                    @if ($tdSpecials != null || $tds != null)
                        <br>
                        @if (Auth::user()->profil_id != 5)
                            @if ($ues != null)
                                @if ($ues->count() > 0)
                                    <div class="row ">

                                        <div class="col-md-7 ">
                                            <form action="{{ route('Admin.groupeTD.show') }}" method="get"
                                                class="row d-flex align-items-center">
                                                @csrf
                                                <div class="col-6 row ">
                                                    <div class="col-12">
                                                        <label for="" class="form-label">UE:</label>
                                                        <select name="ue_id" id="" class="form-select">
                                                            <option value="">Selectionner un champ</option>
                                                            @if (isset($ue_id))
                                                                @foreach ($ues as $ue)
                                                                    @if ($ue->id == $ue_id)
                                                                        <option value="{{ $ue->id }}" selected>
                                                                            {{ $ue->code }}</option>
                                                                    @else
                                                                        <option value="{{ $ue->id }}">
                                                                            {{ $ue->code }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach ($ues as $ue)
                                                                    <option value="{{ $ue->id }}">{{ $ue->code }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="" class="form-label">TD :</label>
                                                        <select name="Td_id" id="" class="form-select">
                                                            <option value="">Selectionner Un champs</option>
                                                            @if (isset($td_id))
                                                                @if ($td_id == 1)
                                                                    <option value="1" selected>TD</option>
                                                                    <option value="2">TD Speciale</option>
                                                                @else
                                                                    <option value="1">TD</option>
                                                                    <option value="2" selected>TD Speciale</option>
                                                                @endif
                                                            @else
                                                                <option value="1">TD</option>
                                                                <option value="2">TD Speciale</option>
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
                            @endif
                        @endif



                        <br>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Intitule</th>
                                    <th scope="col">UE</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @if (isset($tds))
                                    @foreach ($tds as $td)
                                        <tr id="sid{{ $td->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td>{{ $td->code }}</td>
                                            <td class=" text-break" style="width:10rem">{{ $td->intitule }}</td>
                                            <td>{{ $td->ue['code'] }}</td>
                                            <td>-</td>
                                            <td><a href="{{ route('Admin.indexTd', $td->id) }}" class="btn btn-success"><i
                                                        class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    Voir plus</a>
                                                @if (Auth::user()->profil_id != 5)
                                                    &ensp;
                                                    <a href="javascript:void(0)" onclick="editTd({{ $td->id }})"
                                                        class="btn btn-danger"><i class="fa fa-edit"
                                                            aria-hidden="true"></i>Update</a>&ensp;
                                                    <a onclick="return confirm('Voulez vous supprimer se TD et avec tout sont contenu?')"
                                                        href="{{ route('Admin.groupeTD.delete', $td->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></i>Delete</a>
                                                @endif
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                @endif

                                @if (isset($tdSpecials))
                                    @foreach ($tdSpecials as $tdSpecial)
                                        <tr id="sids{{ $tdSpecial->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td>{{ $tdSpecial->code }}</td>
                                            <td class=" text-break" style="width:10rem">{{ $tdSpecial->intitule }}</td>
                                            <td>{{ $tdSpecial->ue['code'] }}</td>
                                            <td>{{ $tdSpecial->prix }}</td>
                                            <td><a href="{{ route('Admin.indexTdSpecial', $tdSpecial->id) }}"
                                                    class="btn btn-success"><i class="fa fa-plus-circle"
                                                        aria-hidden="true"></i>
                                                    Voir plus</a>
                                                @if (Auth::user()->profil_id != 5)
                                                    &ensp;<a href="javascript:void(0)"
                                                        onclick="editTdSpeciale({{ $tdSpecial->id }})"
                                                        class="btn btn-danger"><i class="fa fa-edit"
                                                            aria-hidden="true"></i>Update</a>&ensp;
                                                    <a onclick="return confirm('Voulez vous supprimer se TD Speciale et avec tout sont contenu?')"
                                                        href="{{ route('Admin.groupeTD.deleteTdSpecial', $tdSpecial->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></i>Delete</a>
                                                @endif
                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- @else
                            <div>Vous n'avez pas encore ajouter de UEs</div>
                        @endif --}}
                    @else
                        <div>R.A.S</div>
                    @endif
                </div>


            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionTd')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionTd.js') }}"></script>
@endsection
