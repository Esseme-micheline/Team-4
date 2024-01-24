<?php

namespace App\Http\Controllers\EcoleDoctorat;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Visiteur\Projets;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeGenerated;
use Illuminate\Support\Facades\Storage;

use setasign\Fpdi\Fpdi; 
require_once(__DIR__ . '/../../../../vendor/autoload.php');
use Ilovepdf\Ilovepdf;
use TCPDF;

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
    public function show($id)
    {
        $selectedProject = Projets::where('id',$id)->first();

        return view('ecoleDoctorat.dossier.single',[
            'selectedProject'=>$selectedProject
        ]);
    }

    public function updateMemoirePdf($selectedProject)
    {
        set_time_limit(300);
        // Source file and watermark config 
            $file = "uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}"; 
            $text_image = "assets/img/te-sea-4.png"; 
            $text = 'Published by Te-sea publication'; 
            $newPdfPath = public_path("uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}_modified.pdf");
            
            // Set source PDF file 

            $name = uniqid(); 
            $font_size = 3; 
            $opacity = 100; 
            $ts = explode("\n", $text); 
            $width = 0; 
            foreach($ts as $k=>$string){ 
                $width = max($width, strlen($string)); 
            } 
            $width  = imagefontwidth($font_size)*$width; 
            $height = imagefontheight($font_size)*count($ts); 
            $el = imagefontheight($font_size); 
            $em = imagefontwidth($font_size); 
            $img = imagecreatetruecolor($width, $height); 

            $bg = imagecolorallocate($img, 255, 255, 255); 
            imagefilledrectangle($img, 0, 0, $width, $height, $bg); 
 
            // Font color settings 
            $color = imagecolorallocate($img, 0, 0, 0); 
            foreach($ts as $k=>$string){ 
                $len = strlen($string); 
                $ypos = 0; 
                for($i=0;$i<$len;$i++){ 
                    $xpos = $i * $em; 
                    $ypos = $k * $el; 
                    imagechar($img, $font_size, $xpos, $ypos, $string, $color); 
                    $string = substr($string, 1);       
                } 
            } 
            imagecolortransparent($img, $bg); 
            $blank = imagecreatetruecolor($width, $height); 
            $tbg = imagecolorallocate($blank, 255, 255, 255); 
            imagefilledrectangle($blank, 0, 0, $width, $height, $tbg); 
            imagecolortransparent($blank, $tbg); 
            $op = !empty($opacity)?$opacity:100; 
            if ( ($op < 0) OR ($op >100) ){ 
                $op = 100; 
            } 
            
            // Create watermark image 
            imagecopymerge($blank, $img, 0, 0, 0, 0, $width, $height, $op); 
            imagepng($blank, $name.".png"); 

            $pdf = new Fpdi(); 
            if(file_exists("./".$file)){ 
                $pagecount = $pdf->setSourceFile($file); 
            }else{ 
                die('Source PDF not found!'); 
            } 
            
            // Add watermark image to PDF pages 
            for($i=1;$i<=$pagecount;$i++){ 
                $tpl = $pdf->importPage($i); 
                $size = $pdf->getTemplateSize($tpl); 
                $pdf->addPage(); 
                $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 

                $xxx_final = ($size['width']-60); 
                $yyy_final = ($size['height']-8); 
                $pdf->Image($name.'.png', $xxx_final, $yyy_final, 0, 0, 'png'); 
                
                //Put the watermark 
                // list($imageWidth, $imageHeight) = getimagesize($text_image); // Obtenez les dimensions de l'image
                // $xxx_final = ($size['width'] - $imageWidth) / 2; // Position X pour centrer l'image horizontalement
                // $yyy_final = ($size['height'] - $imageHeight) / 2; // Position Y pour centrer l'image verticalement
                // $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
                $pdf->Image($text_image, 5, 5, 189); 
            } 
            @unlink($name.'.png');
            // Output PDF with watermark 
            $pdf->Output($newPdfPath, 'F');

            // Compress the PDF with watermark using ilovepdf API
            $ilovepdfPublicKey = "project_public_194707eee8c6bd80b6e1ff62702bcbe0_3d2wMd011adc7ecb22574c9c081e9f3552ade";
            $ilovepdfSecretKey = "secret_key_0b46389dbf04b99020e9d5b5a4a92162_5CkIwf291d5e2527adf6c45503ec294200819";

            $ilovepdf = new Ilovepdf($ilovepdfPublicKey, $ilovepdfSecretKey);

            $task = $ilovepdf->newTask('compress');
           
            $task->addFile($newPdfPath);

            $task->setOutputFilename('{filename}_compressed.pdf');

            $task->execute();
            // $task->setOutputFilename('{filename}_compressed');

            // $compressedPdfContent = $task->download();

    // Save the compressed PDF to a file
            $compressedPdfPath = public_path("uploads/themes/{$selectedProject->theme}/memoire/");
            $task->download($compressedPdfPath);
            // $task->getResult()->download( $compressedPdfPath);
            // file_put_contents($compressedPdfPath, $compressedPdfContent);

            // Update the database with the path to the compressed PDF
            $selectedProject->memoire_path = "{$selectedProject->memoire_path}_modified_compressed.pdf";
            $selectedProject->save();

            return $compressedPdfPath;

            // // Mettre à jour le chemin du fichier dans la base de données
            // $selectedProject->memoire_path = "{$selectedProject->memoire_path}_modified.pdf";
            // $selectedProject->save();
    
            // return $newPdfPath;
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
        
        $pdfPath = $this->updateMemoirePdf($selectedDossier);

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
}
