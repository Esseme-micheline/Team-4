@extends('layouts.admin.body')

@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Reporting</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Reporting</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Dossier <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="fa fa-book" aria-hidden="true" style="font-size: 25px;"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $dossier_nombre }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Dossier <span>| Authorisation</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $authorisation_nombre }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Dossier <span>| Attente de Note</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fa fa-book" aria-hidden="true" ></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $attente_note_nombre }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Dossier <span>| Authorisation Valider</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fa fa-book" aria-hidden="true" ></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $authorisation_valider_nombre }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @if (isset($datas))
                    @if (count($datas) > 0)
                        @foreach ($datas as $data)
                        {{-- {{ $data }} --}}
                            <div class="col-md-4 col-md-4">

                                <div class="card info-card customers-card">



                                    <div class="card-body">
                                        <h5 class="card-title">Departement
                                            <span>|{{ $data['departement'] }}</span><span>|{{ $data['niveau'] }}</span>
                                        </h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center "
                                                style="background-color: #f6f6fe">
                                                <i class="fa fa-book" style="color: blue;" aria-hidden="true"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $data['nombre'] }}</h6>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </section>

    </main>
@endsection
