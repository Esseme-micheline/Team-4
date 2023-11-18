@extends('layouts.visitor.body')
<?php
    $domaines = config('global.constants.domaines');
    $typeProjet = config('global.constants.typeProjet');
?>
@section('content')
<form method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-row">
    <div class="form-group" style="font-size: bold;">
      <h1>{{ __("SOUMISSION") }}</h1> 
    </div><br><br>
    <h1 style="font-size: 22px; font-style:italic; font-weight:bold;">{{ __("Detail du projet") }}</h1>
    <div>
      <div style="border: 2px solid; padding: 70px; box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 20px;">
          <div class="form-group">
              <label for="theme">{{ __("Thème") }}</label>
              <input required type="text" class="form-control" id="theme" placeholder="{{ __("Votre Theme") }}" name="projet_theme" style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid;" >
          </div><br>
          <div class="form-group">
              <label>{{ __("Abstrait") }}</label>
              <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3"
              name="projet_abstract"
              style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid"></textarea>
          </div><br><br>
          <div class="form-group col-md-4">
              <label for="">{{ __("Mots clés") }}</label>
              <textarea required name="mots" class="form-control" id="mots" rows="3"
                placeholder="ex: form, out"
                style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid; width:900px"></textarea>
          </div>
      </div>
  </div><br><br>
  
  <h1 style="font-size: 22px; font-style:italic; font-weight:bold;">{{ __("Detail des auteurs") }}</h1>
  <div style="border: 2px solid; padding: 70px; box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 20px;">
    <div class="row">
      <div class="row">
        <div class="col-md-6">
          <div>
            <div class="form-group col-md-12">
              <label for="projectMembers">{{ __("Les membres du groupe") }} <span style="color: red;">*</span></label>
              <textarea required name="members" class="form-control" id="projectMembers" rows="3"
                placeholder="ex: Jhone Doe, Tristina Joe"
                style="box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 10px;"></textarea>
            </div><br>
            <div class="form-group col-md-12">
              <label for="projectMembers">{{ __("Noms des encadreurs") }} <span style="color: red;">*</span></label>
              <textarea required name="encadreurs" class="form-control" id="encadreurs" rows="3"
                placeholder="ex: Jhone Doe, Tristina Joe"
                style="box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 10px;"></textarea>
            </div>
          </div>
        </div>
      
        <div class="col-md-6">
          <div>
            <div class="form-group col-md-12" style="height: 150px">
              <label for="chefEmail">{{ __("Email des membres du groupe") }} <span style="color: red;">*</span></label>
              <textarea required class="form-control" id="chefEmail" name="chefMail" placeholder="Ex : email1@example.com, email2@example.com" style="box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 5px;"></textarea>
            </div>
           
            <div class="form-group col-md-12">
              <label for="emailEncadreur">{{ __("Email des encadreurs") }} <span style="color: red;">*</span></label>
              <textarea required class="form-control" id="emailEncadreur" name="emailEncadreur" placeholder="Ex : email1@example.com, email2@example.com" style="box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 5px;"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div><br><br>
  </div><br><br>
  <div class="row">
    <h1 style="font-size: 22px; font-style:italic; font-weight:bold;">{{ __("Document(s)") }}</h1>
    <div style="border: 2px solid; padding: 70px; box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 20px;">
      <div class="col-md-12">
        {{-- <h3>{{ __("Documents à soumettre") }}</h3> --}}
        <table class="table table-bordered" id="table">
          <tr>
            <th style="font-size: 20px">{{ __("Mémoire") }}</th>
            <th>Action</th>
          </tr>
          <tr>
            <td><input required type="file" name="inputs[0][memoire]" placeholder="Choisir un Fichier" class="form-control"></td>
            <td><button type="button" name="addFile" id="addFile" class="btn btn-success">+</button></td>
          </tr>
        </table><br>
        <table class="table table-bordered" id="tables">
          <tr>
            <th style="font-size: 20px">{{ __("Lien(s)") }} <span style="font-size: 10px">{{ __("si aucun lien, laissez le champ vide") }}</span></th>
            <th>Action</th>
          </tr>
          <tr>
            <td><input type="text" name="inputsl[0][lien]" placeholder="{{ __("Documents à soumettre") }}" class="form-control"></td>
            <td><button type="button" name="addLien" id="addLien" class="btn btn-success">+</button></td>
          </tr>
        </table>
      </div>

      <div class="row" >
        <div class="form-group col-md-4">
          <label for="domain">{{ __("Domaine") }}</label>
          <select required class="form-control" name="domaine" id="domaine">
            @foreach($domaines as $dom)
                <option value="{{$dom}}">{{$dom}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="type">{{ __("Type du Projet") }}</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet" value="Professionnel">
            <label class="form-check-label" for="flexRadioDefault1">
              {{ __("Professionnel") }}
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
    </div>
  </div><br><br>
  
  <div class="row">
    <div class="col-md-4" style="margin-right: 400px;">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="agree" id="agreeCheck" required>
        <label class="form-check-label" for="agreeCheck">
          {{ __("Je suis d'accord avec les informations") }}<span style="color: red;">*</span></label>
        </label>
      </div>
    </div>
  
    <div class="col-md-4">
      <div class="form-group">
        <label for="verificationCode">Code de vérification<span style="color: red;">*</span></label></label>
        <textarea style="box-shadow: 2px 2px 4px rgb(70, 69, 69); border-radius: 10px;" class="form-control" id="verificationCode" name="verificationCode" placeholder="Ex : 21Q2324, 21T3546" required></textarea>
      </div>
    </div>
  </div>

  <div class="form-group" style="padding:20px 0px;">

      <button type="submit" class="btn btn-primary">{{ __("Soummetre") }}</button>
  </div>

</form>
@endsection
