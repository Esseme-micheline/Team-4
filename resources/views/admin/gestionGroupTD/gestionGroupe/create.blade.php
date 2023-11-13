@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Groupe TD</h1>
            @if (isset($tdSpecial_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item">TD Speciale</li>
                        <li class="breadcrumb-item active">Groupe TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item ">TD</li>
                        <li class="breadcrumb-item active">Groupe TD</li>
                    </ol>
                </nav>
            @endif

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouveau Groupe
                    de TD
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST"
                    action="@if (isset($tdSpecial_id)) {{ route('Admin.GroupeTD.TDSpeciale.store') }}
                @else
                    {{ route('Admin.GroupeTD.TD.store') }} @endif">
                    @csrf
                    @if (isset($tdSpecial_id))
                        <div class="col-md-6">
                            <label for="" class="form-label">Td Special</label>
                            <select name="td_special_id" id="td_id" required onchange="change()"
                                class="form-select @error('td_speciaTdl_id') is-invalid  @enderror">
                                <option value="">Selectionner un champ</option>
                                @if (isset($tdSpecial_id))
                                    @foreach ($td_specials as $td_special)
                                        @if ($td_special->id == $tdSpecial_id)
                                            <option value="{{ $td_special->id }}" selected>{{ $td_special->code }}</option>
                                        @else
                                            <option value="{{ $td_special->id }}">{{ $td_special->code }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($td_specials as $td_special)
                                        @if (old('td_special_id') == $td_special->id)
                                            <option value="{{ $td_special->id }}" selected>{{ $td_special->code }}
                                            </option>
                                        @else
                                            <option value="{{ $td_special->id }}">{{ $td_special->code }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('td_special_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @else
                        <div class="col-md-6">
                            <label for="" class="form-label"> TD</label>
                            <select name="td_id" id="td_id" required onchange="change()"
                                class="form-select @error('td_id') is-invalid  @enderror">
                                <option value="">Selectionner un champ</option>
                                @if (isset($td_id))
                                    @foreach ($tds as $td)
                                        @if ($td->id == $td_id)
                                            <option value="{{ $td->id }}" selected>{{ $td->code }}</option>
                                        @else
                                            <option value="{{ $td->id }}">{{ $td->code }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach ($tds as $td)
                                        @if (old('td_id') == $td->id)
                                            <option value="{{ $td->id }}" selected>{{ $td->code }}</option>
                                        @else
                                            <option value="{{ $td->id }}">{{ $td->code }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('td_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label for="" class="form-label">Charge de TD</label>
                        <select name="charge_td_id" id="" required
                            @if (!isset($nonChargeTd)) autofocus @endif
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
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Intitule du groupe de TD</label>
                        <input type="text" name="intitule" id="intitule"
                            value="@if (old('intitule') != null) {{ old('intitule') }}@else{{ $td_nom }} @endif"
                            required autofocus class="form-control @error('intitule') is-invalid  @enderror"
                            placeholder="Entrez l'intituler du TD">
                        @error('intitule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Jour</label>
                        <select name="jour" id="" class="form-select @error('jour') is-invalid  @enderror"
                            required>
                            <option value="">Selectionner un champs</option>
                            <option value="Lundi">Lundi</option>
                            <option value="Mardi">Mardi</option>
                            <option value="Mercredi">Mercredi</option>
                            <option value="Jeudi">Jeudi</option>
                            <option value="Vendredi">Vendredi</option>
                            <option value="Samedi">Samedi</option>
                            <option value="Dimanche">Dimanche</option>
                        </select>
                        @error('jour')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Heure debut </label>
                        <input type="time" name="heureDebut" id="heureDebut" value="{{ old('heureDebut') }}" required
                            class="form-control @error('heureDebut') is-invalid  @enderror"
                            placeholder="Entrez l'heure de debut du TD">
                        @error('heureDebut')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Heure Fin </label>
                        <input type="time" name="heureFin" id="heureFin" value="{{ old('heureFin') }}" required
                            class="form-control @error('heureFin') is-invalid  @enderror"
                            placeholder="Entrez l'heure de debut du TD">
                        @error('heureFin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">salle</label>
                        <input type="text" name="salle" id="salle" value="{{ old('salle') }}" required
                            class="form-control @error('salle') is-invalid  @enderror" placeholder="Entrez la salle">
                        @error('salle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 text-capitalize">
                        <label for="textereadescription" class="form-label">Capacite </label>
                        <input type="number" name="capacite" id="capacite" value="{{ old('capacite') }}" required
                            class="form-control @error('capacite') is-invalid  @enderror"
                            placeholder="Entrez la capaciter ">
                        @error('capacite')
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
@section('scripts')
    <script>
        function change() {
            let td_id = document.getElementById('td_id');
            let intitule = document.getElementById('intitule');
            intitule.value = td_id.options[td_id.selectedIndex].text + '_Groupe_I'

        }
    </script>
@endsection
