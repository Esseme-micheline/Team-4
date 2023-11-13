@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarDonneeedebase')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Unite de Recherche</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Donnée de base</li>
                    <li class="breadcrumb-item active">Unite de Recherche</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center; font-size:30px">Enregistrement d'une nouvelle unite de
                    recherche
                </h5>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Ecole_Doctorat.unite_recherche.store') }}" id="formContainType">
                    @csrf
                    <div class="row" id="modelForm">
                        <div class="col-md-6 text-capitalize">
                            <label for="inputName5" class="form-label">Code</label>
                            <input type="text" class="form-control @error('code') is-invalid  @enderror"
                                value="{{ old('code') }}" id="inputName5" autocomplete="code" required name="code[]"
                                autofocus placeholder="Entrez le code de l'unite de Recherche">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- <div class="text-danger"></div> --}}
                        </div>
                        <div class="col-md-6 text-capitalize">
                            <label for="textereadescription" class="form-label">Intitule</label>
                            <input type="text" name="intitule[]" id="intitule" value="{{ old('intitule') }}" required
                                autofocus class="form-control @error('intitule') is-invalid  @enderror"
                                placeholder="Entrez l'intituler de l'unite de recherche">
                            @error('intitule')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div id="buttonArea" class="text-end">
                        <button onclick="del()" type="button" id="supButton" class="btn btn-dark">
                            Annuler
                        </button>&ensp;
                        <button onclick="add()" type="button" class="btn btn-success" id="addButton">
                            Ajouter
                        </button>
                    </div>
                    <div class="text-center" id="footerContainType">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>&ensp;
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
    </main>
@endsection
@section('scripts')
<script src="{{ asset('js/ecoleDoctorat/ajoutUniteRe.js') }}"></script>

@endsection
