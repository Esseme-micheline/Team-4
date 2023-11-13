@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Etudiant Dossier</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item"><a href="{{ route('Ecole_Doctorat.dossier.index') }}">Dossier</a></li>
                    <li class="breadcrumb-item active">Etudiant Dossier</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Dossier de
                        {{ $dossier->etudiant['noms'] }}</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            @if ($dossier->note_lecture_Pr != null || $dossier->note_lecture_En != null || $dossier->note_lecture_Ex != null)
                <div class="card">
                    <div class="card-body">

                        <div class="tab-pane fade show active profile-overview">


                            <h5 class="card-title">Note de L'etudiant</h5>
                            @if ($dossier->note_lecture_Pr != null)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Note du President du jury</div>
                                    <div class="col-lg-9 col-md-8">{{ $dossier->note_lecture_Pr }}</div>
                                </div>
                            @endif
                            @if ($dossier->note_lecture_En != null)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Note de l'Encadreur</div>
                                    <div class="col-lg-9 col-md-8"> {{ $dossier->note_lecture_En }}</div>
                                </div>
                            @endif
                            @if ($dossier->note_lecture_Ex != null)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Note de l'Examinateur</div>
                                    <div class="col-lg-9 col-md-8"> {{ $dossier->note_lecture_Ex }}</div>
                                </div>
                            @endif
                            @if ($dossier->note_lecture_Pr != null && $dossier->note_lecture_En != null && $dossier->note_lecture_Ex != null)
                                @if ($dossier->observation == null)
                                    <form action="{{ route('Ecole_Doctorat.etudiantDos.storeDate') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Date de soutenance</div>
                                            <div class="col-lg-9 col-md-8"><input type="date" name="date"
                                                    id="date" required
                                                    class="form-control @error('date') is-invalid  @enderror"></div>
                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 text-center">
                                            <br>
                                            <button type="submit" class="btn btn-primary ">Enregistrer</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Date de soutenance</div>
                                        <div class="col-lg-9 col-md-8"> {{ $dossier->observation }} </div>
                                    </div>
                                @endif
                            @endif

                        </div>


                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <br><br>

                    <br>
                    {{-- <form action="{{ route('Ecole_Doctorat.etudiantDos.fichier') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="" class="form-control" value="{{ $dossier->id }}">
                        <input type="file" name="file" id="file" class="form-control">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </form> --}}
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Matricule</th>
                                <th scope="col">Memoire</th>
                                <th scope="col">Rapport de soutenance</th>
                                <th scope="col">Droit Universite</th>
                                <th scope="col">Attestation de licence</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbodys">
                            <tr id="sid{{ $dossier->id }}">
                                <td>{{ $dossier->etudiant['matricule'] }}</td>
                                @if ($dossier->documents->count() > 0)
                                    @foreach ($dossier->documents as $document)
                                        <div style="display: none;">{{ $etat = $document->etat }} </div>
                                        <td><a
                                                href="{{ Storage::url($document->documents) }}">{{ $document->nature['libelle'] }}</a>
                                            &ensp; &ensp; </td>
                                    @endforeach

                                    @if ($etat == 0)
                                        <td><a onclick="return confirm('Voulez vous accepter ces documents?')"
                                                href="{{ route('Ecole_Doctorat.etudiantDos.updateDoc', $dossier->id) }}"><i
                                                    class="fa fa-check text-success" aria-hidden="true"></i></a>&ensp;
                                            &ensp;<a onclick="return confirm('Voulez vous rejeter ces documents?')"
                                                href="{{ route('Ecole_Doctorat.etudiantDos.delete', $dossier->id) }}"><i
                                                    class="fa-solid fa-circle-xmark text-danger"></i></a></td>
                                    @else
                                        <td>-</td>
                                    @endif
                                @else
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($changements->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <br><br>

                        <br>
                        @foreach ($changements as $changement)
                            <div class="tab-pane fade show active profile-overview">


                                <h5 class="card-title">Detail de la requete</h5>
                                <form action="{{ route('Ecole_Doctorat.etudiantDos.storeRequete') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="changement" id="" value="{{ $changement->id }}">

                                    @if ($changement->encadreur_id != null)
                                        <input type="hidden" name="change_val[]" value="1">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Ancien Encadreur</div>
                                            <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                    href="{{ route('Ecole_Doctorat.jury.voir', $dossier->encadreur->id) }}">{{ $dossier->encadreur['noms'] }}</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Nouveau Encadreur</div>
                                            <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                    href="{{ route('Ecole_Doctorat.jury.voir', $changement->encadreur_id) }}">{{ $changement->encadreur['noms'] }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($changement->coEncadreur_id != null)
                                        <input type="hidden" name="change_val[]" value="2">
                                        @if ($dossier->coEncadreur_id != null)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label ">Ancien co-Encadreur</div>
                                                <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                        href="{{ route('Ecole_Doctorat.jury.voir', $dossier->coEncadreur->id) }}">{{ $dossier->coEncadreur['noms'] }}</a>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Nouveau co-Encadreur</div>
                                            <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                    href="{{ route('Ecole_Doctorat.jury.voir', $changement->coEncadreur->id) }}">{{ $changement->coEncadreur['noms'] }}</a><br>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($changement->cooEncadreur_id != null)
                                        <input type="hidden" name="change_val[]" value="3">
                                        @if ($dossier->cooEncadreur_id != null)
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label ">Ancien coo-Encadreur</div>
                                                <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                        href="{{ route('Ecole_Doctorat.jury.voir', $dossier->cooEncadreur->id) }}">{{ $dossier->cooEncadreur['noms'] }}</a>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Nouveau coo-Encadreur</div>
                                            <div class="col-lg-9 col-md-8"><a class="text-primary"
                                                    href="{{ route('Ecole_Doctorat.jury.voir', $changement->cooEncadreur->id) }}">{{ $changement->cooEncadreur['noms'] }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($changement->theme != null)
                                        <input type="hidden" name="change_val[]" value="4">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Ancien Theme</div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ $dossier->theme_recherche }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Nouveau theme</div>
                                            <div class="col-lg-9 col-md-8">{{ $changement->theme }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12 text-center"><button name="action" value="valider"
                                            type="submit" class="btn btn-primary">Valider</button>&ensp;&ensp; <button
                                            onclick="return confirm('Voulez vous rejeter cette requete ?')" name="action"
                                            value="rejeter" type="submit" class="btn btn-warning">Rejeter</button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body text-center">
                    <br>
                    @if ($dossier->url_note_lecture_Pr != null)
                        <a href="{{ route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_Pr) }}" class="btn btn-danger">lien du
                            President Jury</a>
                    @endif
                    @if ($dossier->url_note_lecture_En !=null)
                            &ensp; <a href="{{ route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_En) }}" class="btn btn-secondary">lien
                               de l'Encadreur</a>
                    @endif
                    @if ($dossier->url_note_lecture_Ex)
                    &ensp; <a href="{{ route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_Ex) }}" class="btn btn-dark">lien
                        de l'Examinateur</a>
                    @endif
                </div>

            </div>
        </section>

    </main>
@endsection
