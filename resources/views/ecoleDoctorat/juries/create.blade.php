@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Enregistrement d'un Jury</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole doctorat</li>
                    <li class="breadcrumb-item active">Jury</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center; font-size:30px">Enregistrement d'un Jury
                </h5>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Ecole_Doctorat.jury.store') }}">
                    @csrf
                    <div class="col-12 text-capitalize">
                        <label for="inputName5" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('noms') is-invalid  @enderror"
                            value="{{ old('noms') }}" id="inputName5" required name="noms" autofocus
                            placeholder="Entrez le nom svp">
                        @error('noms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        {{-- <div class="text-danger"></div> --}}
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">telephone </label>
                        <input type="number" name="telephone" id="telephone" value="{{ old('telephone') }}" autofocus
                            class="form-control @error('telephone') is-invalid  @enderror"
                            placeholder="Entrez le numero de telephone">
                        @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Email </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" autofocus
                            class="form-control @error('email') is-invalid  @enderror" placeholder="Entrez l'email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Grade </label>
                        <select name="grade" id="grade" class="form-select @error('grade') is-invalid  @enderror"
                            value="{{ old('grade') }}">
                            <option value="">Selectionner un champs</option>
                            <option value="Assistant">Assistant</option>
                            <option value="charge de cours">Charge de Cours</option>
                            <option value="Maitre de Conference">Maitre de Conference</option>
                            <option value="Professeur">Professeur</option>
                        </select>
                        @error('grade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Universite </label>
                        <select name="universite" id="universite"
                            class="form-select @error('universite') is-invalid  @enderror">
                            <option value="">selectionner un champs</option>
                            <option value="UY1">Universite de Yaounde I</option>
                        </select>
                        @error('universite')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label"> Faculte</label>
                        <select name="faculte" id="faculte"
                            class="form-select @error('faculte') is-invalid  @enderror">
                            <option value="">selectionner un champs</option>
                            <option value="FACSCIENCE">Faculte de Science</option>
                        </select>
                        @error('faculte')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Departement </label>
                        <select name="departement" id=""
                            class="form-select @error('departement') is-invalid  @enderror">
                            <option value="">Selectionner un champs</option>
                            @foreach ($departements as $departement)
                                @if (old('departement') == $departement->code)
                                    <option value="{{ $departement->code }}" selected>{{ $departement->intitule }}
                                    </option>
                                @else
                                    <option value="{{ $departement->code }}">{{ $departement->intitule }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('departement')
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
