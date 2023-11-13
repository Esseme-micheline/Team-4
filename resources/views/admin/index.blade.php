@extends('layouts.admin.body')

@section('content')
@include('layouts.admin.sidebarAdminIndex')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Statistique</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Statistique</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Etudiant <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $etudiant_nombre }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @foreach ($datas_filiere as $filiere=>$nombre)
                    <div class="col-md-4 col-md-4">

                        <div class="card info-card customers-card">



                            <div class="card-body">
                                <h5 class="card-title">Filiere <span>|{{ $filiere }}</span><span>|Etudiant</span>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center "
                                        style="background-color: #d6e8f3">
                                        <i class="bi bi-people" style="color: blue;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nombre }}</h6>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach
                @foreach ($datas as $niveau=>$nombre)
                    <div class="col-md-4 col-md-4">

                        <div class="card info-card customers-card">



                            <div class="card-body">
                                <h5 class="card-title">Niveaux <span>|{{ $niveau }}</span><span>|Etudiant</span>
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center "
                                        style="background-color: #d6e8f3">
                                        <i class="bi bi-people" style="color: blue;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nombre }}</h6>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>

    </main>
@endsection
