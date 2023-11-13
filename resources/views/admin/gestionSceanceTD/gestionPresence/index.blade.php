@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1 class="text-capitalize">Liste de Presence d'une Sceance</h1>
                @if (isset($isTdSpecial) && $isTdSpecial == true)
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                            <li class="breadcrumb-item">Faculte</li>
                            <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                            <li class="breadcrumb-item"> TD Speciale</li>
                            <li class="breadcrumb-item">Groupe TD Speciale</li>
                            <li class="breadcrumb-item ">Sceance Groupe TD Speciale</li>
                            <li class="breadcrumb-item active">Presence Sceance Groupe TD</li>
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
                            <li class="breadcrumb-item">Sceance Groupe TD</li>
                            <li class="breadcrumb-item active">Presence Sceance Groupe TD</li>
                        </ol>
                    </nav>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Liste de Presence
                            d'une
                            sceance
                        </h1>

                    </div>
                </div>
                <div class="card">



                    <div class="card-body">
                        <br>



                        @if ($presences_sceances_count > 0)
                            <br>
                            <div class="col-12 text-end"><a
                                    href="{{ route('Admin.Presencesceance.exportPDF', $sceance_td_id) }}"
                                    class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a> <a
                                    onclick="return confirm('Voulez vous supprimer cette liste de Presence ?')"
                                    href="{{ route('Admin.Presencesceance.delete', $sceance_td_id) }}"
                                    class="btn btn-secondary"><i class="fa fa-trash" aria-hidden="true"></i></i>Delete
                                    All</a></div>
                            {{-- {{ route('Admin.sceanceTd.delete', $presences_sceance->id) }} --}}
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Noms</th>
                                        <th scope="col">Satus</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">

                                    @foreach ($presences_sceances as $presences_sceance)
                                        <tr id="sid{{ $presences_sceance['id'] }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td class=" text-break" style="width:10rem">
                                                {{ $presences_sceance['matricule'] }}</td>
                                            <td class=" text-break" style="width:14rem">
                                                {{ $presences_sceance['noms'] }}</td>
                                            @if ($presences_sceance['status'] == 0)
                                                <td>Absent</td>
                                            @else
                                                <td>Present</td>
                                            @endif
                                            <td>
                                                <a href="javascript:void(0)"
                                                    onclick="editPresence({{ $presences_sceance['id'] }})"
                                                    class="btn btn-danger"><i class="fa fa-edit"
                                                        aria-hidden="true"></i>Update</a>&ensp;

                                            </td>

                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- <div class="pagination justify-content-center">
                                {{ $presences_sceances->links() }}
                            </div> --}}
                        @else
                            <br>
                            <a href="{{ route('Admin.Presencesceance.create', $sceance_td_id) }}"><i class="fa fa-plus"
                                    aria-hidden="true"></i>Ajouter une Liste de Presence</a><br>
                            <div>Vous n'avez pas encore ajouter liste de Presence du TD</div>
                        @endif
                    </div>
                </div>
        </section>

    </main>
@endsection
@section('modals')
    @include('layouts.modals.gestionPresence')
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/gestionPresence.js') }}"></script>
@endsection
