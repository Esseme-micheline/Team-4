<?php

namespace App\Http\Controllers\EcoleDoctorat;
use Carbon\Carbon;
use App\Models\EcoleDoctorat\Theme;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        $unchecked_projects = Projets::where('is_valid', 0)->orderBy('created_at', 'desc')->get();
        $checked_valid = Projets::where('is_valid', 1)->orderBy('created_at', 'desc')->get();
        $checked_unvalid = Projets::where('is_valid', 2)->orderBy('created_at', 'desc')->get();
        $unvalid_resubmitted = Projets::where('is_valid', 3)->orderBy('created_at', 'desc')->get();
    
        return view('ecoleDoctorat.dossier.index', [
            'projets_count' => Projets::all()->count(),
            'unchecked_projects' => $unchecked_projects,
            'checked_valid' => $checked_valid,
            'checked_unvalid' => $checked_unvalid,
            'unvalid_resubmitted' => $unvalid_resubmitted
        ]);
    }
    
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
        $data['authors'] = $selectedDossier->chef_email;
        $data['comments'] = $request->comments;



        if($selectedDossier->is_valid == 1){
            $request->session()->flash('erreur',"Ce projet a deja ete valide!!");
            return redirect()->route('Ecole_Doctorat.dossier.index');
        }
        $selectedDossier->is_valid = 1;
        $selectedDossier->checked_by = Auth::user()->email;

        try {
            
            $pdfFile = PDF::loadView('email.reviewForm', compact('data'));
            $tab = explode(",", $selectedDossier->chef_email);
        
            foreach ($tab as $selected) {
                $selected = trim($selected);
                Mail::to($selected)->send(new CodeGenerated(null, "validated", $pdfFile));
            }
            $encadreur = explode(",",$selectedDossier->encadreur_email);
            foreach ($encadreur as $selected1) {
                $selected1 = trim($selected1);
                Mail::to($selected1)->send(new CodeGenerated(null, "validated", $pdfFile)); 
            }
        
        } catch (\Exception $e) {
            
            dd($e->getMessage());
        }
        
       
        $selectedDossier->save();

        $content = $pdfFile->download()->getOriginalContent();
        Storage::put("public/ReviewForms/$selectedDossier->theme/$selectedDossier->theme.pdf",$content);



        $request->session()->flash('success',"Le projet a ete valider et un Mail envoyer a L'etudiant");
        return redirect()->route('Ecole_Doctorat.dossier.index');

   }
    // public function rejeter($id, Request $request){
    //     $selectedDossier = Projets::where('id', $id)->first();
    
    //     $data = array();
    //     $data['originalite'] = $request->originalite;
    //     $data['presentation'] = $request->presentation;
    //     $data['applicabilite'] = $request->applicabilite;
    //     $data['rec'] = "Rejete";
    //     $data['theme'] = $selectedDossier->theme;
    //     $data['authors'] = $selectedDossier->chef_email;
    //     $data['comments'] = $request->comments;
    
    //     $selectedDossier->is_valid = 2;
    //     $selectedDossier->checked_by = Auth::user()->email;
    
    //     $matricule = $selectedDossier->chef_matricule;
    //     $randomString = Str::random(30);
    //     $verification_code = $matricule . '-' . $randomString;
    //     $selectedDossier->verification_code = $verification_code;

    //     $selectedDossier->save();
    
    //     // Generate PDF
    //     $pdfFile = PDF::loadView('email.reviewForm', compact('data'));
    
    //     // Send email to group members
    //     $membersEmails = explode(",", $selectedDossier->chef_email);
    //     foreach ($membersEmails as $memberEmail) {
    //         Mail::to(trim($memberEmail))->send(new CodeGenerated($verification_code, "rejected", $pdfFile));
    //     }
    
    //     // Send email to encadreur if email exists
    //     if (!empty($selectedDossier->encardreur_email)) {
    //         Mail::to(trim($selectedDossier->encardreur_email))->send(new CodeGenerated($verification_code, "rejected", $pdfFile));
    //     }
    
        
    //     $request->session()->flash('success', "Le projet a été rejeté et l'utilisateur notifié!");
    
    //     return redirect()->route('Ecole_Doctorat.dossier.index');
    // }
    
    public function rejeter($id,Request $request){
        $selectedDossier = Projets::where('id',$id)->first();

        $data = array();
        $data['originalite'] = $request->originalite;
        $data['presentation'] = $request->presentation;
        $data['applicabilite'] = $request->applicabilite;
        $data['rec'] = "Rejete";
        $data['theme'] = $selectedDossier->theme;
        $data['authors'] = $selectedDossier->chef_email;
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
        $tab = explode(",",$selectedDossier->chef_email);
        foreach ($tab as $selected) {
            $selected = trim($selected);
            Mail::to($selected)->send(new CodeGenerated($verification_code,"rejected",$pdfFile)); 
        }
        $encadreur = explode(",",$selectedDossier->encadreur_email);
        foreach ($encadreur as $selected1) {
            $selected1 = trim($selected1);
            Mail::to($selected1)->send(new CodeGenerated($verification_code,"rejected",$pdfFile)); 
        }
        

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
    // Exemple dans votre contrôleur

    public function index1()
    {
        return view('pages.index');
    }
    

    public function rejeterDossier($id)
    {
        // Récupérer les listes à partir de la vue retournée par la fonction index
        $viewData = $this->index(request(), [], []);
    
        // Extraire les listes de données
        $unchecked_projects = $viewData->getData()['unchecked_projects'] ?? [];
        $checked_unvalid = $viewData->getData()['checked_unvalid'] ?? [];
    
        // Retrouver le dossier soumis par son ID
        $dossier = null;
    
        foreach ($unchecked_projects as $key => $project) {
            if ($project->id == $id) {
                $dossier = $project;
        
                // Retirer le dossier de la liste des non valides
                unset($unchecked_projects[$key]);
        
                // Ajouter le dossier à la liste des rejetés
                $checked_unvalid[] = $dossier;
        
                // Marquer le dossier comme non valide (ou supprimez-le de votre base de données selon vos besoins)
                $dossier->update(['is_valid' => 2]); // 2 peut représenter l'état non valide, ajustez-le selon votre modèle
        
                // Attribuer la date et l'heure actuelles à la propriété created_at
                $project->created_at = Carbon::now();
        
                // Utilisez $project->created_at comme nécessaire dans votre code
        
                // Stocker les listes mises à jour dans la session
                Session::put('unchecked_projects', $unchecked_projects);
                Session::put('checked_unvalid', $checked_unvalid);
        
                // Rediriger vers la vue index avec les nouvelles listes
                return $this->index(request(), $unchecked_projects, $checked_unvalid);
                
            }
        }  
    }
    
    
    

    // ...
    
    public function supprimer($id)
    {
        $dossier = Projets::find($id);
    
        if (!$dossier) {
            return redirect()->back()->with('erreur', 'Dossier introuvable.');
        }
    
        $cheminFichier = public_path('upload/themes/') . $dossier->nom_fichier;
    
        if (file_exists($cheminFichier)) {
            unlink($cheminFichier);
        }
        $dossier->delete();
        return redirect()->back()->with('success', 'Dossier supprimé avec succès.');
    }
    



} 

    

