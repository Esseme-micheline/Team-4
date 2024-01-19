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
    //Str::random(number); To generate random unique code
    public function show($id)
    {
        $selectedProject = Projets::where('id',$id)->first();

        return view('ecoleDoctorat.dossier.single',[
            'selectedProject'=>$selectedProject
        ]);
    }



    // TOUJOURS MEME PACKAGE FONCTION FONCTIONNE TRES BIEN
    
    // public function updateMemoirePdf($selectedProject)
    // {
    //     $file = public_path("uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}");
    //     $newPdfPath = public_path("uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}_modified.pdf");
    
    //     if (file_exists($file)) {
    //         $pdf = new FPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
    
    //         // Ajouter chaque page du PDF original au nouveau PDF avec le filigrane et le tampon
    //         $pageCount = $pdf->setSourceFile($file);
    //         // Créer une nouvelle page avant la boucle
    //         $pdf->AddPage();
    //         for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
    //             // Importer la page du PDF d'origine
    //             $tplIdx = $pdf->importPage($pageNumber);
    //             $pdf->useTemplate($tplIdx, 0, 0, 210);
    
    //             // Ajouter le filigrane personnalisé (texte) en bas à droite
    //             $yPosition = $pdf->GetPageHeight() - 15; // Position verticale à partir du haut de la page
    //             $pdf->SetY($yPosition);
    //             $pdf->SetFont('helvetica', '', 10);
    //             $pdf->SetTextColor(192, 192, 192); // Couleur du texte en filigrane (gris clair)
    //             $pdf->Write(0, 'Published by Te-Sea Publication', '', false, 'R'); // Écriture alignée à droite
    
    //             // Ajouter le tampon personnalisé (image) en bas à droite
    //             $stampImage = public_path('assets/img/te-sea1.png'); // Chemin de l'image du tampon
    //             $pdf->Image($stampImage, 170, 275, 25, 0, 'PNG'); // Position du tampon en bas à droite
    
    //             if ($pageNumber < $pageCount) {
    //                 // Créer une nouvelle page avant la prochaine itération (sauf pour la dernière page)
    //                 $pdf->AddPage();
    //             }
    //         }
    
    //         // Enregistrer le nouveau PDF avec le filigrane et le tampon
    //         $pdf->Output($newPdfPath, 'F');
    
    //         // Mettre à jour le chemin du fichier dans la base de données
    //         $selectedProject->memoire_path = "{$selectedProject->memoire_path}_modified.pdf";
    //         $selectedProject->save();
    
    //         return $newPdfPath;
    //     } else {
    //         throw new \Exception('Source PDF not found!');
    //     }
    // }
    

    // FONCTION TEST POUR FILIGRANE DIAGONAL SUR LES PAGES DU PDF

    public function updateMemoirePdf($selectedProject)
    {
        // Source file and watermark config 
            $file = "uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}"; 
            $text_image = "assets/img/te-sea.png"; 
            $newPdfPath = public_path("uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}_modified.pdf");
            
            // Set source PDF file 
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
                
                //Put the watermark 
                // list($imageWidth, $imageHeight) = getimagesize($text_image); // Obtenez les dimensions de l'image
                // $xxx_final = ($size['width'] - $imageWidth) / 2; // Position X pour centrer l'image horizontalement
                // $yyy_final = ($size['height'] - $imageHeight) / 2; // Position Y pour centrer l'image verticalement
                // $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
                $pdf->Image($text_image, 5, 5, 189); 
            } 
            
            // Output PDF with watermark 
            $pdf->Output($newPdfPath, 'F');

            // Mettre à jour le chemin du fichier dans la base de données
            $selectedProject->memoire_path = "{$selectedProject->memoire_path}_modified.pdf";
            $selectedProject->save();
    
            return $newPdfPath;
    }

// Fonction qui fonctionne déja mais pas sur tout les pdf
// public function updateMemoirePdf($selectedProject)
// {
//         $file = "uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}";
//         // $text_image = public_path("assets/img/te-sea1.png");
//         $newPdfPath = "uploads/themes/{$selectedProject->theme}/memoire/{$selectedProject->memoire_path}_modified.pdf";
//         $text = 'Published by Te-sea publication'; 
 
//         // Text font settings 
//         $name = uniqid(); 
//         $font_size = 130; 
//         $opacity = 40; 
//         $ts = explode("\n", $text); 
//         $width = 0; 
//         foreach($ts as $k=>$string){ 
//             $width = max($width, strlen($string)); 
//         } 
//         $width  = imagefontwidth($font_size)*$width; 
//         $height = imagefontheight($font_size)*count($ts); 
//         $el = imagefontheight($font_size); 
//         $em = imagefontwidth($font_size); 
//         $img = imagecreatetruecolor($width, $height); 
        
//         // Background color 
//         $bg = imagecolorallocate($img, 255, 255, 255); 
//         imagefilledrectangle($img, 0, 0, $width, $height, $bg); 
        
//         // Font color settings 
//         $color = imagecolorallocate($img, 0, 0, 0); 
//         foreach($ts as $k=>$string){ 
//             $len = strlen($string); 
//             $ypos = 0; 
//             for($i=0;$i<$len;$i++){ 
//                 $xpos = $i * $em; 
//                 $ypos = $k * $el; 
//                 imagechar($img, $font_size, $xpos, $ypos, $string, $color); 
//                 $string = substr($string, 1);       
//             } 
//         } 
//         imagecolortransparent($img, $bg); 
//         $blank = imagecreatetruecolor($width, $height); 
//         $tbg = imagecolorallocate($blank, 255, 255, 255); 
//         imagefilledrectangle($blank, 0, 0, $width, $height, $tbg); 
//         imagecolortransparent($blank, $tbg); 
//         $op = !empty($opacity)?$opacity:100; 
//         if ( ($op < 0) OR ($op >100) ){ 
//             $op = 100; 
//         } 
        
//         // Create watermark image 
//         imagecopymerge($blank, $img, 0, 0, 0, 0, $width, $height, $op); 
//         imagepng($blank, $name.".png"); 
        
//         // Set source PDF file 
//         $pdf = new Fpdi(); 
//         if(file_exists("./".$file)){ 
//             $pagecount = $pdf->setSourceFile($file); 
//         }else{ 
//             die('Source PDF not found!'); 
//         } 
        
//         // Add watermark to PDF pages 
//         for($i=1;$i<=$pagecount;$i++){ 
//             $tpl = $pdf->importPage($i); 
//             $size = $pdf->getTemplateSize($tpl); 
//             $pdf->addPage(); 
//             $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
            
//             //Put the watermark
//             $angle = 45; // Rotation angle for diagonal placement
//             $xxx_final = ($size['width'] / 2); 
//             $yyy_final = ($size['height'] / 2); 
//             $pdf->Image($name.'.png', $xxx_final, $yyy_final, 0, 0, 'png'); 
//         } 
//         @unlink($name.'.png'); 
//         $pdf->Output($newPdfPath, 'F');

//         // Mettre à jour le chemin du fichier dans la base de données
//         $selectedProject->memoire_path = "{$selectedProject->memoire_path}_modified.pdf";
//         $selectedProject->save();

//         return $newPdfPath;
   
// }



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
        
        $pdfPath = $this->updateMemoirePdf($selectedDossier);

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
