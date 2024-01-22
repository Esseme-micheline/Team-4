@extends('layouts.visitor.body')
<?php
    $domaines = config('global.constants.domaines');
    $typeProjet = config('global.constants.typeProjet');
?>
@section('content')
<form method="POST" action="{{ route('visiteur.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
    @csrf
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
   @endif
  <div class="form-row">
    <div class="form-group" style="font-size: bold; color: #ff8400">
      <h1 style="font-size: 50px;">{{ __("SOUMISSION") }}</h1> 
    </div><br><br>
    <p style="font-weight: bold;">{{ __("Detail du projet") }}</p>
    <div>
      <div style="border: 2px solid white; padding: 70px; box-shadow: 2px 2px 4px rgb(189, 188, 188); margin-bottom: 40px;">
          <div class="form-group">
              <label for="theme">{{ __("Thème") }}</label>
              <input required type="text" class="form-control" id="theme" placeholder="{{ __("Votre Theme") }}" name="projet_theme" style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid gray;" >
          </div><br>
          <div class="form-group">
              <label>{{ __("Abstrait") }}</label>
              <textarea required class="form-control" id="exampleFormControlTextarea1" rows="3"
              name="projet_abstract"
              style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid gray"></textarea>
          </div><br>
          <div class="form-group col-md-4">
              <label for="">{{ __("Mots clés") }}</label>
              <textarea required name="mots" class="form-control" id="mots" rows="3"
                placeholder="ex: form, out"
                style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid gray; width:800px"></textarea>
          </div>
      </div>
  </div>
  
  <p style="font-weight: bold;">{{ __("Detail des auteurs") }}</p>
  <div style="border: 2px solid white; padding: 70px; box-shadow: 2px 2px 4px rgb(189, 188, 188); margin-bottom: 40px;">
    <div class="row">
      <div class="row">
        <div class="col-md-6">
          <div >
            <div class="form-group col-md-12">
              <label for="projectMembers">{{ __("Les membres du groupe") }} <span style="color: red;">*</span></label>
              <textarea required name="members" class="form-control" id="projectMembers" rows="3"
                placeholder="ex: Jhone Doe, Tristina Joe"
                style="box-shadow: 2px 2px 4px rgb(147, 146, 146); border: 2px solid gray;"></textarea>
            </div><br>
            <div class="form-group col-md-12">
              <label for="projectMembers">{{ __("Noms des encadreurs") }} <span style="color: red;">*</span></label>
              <textarea required name="encadreurs" class="form-control" id="encadreurs" rows="3"
                placeholder="ex: Jhone Doe, Tristina Joe"
                style="box-shadow: 2px 2px 4px rgb(147, 146, 146); border: 2px solid gray;"></textarea>
            </div>
          </div>
        </div>
      
        <div class="col-md-6">
          <div>
            <div class="form-group col-md-12" style="height: 140px">
              <label for="chefEmail">{{ __("Email des membres du groupe") }} <span style="color: red;">*</span></label>
              <textarea required class="form-control" id="chefEmail" name="chefMail" placeholder="Ex : email1@example.com, email2@example.com" style="box-shadow: 2px 2px 4px rgb(147, 146, 146); border: 2px solid gray; height:85px;"></textarea>
            </div>
           
            <div class="form-group col-md-12">
              <label for="emailEncadreur">{{ __("Email des encadreurs") }}</label>
              <textarea required class="form-control" id="emailEncadreur" name="emailEncadreur" placeholder="Ex : email1@example.com, email2@example.com" style="box-shadow: 2px 2px 4px rgb(147, 146, 146); border: 2px solid gray; height:85px;"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <p style="font-weight: bold;">{{ __("Document(s)") }}</p>
    <div style="border: 2px solid white; padding: 70px; box-shadow: 2px 2px 4px rgb(189, 188, 188); margin-bottom: 40px;">
      <div class="col-md-12">
        {{-- <h3>{{ __("Documents à soumettre") }}</h3> --}}
        <div class="form-group">
              <label for="theme">{{ __("Mémoire") }} <span style="color: red;">*</span></label>
              <input required type="file" class="form-control" id="memoire_doc" placeholder="{{ __("Choisir un Fichier") }}" name="memoire_doc" style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid gray;" >
          </div><br>
          <div class="form-group">
              <label for="theme">{{ __("Lien") }}</label>
              <input required type="text" class="form-control" id="lien_doc" placeholder="{{ __("Entrez un lien; ex: lien github") }}" name="lien_doc" style="border: none; box-shadow: none; border-radius: 0; border-bottom: 1px solid gray;" >
          </div><br>
          
        <!-- <table class="table table-bordered" id="table">
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
        </table> -->
      </div>

<div class="row">
  <div class="form-group col-md-12" style="margin-bottom: 40px">
    <label for="domain">{{ __("Domaine") }}<span style="color: red;">*</span></label>
    <select required class="form-control" name="domaine" id="domaine">
      @foreach($domaines as $dom)
          <option value="{{$dom}}">{{$dom}}</option>
      @endforeach
    </select>
  </div><br><br>
  <div class="form-group row">
  <label for="type" class="col-md-4 col-form-label">{{ __("Type du Projet") }} <span style="color: red;">*</span></label>
  <div class="col-md-4">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet1" value="Professionnel">
      <label class="form-check-label" for="typeProjet1">
        {{ __("Professionnel") }}
      </label>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet2" checked value="Recherche">
      <label class="form-check-label" for="typeProjet2">
        {{ __("Recherche") }}
      </label>
    </div>
  </div>
</div>
</div>
</div>
  {{-- <div class="form-group col-md-6">
    <label for="type" class="col-form-label">{{ __("Type du Projet : ") }}</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet1" value="Professionnel">
      <label class="form-check-label" for="typeProjet1">
        {{ __("Professionnel") }}
      </label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="typeProjet" id="typeProjet2" checked value="Recherche">
      <label class="form-check-label" for="typeProjet2">
        {{ __("Recherche") }}
      </label>
    </div>
  </div>
  </div>
</div> --}}
  
  
<div class="row">
    <div class="col-md-6" style="margin-right: 400px;">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="agree" id="agreeCheck" required>
        <label class="form-check-label" for="agreeCheck">
          {{ __("Je suis d'accord avec les informations") }}<span style="color: red;">*</span></label>
        </label>
      </div>
    </div><br><br>
  
    <div class="col-md-6">
      <div class="form-group">
        <label for="verificationCode">Code de vérification<span style="color: red;">*</span></label></label>
        <textarea style="box-shadow: 2px 2px 4px rgb(147, 146, 146);" class="form-control" id="verificationCode" name="verificationCode" placeholder="Ex : 21Q2324, 21T3546" required></textarea>
      </div>
    </div>
  </div>

  <div class="form-group" style="padding:20px 0px; margin-right: 750px;">

      <button type="submit" class="btn btn-primary" style= "margin-left: 90%;">{{ __("Soummetre") }}</button>
  </div>


{{-- <script>
  function validateForm() {
      
      // Validation des adresses e-mail des membres
      var membersEmail = document.getElementById("chefEmail").value;
      if (!validateEmails(membersEmail)) {
          alert("Veuillez entrer des adresses e-mail valides pour les membres.");
          return false; 
      }

      // Validation des adresses e-mail des encadreurs
      var encadreursEmail = document.getElementById("emailEncadreur").value;
      if (!validateEmails(encadreursEmail)) {
          alert("Veuillez entrer des adresses e-mail valides pour les encadreurs.");
          return false; 
      }

      return true; // Autoriser la soumission du formulaire
  }

  // Fonction pour valider les adresses e-mail séparées par des virgules
  function validateEmails(emails) {
      var emailArray = emails.split(",");
      for (var i = 0; i < emailArray.length; i++) {
          var email = emailArray[i].trim();
          if (!isValidEmail(email)) {
              return false;
          }
      }
      return true;
  }

  // Fonction pour valider une seule adresse e-mail
  function isValidEmail(email) {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
  }
</script> --}}

</form>
@endsection
