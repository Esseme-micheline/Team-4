@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion Attributions</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Attribution</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Gestions des Attributions
                    </h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($attributions != null)
                        @if ($attributions->count() > 0)
                            <br>



                            <br>

                            <!-- Dark Table -->
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">UE</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodys">
                                    @foreach ($attributions as $attribution)
                                        <tr id="sid{{ $attribution->id }}">
                                            <th scope="row">{{ $n }}</th>
                                            <td class=" text-break" style="width:15rem">
                                                {{ $attribution->enseignant['noms'] }}
                                            </td>
                                            <td>{{ $attribution->ue['code'] }}</td>
                                            @if (Auth::user()->profil_id != 3)
                                                <td>
                                                    <a onclick="return confirm('Voulez vous supprimer cet attribution et avec tout sont contenu?')"
                                                        href="{{ route('Admin.attribution.delete', $attribution->id) }}"
                                                        class="btn btn-secondary"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></i>Delete</a>
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endif
                                        </tr>
                                        <div style="display:none;">{{ $n += 1 }}</div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-center">
                                {{ $attributions->links() }}
                            </div>
                            <!-- End Dark Table -->
                        @else
                            <br>
                            @if (Auth::user()->profil_id != 3)
                                <div class="col-12"><a href="{{ route('Admin.attribution.createAt') }}"> <i
                                            class="fa fa-plus" aria-hidden="true"></i> Ajouter un nouvelle attribution</a>
                                        </div>
                                        <div>Vous n'avez pas encore ajouter d'attribution</div>
                            @else
                                        <div>Vous n'avez pas encore reçu d'attribution</div>
                            @endif
                        @endif
                    @else
                        <div>R.A.S</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
@section('modals')
    {{-- @include('layouts.modals.gestionDepartement') --}}
@endsection
@section('scripts')
    {{-- <script src="{{ asset('js/admin/gestionDepartement.js') }}">
    </script> --}}
@endsection
