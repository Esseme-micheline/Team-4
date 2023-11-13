<?php

?>
@extends('layouts.visitor.body')
@section('content')
        @if (session('success'))
            <div class="alert alert-success">
                <p>{{session('success')}}</p>
            </div>
        @elseif(session('erreur'))
            <div class="alert alert-danger">
                <p>{{session('erreur')}}</p>
            </div>
        @endif
<form method="POST" enctype="multipart/form-data">
    @csrf
  <!-- <div class="row"> -->
    @if(!isset($codeCorrect))
  <div class="row">
    <div class="form-group col-md-6">
      <label for="chefMat">Matricule du chef du projet</label>
      <input required type="text" class="form-control" id="chefMat" name="chefMat">
    </div>
    <div class="form-group col-md-6">
      <label for="chefEmail">Email du chef</label>
      <input required type="email" class="form-control" id="chefEmail" name="chefMail">
    </div>
    <div class="form-group col-md-6">
      <label for="codeFinale">Code de soumission</label>
      <input required type="text" class="form-control" id="codeFinale" name="codeFinale">
    </div>
  </div>
  @endif

  <!-- <div class="row"> -->
  @if(isset($codeCorrect))
  <div class="row">
  @if(isset($verifiCode))
            {{$verifiCode}}
        @endif
    <p><h3>Documents a soummetre</h3></p>
    <div class="form-group col-md-4">
      <label for="attestationDoc">Attestation de soutenance</label>
      <input required type="file" class="form-control" id="attestationDoc" name="attestation_doc">
    </div>
    <div class="form-group col-md-4">
      <label for="memoireDoc">Document Memoire</label>
      <input required type="file" id="memoireDoc" class="form-control" name="memoire_doc">
    </div>
    <div class="form-group col-md-4">
      <label for="inscriptionDoc">Fiche d'inscription</label>
      <input required type="file" class="form-control"  id="inscriptionDoc" name="inscription-doc">
    </div>
            <input type="text" value="<?php echo $verifiCode ?>" name="codeFinale" id="codeFinale" hidden>
  </div>
  @endif

  <div class="form-group" style="padding:20px 0px;">

      <button type="submit" class="btn btn-primary">
        @if(isset($codeCorrect))
            Soummetre
        @else
            Verifier mon Code
        @endif
      </button>
  </div>
</form>
@endsection
