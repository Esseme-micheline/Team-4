@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion Enseignant</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item active">Enseignant</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center; font-size:30px">Enregistrement d'un Nouveau Ennseignant
                </h5>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.enseignant.store') }}">
                    @csrf
                    <div class="col-md-6 text-capitalize">
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
                        <label for="textereadescription" class="form-label">Bureau </label>
                        <input type="text" name="bureau" id="bureau" value="{{ old('bureau') }}" autofocus
                            class="form-control @error('bureau') is-invalid  @enderror">
                        @error('bureau')
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
