@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Filiere</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.departement.index') }}">Departement</a></li>
                    <li class="breadcrumb-item active">Filiere</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'une Nouvelle
                    Filiere
                </h1>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.filiere.store') }}">
                    @csrf
                    <div class="col-12">
                        <label for="" class="form-label">Departement</label>
                        <select name="departement_id" required id="" class="form-select"
                            @if (isset($dept)) autofocus @endif>
                            <option value="">Selectionner un champs</option>
                            @if (isset($id))
                                @foreach ($departements as $departement)
                                    @if ($id == $departement->id)
                                        <option value="{{ $departement->id }}" selected>{{ $departement->intitule }}
                                        </option>
                                    @else
                                        <option value="{{ $departement->id }}">{{ $departement->intitule }}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($departements as $departement)
                                    <option value="{{ $departement->id }}">{{ $departement->intitule }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="inputName5" class="form-label">Code de la Filiere</label>
                        <input type="text" class="form-control @error('code') is-invalid  @enderror"
                            value="{{ old('code') }}" id="inputName5" autocomplete="code" required name="code"
                            autofocus placeholder="Entrez le code de la filiere">
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        {{-- <div class="text-danger"></div> --}}
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Intitule de la Filiere</label>
                        <input type="text" name="intitule" id="intitule" value="{{ old('intitule') }}" required
                            autofocus class="form-control @error('intitule') is-invalid  @enderror"
                            placeholder="Entrez l'intituler de la filiere">
                        @error('intitule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
    </main>
@endsection
