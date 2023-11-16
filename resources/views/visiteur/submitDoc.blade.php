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
      <h1>{{ __("SOUMISSION") }}</h1> 
    </div><br>
    <div class="form-group">
      <label for="theme">{{ __("Thème") }}</label>
      <input required type="text" class="form-control" id="theme" placeholder="Votre Theme" name="projet_theme">
    </div><br>
    <div class="form-group">
      <label for="abstract">{{ __("Abstrait") }}</label>
      <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3"
      name="projet_abstract"
      ></textarea>
    </div>
  </div><br>
  <div class="row">
  <div class="form-group col-md-4">
      <label for="projectMembers">{{ __("Les membres du groupe") }}</label>
      <textarea required name="members" class="form-control" id="projectMembers" rows="3"
        placeholder="ex: Jhone Doe, Tristina Joe"
      ></textarea>
  </div>
  <div class="form-group col-md-4">
      <label for="domain">{{ __("Domaine") }}</label>
      <!-- <input type="text" class="form-control" placeholder="ex: Science / Technologie / Geography" id="domain" name="domaine"> -->
      <select required class="form-control" name="domaine" id="domaine">
        @foreach($domaines as $dom)
            <option value="{{$dom}}">{{$dom}}</option>
        @endforeach
      </select>
  </div>
  <div class="form-group col-md-4">
    <label for="type">Type du Projet</label>
    <div class="form-check">
  <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet" value="Professionnel">
  <label class="form-check-label" for="flexRadioDefault1">
    {{ __("Professionel") }}
  </label>
 </div>
 <div class="form-check">
  <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet" checked value="Recherche">
  <label class="form-check-label" for="flexRadioDefault2">
    {{ __("Recherche") }}
  </label>
 </div>
  </div>
  </div><br>

  <div class="row">
    <div class="form-group col-md-6">
      <label for="chefEmail">{{ __("Email du correspondant") }}</label>
      <input required type="email" class="form-control" id="chefEmail" name="chefMail">
    </div>
    
    <div class="form-group col-md-6">
      <label for="chefTelephone">{{ __("Telephone du correspondant") }}</label>
      <input required type="tel" class="form-control" id="chefTelephone" name="chefTel">
    </div>
  </div><br>

  <div class="row">
    <div class="form-group col-md-6">
      <label for="projectMembers">{{ __("Noms des l'encadreur") }}</label>
      <textarea required name="encardreurs" class="form-control" id="encardreurs" rows="3"
        placeholder="ex: Jhone Doe, Tristina Joe"
      ></textarea>
  </div>
    <div class="form-group col-md-4">
      <label for="emailEncadreur">{{ __("Email de l'encadreur") }}</label>
      <input required type="email" class="form-control" id="emailEncadreur" name="emailEncadreur">
    </div>
  </div>

  <div class="row">
    <p><h3>{{ __("Documents a soummetre") }}</h3></p>
    <div class="form-group col-md-4">
      <label for="memoireDoc">{{ __("Document Memoire") }}</label>
      <input required type="file" id="memoireDoc" class="form-control" name="memoire_doc">
    </div>
  </div>

  <div class="form-group" style="padding:20px 0px;">

      <button type="submit" class="btn btn-primary">{{ __("Soummetre") }}</button>
  </div>
  <script>
    
  </script>
</form>
@endsection
