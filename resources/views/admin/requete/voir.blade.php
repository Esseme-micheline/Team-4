@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="text-capitalize">Gestion des Requete</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item "><a href="{{ route('Admin.requete.index') }}">Requete</a></li>
                    <li class="breadcrumb-item active">Dossier Requete</li>
                </ol>

            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Requete de
                        {{ $requete->etudiant['noms'] }}</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="tab-pane fade show active profile-overview">


                        <h5 class="card-title">Requete de L'etudiant</h5>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Objet</div>
                            <div class="col-lg-9 col-md-8">{{ $requete->objet }}</div>
                        </div>
                        @if ($requete->ue_id != null)
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">UE</div>
                                <div class="col-lg-9 col-md-8">{{ $requete->ue['intitule'] }}</div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Contenu</div>
                            <div class="col-lg-9 col-md-8"> {{ $requete->contenu }}</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Document</div>
                            <div class="col-lg-9 col-md-8"> <a href="{{ Storage::url($requete->document) }}">Piece
                                    jointe</a></div>
                        </div>

                    </div>


                </div>
            </div>

            @if ($requete->statut == 0)
                <div class="card">
                    <div class="card-body">
                        <br><br>
                        <form class="row" action="{{ route('Admin.requete.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $requete->id }}">
                            <div class="col-12">
                                <label for="reponse" class="form-label">Reponse</label>
                                <textarea name="reponse" id="" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <br>
                                <button onclick="return confirm('Voulez vous valider cette requete ?')" type="submit"
                                    class="btn btn-primary" name="action" value="valider">Valider</button>&ensp;&ensp;
                                <button onclick="return confirm('Voulez vous rejetr cette requete ?')" type="submit"
                                    class="btn btn-warning" name="action" value="rejeter">Rejeter</button>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            @endif

        </section>

    </main>
@endsection
