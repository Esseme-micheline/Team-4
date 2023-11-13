@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
<div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="bologna-list">
            <li class="nav-item">
                <a class="nav-link active"  href="#abstract">Abstract</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#authors">Authors</a>
            </li>
            </ul>
        </div>
        <div class="card-body">
        <div class="tab-content mt-3">
              <div class="tab-pane active" id="abstract" role="tabpanel">
                <p class="card-text">{{$selectedProject->abstract}}</p>
              </div>

              <div class="tab-pane" id="authors" role="tabpanel" aria-labelledby="history-tab">
                <p class="card-text">{{$selectedProject->members}}</p>
              </div>

            </div>
        </div>
        <div class="card-footer">
            <p>{{$selectedProject->created_at}}</p>
        </div>
        </div>
    <div style="margin:100px 0px; background-color:white; padding:20px 20px; border-radius:10px;box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);">
        <h1 align="center" style="margin:20px 0px">Attestation de soutenance</h1>
        <div>
            @if($selectedProject->is_valid == 3)
            <embed src="{{ asset("uploads/themes/$selectedProject->theme/attestation/resoumission/$selectedProject->attestation_path") }}" type="application/pdf" width="100%" height="600px" >
            @else
            <embed src="{{ asset("uploads/themes/$selectedProject->theme/attestation/$selectedProject->attestation_path") }}" type="application/pdf" width="100%" height="600px" >
            @endif

        </div>
    </div>

    <div style="margin:100px 0px; background-color:white; padding:20px 20px; border-radius:10px;box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);">
        <h1 align="center" style="margin:20px 0px">Document Memoire</h1>
        <div>

        @if($selectedProject->is_valid == 3)
            <embed src="{{ asset("uploads/themes/$selectedProject->theme/memoire/resoumission/$selectedProject->memoire_path") }}" type="application/pdf" width="100%" height="600px" >
        @else
            <embed src="{{ asset("uploads/themes/$selectedProject->theme/memoire/$selectedProject->memoire_path") }}" type="application/pdf" width="100%" height="600px" >
        @endif

        </div>
    </div>
    <div>
    <p class="text-primary"> - Evaluer la formation et structure du document</p>
    <h4 align="center" class="text-info">Je confirme avoir examiné et m'être assuré que les documents ci-dessus sont authentiques et corrects </h4>
    <div style="display:flex;gap:30px;">
    <form method="POST" action="{{ route('Ecole_Doctorat.dossier.actions.valider', $selectedProject->id) }}" style="width:100%">

@csrf
<div>
    <label>Originalité</label>
    <select name="originalite" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Presentation</label>
    <select name="presentation" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Applicabilité</label>
    <select name="applicabilite" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Recommendations</label>
    <select name="rec" id="" class="form-select">
        <option value="" disabled selected>Choisir</option>
        <option value="Fortement accepte">Fortement accepte</option>
        <option value="Accepte">Accepte</option>
        <option value="Marginalement accepte">Marginalement accepte</option>
        <option value="Accepte avec modifications">Accepte avec modifications</option>
        <option value="Resoumettre">Resoumettre</option>
        <option value="Rejete">Rejete</option>
    </select>
</div>
<div style="width:96%;margin:10px auto;" >
    <label>commenter</label>
    <textarea name="comments" id="" class="form-control" placeholder="Citer des commentaires a propos (Optionelle)" style="resize:none;">

    </textarea>
</div>

<button class="btn  btn-success" style="width:95%;margin:10px;">Valider ce projet</button>
</form>

<div style="width:100%">
<form method="POST" action="{{ route('Ecole_Doctorat.dossier.actions.rejeter', $selectedProject->id) }}">

@csrf
<div>
    <label>Originalité</label>
    <select name="originalite" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Presentation</label>
    <select name="presentation" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Applicabilité</label>
    <select name="applicabilite" id="" class="form-select">
        <option value="" disabled>Choisir</option>
        <option value="Exceptionnelle">Exceptionnelle</option>
        <option value="Excellente">Excellent</option>
        <option value="Tres bien">Très bien</option>
        <option value="Bien">Bien</option>
        <option value="Passable">Passable</option>
        <option value="Mediocre">Mediocre</option>
    </select>
</div>
<div>
    <label>Recommendations</label>
    <select name="rec" id="" class="form-select" disabled>
        <option value="" disabled selected>Choisir</option>
        <option value="Fortement accepte">Fortement accepte</option>
        <option value="Accepte">Accepte</option>
        <option value="Marginalement accepte">Marginalement accepte</option>
        <option value="Accepte avec modifications">Accepte avec modifications</option>
        <option value="Resoumettre">Resoumettre</option>
        <option value="Rejete" selected>Rejete</option>
    </select>
</div>
<div style="width:96%;margin:10px auto;">
    <label>commenter</label>
    <textarea name="comments" id="" class="form-control" placeholder="Citer des commentaires a propos (Optionelle)" style="resize:none;">

    </textarea>
</div>

<button class="btn  btn-danger" style="width:95%;margin:10px;">Rejeter le projet</button>
</form>
</div>
    </div>
    </div>
</main>

@endsection
@section('scripts')
    <script>
        $('#bologna-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')})
    </script>
@endsection
