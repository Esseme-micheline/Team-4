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
                                <h1>Importer la liste des etudiants</h1>
                                <p>Les fichiers .xls, .xlsx et .csv sont authorise</p>
                            </div>
                            <form class="row" action="{{ route('Admin.Etudiant.import') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <label for="" class="fom-label">Niveau</label>
                                    <select name="niveau_id" required id="" class="form-select">
                                        <option value="">Selectionner un champs</option>
                                        @foreach ($niveaux as $niveau)
                                            <option value="{{ $niveau->id }}">{{ $niveau->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="fom-label">Filiere</label>
                                    <select name="filiere_id" required id="" class="form-select">
                                        <option value="">selectionner un champs</option>
                                        @foreach ($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-file col-12">
                                        <label for="" class="form-file-label">Importer le fichier</label>
                                        <input type="file" name="import" id="" class="form-control"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>
                                </div><br><br>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Importer</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>

            </div>
        </section>

    </main>
@endsection
