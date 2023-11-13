@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Seance TD</h1>
            @if (isset($isTdSpecial) && $isTdSpecial == true)
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item">TD Speciale</li>
                        <li class="breadcrumb-item">Groupe TD Speciale</li>
                        <li class="breadcrumb-item active">Seance Groupe TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item ">TD</li>
                        <li class="breadcrumb-item "> Groupe TD</li>
                        <li class="breadcrumb-item active">Seance Groupe TD</li>
                    </ol>
                </nav>
            @endif

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouvelle
                    Seance Groupe
                    de TD
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.sceanceTd.store') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="" class="form-label">Groupe TD:</label>
                        <select name="groupe_td_id" id="" required
                            @if (isset($nonGroupeTd)) autofocus @endif
                            class="form-select @error('groupe_td_id') is-invalid  @enderror">
                            <option value="">Selectionner un champ</option>
                            @if (isset($groupe_td_id))
                                @foreach ($groupe_tds as $groupe_td)
                                    @if ($groupe_td->id == $groupe_td_id)
                                        <option value="{{ $groupe_td->id }}" selected>{{ $groupe_td->intitule }}</option>
                                    @else
                                        <option value="{{ $groupe_td->id }}">{{ $groupe_td->intitule }}</option>
                                    @endif
                                @endforeach
                                @if ($groupe_tdSpecials != null)
                                    @foreach ($groupe_tdSpecials as $groupe_tdSpecial)
                                        @if ($groupe_tdSpecial->id == $groupe_td_id)
                                            <option value="{{ $groupe_tdSpecial->id }}" selected>
                                                {{ $groupe_tdSpecial->intitule }}</option>
                                        @else
                                            <option value="{{ $groupe_tdSpecial->id }}">{{ $groupe_tdSpecial->intitule }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                @foreach ($groupe_tds as $groupe_td)
                                    @if (old('groupe_td_id') == $groupe_td->id)
                                        <option value="{{ $groupe_td->id }}" selected>{{ $groupe_td->intitule }}
                                        </option>
                                    @else
                                        <option value="{{ $groupe_td->id }}">{{ $groupe_td->intitule }}</option>
                                    @endif
                                @endforeach
                                @if ($groupe_tdSpecials != null)
                                    @foreach ($groupe_tdSpecials as $groupe_tdSpecial)
                                        @if (old('groupe_td_id') == $groupe_tdSpecial->id)
                                            <option value="{{ $groupe_tdSpecial->id }}" selected>
                                                {{ $groupe_tdSpecial->intitule }}
                                            </option>
                                        @else
                                            <option value="{{ $groupe_tdSpecial->id }}">{{ $groupe_tdSpecial->intitule }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif

                            @endif
                        </select>
                        @error('groupe_td_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6">
                        <label for="" class="form-label">Charge de TD</label>
                        <select name="charge_td_id" id="" required
                            @if (isset($nonChargeTd)) autofocus @endif
                            class="form-select @error('charge_td_id') is-invalid  @enderror">
                            <option value="">Selectionner un champ</option>
                            @if (isset($charge_td_id))
                                @foreach ($charge_tds as $charge_td)
                                    @if ($charge_td->id == $charge_td_id)
                                        <option value="{{ $charge_td->id }}" selected>{{ $charge_td->noms }}</option>
                                    @else
                                        <option value="{{ $charge_td->id }}">{{ $charge_td->noms }}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($charge_tds as $charge_td)
                                    @if (old('charge_td_id') == $charge_td->id)
                                        <option value="{{ $charge_td->id }}" selected>{{ $charge_td->noms }}
                                        </option>
                                    @else
                                        <option value="{{ $charge_td->id }}">{{ $charge_td->noms }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @error('charge_td_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    {{-- <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Intitule de la Sceance de TD</label>
                        <input type="text" name="intitule" id="intitule" value="{{ old('intitule') }}" required
                            class="form-control @error('intitule') is-invalid  @enderror"
                            placeholder="Entrez l'intituler du TD">
                        @error('intitule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">date de la Seance de TD</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" required
                            class="form-control @error('date') is-invalid  @enderror" placeholder="Entrez la date du TD">
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 text-capitalize">
                        <label for="textereadescription" class="form-label">description de la Seance de TD</label>
                        <textarea name="description" id="" placeholder="Entrez la description du TD" rows="3"
                            class="form-control @error('description') is-invalid  @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">salle de la Seance de TD</label>
                        <input type="text" name="salle" id="salle" value="{{ old('salle') }}" required
                            class="form-control @error('salle') is-invalid  @enderror" placeholder="Entrez la salle du TD">
                        @error('salle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Capacite de la Sceance de TD</label>
                        <input type="number" name="capacite" id="capacite" value="{{ old('capacite') }}" required
                            class="form-control @error('capacite') is-invalid  @enderror"
                            placeholder="Entrez la capaciter du TD">
                        @error('capacite')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="col-md-3 text-capitalize">
                        <label for="textereadescription" class="form-label">Heure debut de la Seance de TD</label>
                        <input type="time" name="heureDebut" id="heureDebut" value="{{ old('heureDebut') }}" required
                            class="form-control @error('heureDebut') is-invalid  @enderror"
                            placeholder="Entrez l'heure de debut du TD">
                        @error('heureDebut')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-3 text-capitalize">
                        <label for="textereadescription" class="form-label">Heure Fin de la Seance de TD</label>
                        <input type="time" name="heureFin" id="heureFin" value="{{ old('heureFin') }}" required
                            class="form-control @error('heureFin') is-invalid  @enderror"
                            placeholder="Entrez l'heure de debut du TD">
                        @error('heureFin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form>

            </div>
    </main>
@endsection
