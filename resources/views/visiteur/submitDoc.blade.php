@extends('layouts.visitor.body')
<?php
    $domaines = config('global.constants.domaines');
    $typeProjet = config('global.constants.typeProjet');
?>
@section('content')
<form method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-row">
    <div class="form-group" style="font-size: bold; padding-left: 200px;">
      <h1>SOUMISSION</h1>
    </div><br>
    <div class="form-group">
      <label for="theme">Theme</label>
      <input required type="text" class="form-control" id="theme" placeholder="Votre Theme" name="projet_theme">
    </div><br>
    <div class="form-group">
      <label for="abstract">Abstract</label>
      <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3"
      name="projet_abstract"
      ></textarea>
    </div>
  </div><br>
  <div class="row">
  <div class="form-group col-md-6">
      <label for="projectMembers">Les membres du groupe</label>
      <textarea required name="members" class="form-control" id="projectMembers" rows="3"
        placeholder="ex: Jhone Doe, Tristina Joe"
      ></textarea>
  </div>
  <div class="form-group col-md-6">
      <label for="domain">Domain</label>
      <!-- <input type="text" class="form-control" placeholder="ex: Science / Technologie / Geography" id="domain" name="domaine"> -->
      <select required class="form-control" name="domaine" id="domaine">
        @foreach($domaines as $dom)
            <option value="{{$dom}}">{{$dom}}</option>
        @endforeach
      </select>
  </div><br>
  {{-- <div class="form-group col-md-6">
    <label for="">Type de projet</label><br>
    <input type="radio"><label for="">professionel</label>
    <input type="radio"><label for="">autres</label>
</div> --}}
  </div><br>

  <div class="row">
    <div class="form-group col-md-6">
      <label for="chefEmail">Email du correspondant</label>
      <input required type="email" class="form-control" id="chefEmail" name="chefMail">
    </div>
    
    <div class="form-group col-md-6">
      <label for="chefTelephone">Telephone du correspondant</label>
      <input required type="tel" class="form-control" id="chefTelephone" name="chefTel">
    </div>
  </div><br>

  <div class="row">
    <div class="form-group col-md-6">
      <label for="projectMembers">Noms des l'encadreur</label>
      <textarea required name="encardreurs" class="form-control" id="encardreurs" rows="3"
        placeholder="ex: Jhone Doe, Tristina Joe"
      ></textarea>
  </div>
    <div class="form-group col-md-4">
      <label for="emailEncadreur">Email de l'encadreur</label>
      <input required type="email" class="form-control" id="emailEncadreur" name="emailEncadreur">
    </div>
  </div>

  <div class="row">
    <p><h3>Documents a soummetre</h3></p>
    <div class="form-group col-md-4">
      <label for="attestationDoc">Attestation de soutenance</label>
      <input required type="file" class="form-control" id="attestationDoc" name="attestation_doc">
    </div>
    <div class="form-group col-md-4">
      <label for="memoireDoc">Document Memoire</label>
      <input required type="file" id="memoireDoc" class="form-control" name="memoire_doc">
    </div>
  </div>

  <div class="form-group" style="padding:20px 0px;">

      <button type="submit" class="btn btn-primary">Soummetre</button>
  </div>
  <script>
    
  </script>
</form>
@endsection
