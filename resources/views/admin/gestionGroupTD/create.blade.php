@extends('layouts.admin.body')
@section('content')
@include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form TD</h1>
            @if (isset($ue_tdSpecial_id))
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item active">TD Speciale</li>
                    </ol>
                </nav>
            @else
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                        <li class="breadcrumb-item">Faculte</li>
                        <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                        <li class="breadcrumb-item active">TD</li>
                    </ol>
                </nav>
            @endif

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouveau TD
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST"
                    action="@if (isset($ue_tdSpecial_id)) {{ route('Admin.groupeTD.storeTdSpecial') }}
                @else
                    {{ route('Admin.groupeTD.store') }} @endif">
                    @csrf
                    <div class="col-12">
                        <label for="" class="form-label">UE</label>
                        <select name="ue_id" id="" required
                            class="form-select @error('ue_id') is-invalid  @enderror">
                            <option value="">Selectionner un champ</option>
                            @if (isset($ue_id))
                                @foreach ($ues as $ue)
                                    @if ($ue->id == $ue_id)
                                        <option value="{{ $ue->id }}" selected>{{ $ue->code }}</option>
                                    @else
                                        <option value="{{ $ue->id }}">{{ $ue->code }}</option>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($ues as $ue)
                                    @if (old('ue_id') == $ue->id)
                                        <option value="{{ $ue->id }}" selected>{{ $ue->code }}</option>
                                    @else
                                        <option value="{{ $ue->id }}">{{ $ue->code }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @error('ue_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6 text-capitalize">
                        <label for="inputName5" class="form-label">Code du TD</label>
                        <input type="text" class="form-control @error('code') is-invalid  @enderror"
                            value="{{ old('code') }}" id="inputName5" autofocus required name="code"
                            placeholder="Entrez le code du TD">
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="col-12 text-capitalize">
                        <label for="textereadescription" class="form-label">Intitule du TD</label>
                        <input type="text" name="intitule" id="intitule" value="{{ old('intitule') }}" required
                            autofocus class="form-control @error('intitule') is-invalid  @enderror"
                            placeholder="Entrez l'intituler du TD">
                        @error('intitule')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        @if (isset($ue_tdSpecial_id))
                            <label for="textereadescription" class="form-label">Prix du TD</label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix') }}" required
                                autofocus class="form-control @error('prix') is-invalid  @enderror"
                                placeholder="Entrez le prix du TD">
                            @error('prix')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form>

            </div>
    </main>
@endsection
