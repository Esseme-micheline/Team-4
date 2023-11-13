@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Groupe TD/TP</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item">Groupe TD/TP</li>
                    <li class="breadcrumb-item active">Import</li>
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
                                <h1>Importer les groupes de TD/ TP</h1>
                                <p>Les fichiers .xls, .xlsx et .csv sont authorise</p>
                            </div>
                            <form class="row" action="{{ route('Admin.GroupeTD.import', $id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $id }}">
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
