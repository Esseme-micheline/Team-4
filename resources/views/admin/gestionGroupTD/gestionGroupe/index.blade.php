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
                        <li class="breadcrumb-item active">Groupe TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item">TD</li>
                        <li class="breadcrumb-item active">Groupe TD</li>
                    </ol>
                </nav>
            @endif

        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestion des Groupe de TDs
                    </h1>

                </div>
            </div>
            <div class="card">



                <div class="card-body">
                    <br>
                    <div class="col-12 text-center p-3 d-flex justify-content-center">
                        <a href="{{ route('Admin.GroupeTD.formImport', $td_id) }}" class="btn btn-primary"><i
                                class="fa fa-download" aria-hidden="true"></i>
                            Importer</a>
                    </div>
                    @if (Auth::user()->profil_id != 5)


                        @if (isset($tdSpecial_id))
                            <a href="{{ route('Admin.GroupeTD.TDSpeciale.create', $tdSpecial_id) }}"><i class="fa fa-plus"
                                    aria-hidden="true"></i>
                                Ajouter un Groupe de Td Speciale</a>
                        @else
                            @if (isset($td_id))
                                <a href="{{ route('Admin.GroupeTD.TD.create', $td_id) }}"><i class="fa fa-plus"
                                        aria-hidden="true"></i> Ajouter un groupe de TD</a>
                            @endif
                        @endif
                    @endif

                    <br><br>
                    @if (Auth::user()->profil_id != 5)


                        <div class="row ">
                            <div class="col-md-7 ">
                                <form action="{{ route('Admin.GroupeTD.shows') }}" method="get"
                                    class="row d-flex align-items-center">
                                    @csrf
                                    <div class="col-6 row ">
                                        <div class="col-12">
                                            @if (isset($tdSpecial_id))
                                                <label for="" class="form-label">TD Speciale:</label>
                                                <select name="td_special_id" id="" class="form-select">
                                                    <option value="">Selectionner un champ</option>
                                                    @if (isset($tdSpecial_id))
                                                        @foreach ($td_specials as $td_special)
                                                            @if ($td_special->id == $tdSpecial_id)
                                                                <option value="{{ $td_special->id }}" selected>
                                                                    {{ $td_special->code }}</option>
                                                            @else
                                                                <option value="{{ $td_special->id }}">
                                                                    {{ $td_special->code }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach ($td_specials as $td_special)
                                                            <option value="{{ $td_special->id }}">
                                                                {{ $td_special->code }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @else
                                                <label for="" class="form-label">TD:</label>
                                                <select name="td_id" id="" class="form-select">
                                                    <option value="">Selectionner un champ</option>
                                                    @if (isset($td_id))
                                                        @foreach ($tds as $td)
                                                            @if ($td->id == $td_id)
                                                                <option value="{{ $td->id }}" selected>
                                                                    {{ $td->code }}</option>
                                                            @else
                                                                <option value="{{ $td->id }}">
                                                                    {{ $td->code }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach ($tds as $td)
                                                            <option value="{{ $td->id }}">{{ $td->code }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            @endif
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


                    @if ($groupe_tds->count() > 0)
                        <br>
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Intitule</th>
                                    @if (isset($tdSpecial_id))
                                        <th scope="col">Td Speciale</th>
                                    @else
                                        <th scope="col">Td</th>
                                    @endif
                                    <th>Charge de TD</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">

                                @foreach ($groupe_tds as $groupe_td)
                                    <tr id="sid{{ $groupe_td->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:10rem">{{ $groupe_td->intitule }}</td>
                                        @if (isset($tdSpecial_id))
                                            <td>{{ $groupe_td->td_special->code }}</td>
                                        @else
                                            <td>{{ $groupe_td->td->code }}</td>
                                        @endif
                                        @if (isset($groupe_td->charge_td))
                                            <td>{{ $groupe_td->charge_td['noms'] }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td><a href="{{ route('Admin.GroupeTD.voir', $groupe_td->id) }}"
                                                class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                Voir plus</a>
                                            @if (Auth::user()->profil_id != 5)
                                                &ensp;
                                                <a href="javascript:void(0)" onclick="editGroupeTd({{ $groupe_td->id }})"
                                                    class="btn btn-danger"><i class="fa fa-edit"
                                                        aria-hidden="true"></i>Update</a>&ensp;
                                                <a onclick="return confirm('Voulez vous supprimer se groupe de TD et avec tout sont contenu?')"
                                                    href="{{ route('Admin.GroupeTD.TD.delete', $groupe_td->id) }}"
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
                            {{ $groupe_tds->links() }}
                        </div>


                </div>
            @else
                <div>Vous n'avez pas encore ajouter de groupe de TD</div>
                @endif

            </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionGroupeTd')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionGroupeTD.js') }}"></script>
@endsection
