@extends('layouts.admin.body')
@section('content')
@include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profil Jury</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Ecole_Doctorat.jury.index') }}">Jurys</a></li>
                    <li class="breadcrumb-item active">Profil Jury</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Profil d'un Jury</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <br>



                    <br>

                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Profil</button>
                        </li>

                        {{-- <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-ue">UE</button>
                        </li> --}}

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">


                            <h5 class="card-title">Detaile du Profil</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Noms</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->noms }}</div>
                            </div>



                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Grade</div>
                                <div class="col-lg-9 col-md-8"> {{ $jury->grade }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Telephone</div>
                                <div class="col-lg-9 col-md-8">(+237) {{ $jury->telephone }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->email }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Universite</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->universite }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Faculte</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->faculte }}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Departement</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->departement }}</div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-3 col-md-4 label">Nombre de UE</div>
                                <div class="col-lg-9 col-md-8">{{ $jury->attributions->count() }}</div>
                            </div> --}}

                        </div>
{{--
                        <div class="tab-pane fade pt-3 profile-ue" id="profile-ue">


                            <h5 class="card-title">Liste des UEs</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">UE</div>
                                <div class="col-lg-9 col-md-8">
                                @for ($i=0; $i<count($ue_code); $i++)
                                    {{ $ue_code[$i] }} <br>
                                @endfor
                            </div>
                            </div>

                        </div> --}}

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
