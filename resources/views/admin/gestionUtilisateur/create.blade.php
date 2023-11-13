@extends('layouts.admin.body')

@section('content')
    @include('layouts.admin.sidebarAdminIndex')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Ajout d'un Utilisateur</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Gestion Utilisateur</li>
                </ol>
            </nav>

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouveau
                    Utilisateur
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.Utilisateur.store') }}">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Enseignant</th>
                                <th scope="col">Profil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if (Auth::user()->profil_id == 0)
                                        <div class="">
                                            <label for="" class="form-label">Enseignant :</label>
                                            <select name="enseignant_id" id="" required
                                                class="form-select @error('enseignant_id') is-invalid  @enderror"
                                                @if (!isset($enseignant_id)) autofocus @endif>
                                                <option value="">Selectionner un champ</option>
                                                @if (isset($enseignant_id))
                                                    @foreach ($enseignants as $enseignant)
                                                        @if ($enseignant->id == $enseignant_id)
                                                            <option value="{{ $enseignant->id }}" selected>
                                                                {{ $enseignant->noms }}</option>
                                                        @else
                                                            <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($enseignants as $enseignant)
                                                        @if (old('enseignant_id') == $enseignant->id)
                                                            <option value="{{ $enseignant->id }}" selected>
                                                                {{ $enseignant->noms }}</option>
                                                        @else
                                                            <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('enseignant_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="">
                                            <label for="" class="form-label">Enseignant :</label>
                                            <select name="charge_td_id" id="" required
                                                class="form-select @error('charge_td_id') is-invalid  @enderror"
                                                @if (!isset($charge_td_id)) autofocus @endif>
                                                <option value="">Selectionner un champ</option>
                                                @if (isset($charge_td_id))
                                                    @foreach ($enseignants as $enseignant)
                                                        @if ($enseignant->id == $charge_td_id)
                                                            <option value="{{ $enseignant->id }}" selected>
                                                                {{ $enseignant->noms }}</option>
                                                        @else
                                                            <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($enseignants as $enseignant)
                                                        @if (old('charge_td_id') == $enseignant->id)
                                                            <option value="{{ $enseignant->id }}" selected>
                                                                {{ $enseignant->noms }}</option>
                                                        @else
                                                            <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                            </option>
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
                                    @endif
                                </td>
                                <td>
                                    <div class="col-12">
                                        <label for="" class="form-label">Profil</label>
                                        <select onchange="charger()" name="profil_id" id="profil_id" required
                                            class="form-select @error('profil_id') is-invalid  @enderror">
                                            <option value="">Selectionner un champ</option>
                                            @if (Auth::user()->profil_id == 0)
                                                <option value="0">Super Admin</option>
                                                <option value="1">Doyen Ecole Doctorat</option>
                                                <option value="2">Chef du departement</option>
                                                <option value="3">Enseignant</option>
                                                <option value="4">Secretaire</option>
                                            @else
                                                <option value="5">Charge de TD</option>
                                            @endif
                                        </select>
                                        @error('profil_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <div class="departement specifie_collapase" id="departement">
                                            @if ($departements !=null)
                                            <br>
                                                <label for="" class="form-label">Departement</label>
                                                <select name="departement_id" id="departement_id"
                                                    class="form-select @error('departement_id') is-invalid  @enderror">
                                                    <option value="">Selectionner un champ</option>
                                                    @foreach ($departements as $departement)
                                                        <option value="{{ $departement->id }}">
                                                            {{ $departement->intitule }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('departement_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div class="col-12">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="" class="form-control"
                            placeholder="Entrez un mot de passe pars defaut">
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
        function charger() {
                let val_titre = document.getElementById('profil_id').value
                let specifier = document.getElementById('departement')
                if (val_titre == 2 || val_titre==4) {
                    specifier.classList.remove('specifie_collapase')
                    $("#departement_id").attr('required', 'required');


                } else {
                    specifier.classList.add('specifie_collapase')
                    $("#departement_id").removeAttr('required');
                }
            }
    </script>

@endsection

