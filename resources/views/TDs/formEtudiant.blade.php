{{-- @extends('layouts.admin.body') --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Enregistrement Etudiant</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>


    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}" alt="logo de l'UY1" width="80"
                        srcset="">
                </a>
            </x-slot>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

            <form method="POST" action="{{ route('Inscription.form.store', $id) }}">
                @csrf

                <!-- Email Address -->
                {{-- <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div> --}}
                <div>
                    <h1 class="text-center">Formulaire D'enregistrement</h1>
                    <h3 class="text-center">Veuillez retenir votre numero de telephone</h3>
                </div>
                <input type="hidden" name="id", value="{{ $id }}">
                <div class="row mb-3">
                    <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('Nom & Prenom') }}</label>

                    <div class="col-md-12">
                        <input id="nom" type="text" class="form-control @error('noms') is-invalid @enderror"
                            name="noms" value="{{ old('noms') }}" required autofocus
                            placeholder="Entrez votre nom complet ">

                        @error('noms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @foreach ($filieres as $filiere)
                    @if ($ue->filiere_id == $filiere->id)
                        <input type="hidden" name="filiere_id" id="filiere_id" value="{{ $filiere->id }}">
                    @endif
                @endforeach
                <div class="row mb-3">
                    <label for="filiere_id" class="col-md-4 col-form-label text-md-end">{{ __('Filiere') }}</label>

                    <div class="col-md-12">
                        <select disabled required name="filiere_ids" id="filiere_ids"
                            class="form-control @error('filiere_id') is-invalid @enderror">
                            <option value="">Selectionner un champ</option>
                            @foreach ($filieres as $filiere)
                                @if (old('filiere_id') == $filiere->id)
                                    <option value="{{ $filiere->id }}" selected>{{ $filiere->intitule }}</option>
                                @elseif ($ue->filiere_id == $filiere->id)
                                    <option value="{{ $filiere->id }}" selected>{{ $filiere->intitule }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('filiere_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @foreach ($niveaux as $niveau)
                    @if ($ue->niveau_id == $niveau->id)
                        <input type="hidden" name="niveau_id" value="{{ $niveau->id }}">
                    @endif
                @endforeach
                <div class="row mb-3">
                    <label for="niveau_id" class="col-md-4 col-form-label text-md-end">{{ __('Niveau') }}</label>

                    <div class="col-md-12">
                        <select disabled required name="niveau_ids" id="niveau_ids"
                            class="form-control @error('niveau_id') is-invalid @enderror">
                            <option value="">Selectionner un champ</option>
                            @foreach ($niveaux as $niveau)
                                @if (old('niveau_id') == $niveau->id)
                                    <option value="{{ $niveau->id }}" selected>{{ $niveau->intitule }}</option>
                                @elseif ($ue->niveau_id == $niveau->id)
                                    <option value="{{ $niveau->id }}" selected>{{ $niveau->intitule }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('niveau_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="telephone" class="col-md-4 col-form-label text-md-end">{{ __('Telephone') }}</label>

                    <div class="col-md-12">
                        <input id="telephone" required type="number" min="650000000" max="699999999"
                            placeholder="650000000" class="form-control @error('telephone') is-invalid @enderror"
                            name="telephone" value="{{ old('telephone') }}" required>

                        @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="exemple@gmail.com">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
                    <a href="{{ route('Inscription.showTdUe', $id) }}" class="btn btn-danger">Annuler</a>&ensp;
                    <button type="submit" class="btn btn-primary bg-primary"
                        onclick="return confirm('Retenez bien votre numero de telephone et noter que l\'enregistrement ne se fait qu\'une seule fois')">Enregistrer</button>
                    {{-- <x-button class="ml-3" >
                        {{ __('Enregistrer') }}
                    </x-button> --}}
                </div>
                </div>
            </form>
        </x-auth-card>
    </x-guest-layout>
</body>

</html>
