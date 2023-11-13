@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Etudiants</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Etudiants</li>
                </ol>
            </nav>
        </div>
        <section class="section">



            <div class="card">
                <div class="card-body">
                    <br>

                    <div class=" d-flex justify-content-center">
                        <div class="row">

                            <div class="text-center">
                                <h1>Exporter la liste des etudiants</h1>
                                <p>Les fichiers .csv .xlsx et .pdf sont authorise</p>
                            </div>
                            <form action="{{ route('Admin.etudiant.export') }}" method="post">
                                @csrf
                                @if (isset($niveau_id))
                                    <input type="hidden" name="niveau_id" value="{{ $niveau_id }}">
                                @endif
                                @if (isset($filiere_id))
                                    <input type="hidden" name="filiere_id" value="{{ $filiere_id }}">
                                @endif
                                <div class="d-flex justify-content-center">
                                    <div class=" form-check">
                                        <input class="form-check-input" type="radio" name="export" value="pdf"
                                            id="flexCheckIndeterminate">
                                        <label class="form-check-label" for="flexCheckIndeterminate">PDF
                                        </label>
                                    </div>&ensp; &ensp;
                                    <div class=" form-check">
                                        <input class="form-check-input" type="radio" name="export" value="xlsx"
                                            id="flexCheckIndeterminate">
                                        <label class="form-check-label" for="flexCheckIndeterminate">Excel(XLSX)
                                        </label>
                                    </div>&ensp; &ensp;
                                    <div class=" form-check">
                                        <input class="form-check-input" type="radio" name="export" value="csv"
                                            id="flexCheckIndeterminate">
                                        <label class="form-check-label" for="flexCheckIndeterminate">Excel(csv)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Exporter</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>

            </div>
        </section>

    </main>
@endsection
