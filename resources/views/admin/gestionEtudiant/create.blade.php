@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarDonneeedebase')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Etudiant</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Donnée de base</li>
                    <li class="breadcrumb-item active">Etudiant</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center; font-size:30px">Enregistrement d'un Etudiant
                </h5>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.etudiant.store') }}">
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
                    <div class="col-md-6 text-capitalize">
                        <label for="inputName5" class="form-label">Matricule</label>
                        <input type="text" class="form-control @error('matricule') is-invalid  @enderror"
                            value="{{ old('matricule') }}" id="inputName5" required name="matricule" autofocus
                            placeholder="Entrez le matricule de l'etudiant">
                        @error('matricule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        {{-- <div class="text-danger"></div> --}}
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Nom</label>
                        <input type="text" name="noms" id="noms" value="{{ old('noms') }}" required autofocus
                            class="form-control @error('noms') is-invalid  @enderror"
                            placeholder="Entrez le nom de l'etudiant">
                        @error('noms')
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
