<?php

namespace App\Http\Controllers\EcoleDoctorat;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Visiteur\Projets;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeGenerated;
use Illuminate\Support\Facades\Storage;


class DossierController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index(Request $request)
    {
        $unchecked_projects= Projets::where('is_valid',0)->get();
        $checked_valid= Projets::where('is_valid',1)->get();
        $checked_unvalid= Projets::where('is_valid',2)->get();
        $unvalid_resubmitted = Projets::where('is_valid',3)->get();

        return view('ecoleDoctorat.dossier.index',[
            'projets_count'=>Projets::all()->count(),
            'unchecked_projects'=>$unchecked_projects,
            'checked_valid'=>$checked_valid,
            'checked_unvalid'=>$checked_unvalid,
            'unvalid_resubmitted'=>$unvalid_resubmitted
        ]);
        //The view fot this is found in dossier/index.blade.php
    }
    //Str::random(number); To generate random unique code
    public function show($id)
    {
        $selectedProject = Projets::where('id',$id)->first();

        return view('ecoleDoctorat.dossier.single',[
            'selectedProject'=>$selectedProject
        ]);
    }
    public function valider($id, Request $request){
        $selectedDossier = Projets::where('id',$id)->first();

        $data = array();
        $data['originalite'] = $request->originalite;
        $data['presentation'] = $request->presentation;
        $data['applicabilite'] = $request->applicabilite;
        $data['rec'] = $request->rec;
        $data['theme'] = $selectedDossier->theme;
        $data['authors'] = $selectedDossier->members;
        $data['comments'] = $request->comments;



        if($selectedDossier->is_valid == 1){
            $request->session()->flash('erreur',"Ce projet a deja ete valide!!");
            return redirect()->route('Ecole_Doctorat.dossier.index');
        }
        $selectedDossier->is_valid = 1;
        $selectedDossier->checked_by = Auth::user()->email;

        $pdfFile = PDF::loadView('email.reviewForm',compact('data'));
        Mail::to($selectedDossier->chef_email)
        ->send(new CodeGenerated(null,"validated",$pdfFile));
        $selectedDossier->save();

        $content = $pdfFile->download()->getOriginalContent();
        Storage::put("public/ReviewForms/$selectedDossier->theme/$selectedDossier->theme.pdf",$content);



        $request->session()->flash('success',"Le projet a ete valider et un Mail envoyer a L'etudiant");
        return redirect()->route('Ecole_Doctorat.dossier.index');

    }
    public function rejeter($id,Request $request){
        $selectedDossier = Projets::where('id',$id)->first();

        $data = array();
        $data['originalite'] = $request->originalite;
        $data['presentation'] = $request->presentation;
        $data['applicabilite'] = $request->applicabilite;
        $data['rec'] = "Rejete";
        $data['theme'] = $selectedDossier->theme;
        $data['authors'] = $selectedDossier->members;
        $data['comments'] = $request->comments;

        $selectedDossier->is_valid = 2;
        $selectedDossier->checked_by = Auth::user()->email;

        //Code generation block
        $matricule = $selectedDossier->chef_matricule;
        $randomString = Str::random(30);
        $verification_code = $matricule . '-' . $randomString;
        $selectedDossier->verification_code = $verification_code;
        $selectedDossier->save();

        $pdfFile = PDF::loadView('email.reviewForm',compact('data'));
        Mail::to($selectedDossier->chef_email)
        ->send(new CodeGenerated($verification_code,"rejected",$pdfFile));

        $selectedDossier->save();
        //##################

        // Mail::to($selectedDossier->chef_email)->send(new CodeGenerated($verification_code,"rejected"));


        $request->session()->flash('success',"Le projet a ete rejeter et l'utilisateur notifie!");

        return redirect()->route('Ecole_Doctorat.dossier.index');
    }
    // public function links($filiere_id, $niveau_id, $status){

    // }
    public function shwDoss(Request $request){
        // if()
    }

    public function create()
    {
        //
    }
    public function jury_P(Request $request){

    }
    public function update(Request $request)
    {

    }
    // Formulaire pour editer le theme
    public function edit($id)
    {

    }
    public function update_theme(Request $request){

    }

    public function destroy($id, $valeur)
    {

    }
}
