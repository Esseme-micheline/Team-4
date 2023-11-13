@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form UE</h1>
            @if (isset($filiere_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.departement.index') }}">Departement</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.filiere.index') }}">Filiere</a></li>
                        <li class="breadcrumb-item active">UE</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Forms</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.niveau.index') }}">Niveau</a></li>
                        <li class="breadcrumb-item active">UE</li>
                    </ol>
                </nav>
            @endif

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouveau UE
                </h1>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.ue.store') }}" id="formContainType">
                    @csrf
                    <div class="col-md-6">
                        <label for="" class="form-label">Filiere</label>
                        <select name="filiere_id" id="" required
                            class="form-select @error('filiere_id') is-invalid  @enderror"
                            @if (!isset($filiere_id)) autofocus @endif>
                            <option value="">Selectionner un champ</option>
                            @if (isset($filiere_id))
                                @foreach ($filieres as $filiere)
                                    @if ($filiere->id == $filiere_id)
                                        <option value="{{ $filiere->id }}" selected>{{ $filiere->intitule }}</option>
                                    @else
                                        <option value="{{ $filiere->id }}">{{ $filiere->intitule }}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($filieres as $filiere)
                                    @if (old('filiere_id') == $filiere->id)
                                        <option value="{{ $filiere->id }}" selected>{{ $filiere->intitule }}</option>
                                    @else
                                        <option value="{{ $filiere->id }}">{{ $filiere->intitule }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @error('filiere_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Niveau</label>
                        <select name="niveau_id" id=""
                            class="form-select @error('niveau_id') is-invalid  @enderror" required
                            @if (!isset($niveau_id)) autofocus @endif>
                            <option value="">Selectionner Un champs</option>
                            @if (isset($niveau_id))
                                @foreach ($niveaux as $niveau)
                                    @if ($niveau->id == $niveau_id)
                                        <option value="{{ $niveau->id }}" selected>{{ $niveau->intitule }}</option>
                                    @else
                                        <option value="{{ $niveau->id }}">{{ $niveau->intitule }}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($niveaux as $niveau)
                                    @if (old('niveau_id') == $niveau->id)
                                        <option value="{{ $niveau->id }}" selected>{{ $niveau->intitule }}</option>
                                    @else
                                        <option value="{{ $niveau->id }}">{{ $niveau->intitule }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @error('niveau_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div id="modelForm" class="row">
                        <div class="col-md-6 text-capitalize">
                            <label for="inputName5" class="form-label">Code de l'UE</label>
                            <input type="text" class="form-control @error('code') is-invalid  @enderror"
                                value="{{ old('code') }}" id="inputName5" autocomplete="code" required name="code[]"
                                placeholder="Entrez le code de l'UE">
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 text-capitalize">
                            <label for="textereadescription" class="form-label">Intitule de l'UE</label>
                            <input type="text" name="intitule[]" id="intitule" value="{{ old('intitule') }}" required
                                autofocus class="form-control @error('intitule') is-invalid  @enderror"
                                placeholder="Entrez l'intituler de l'ue">
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
                </form>

            </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/ajoutUE.js') }}"></script>
@endsection
