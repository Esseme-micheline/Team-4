<?php

namespace App\Http\Controllers\Visiteur;

use App\Models\Etudiant\Etudiant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visiteur\Projets;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class VisiteurController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//       $config = Config::get("global.langs");
    //    $config = config('global.constants.domaines');

    //     return $config;
        $projets = Projets::where('is_valid',1)->paginate(10);
        return view('visiteur.viewAllDocs')->with('projects',$projets);
    }
    public function getCate($domaine)
    {
        if(in_array($domaine,config('global.constants.domaines'))){
            $projets = Projets::where('is_valid',1)
                          ->where('domaine',$domaine)->get();
        return view('visiteur.viewAllByCategory')->with('projects',$projets);
        }
        return "The category does not exists";

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visiteur.submitDoc');
    }

    public function search()
    {
        return view('visiteur.search');
    }

    public function extractText()
    {
        return view('visiteur.memoireText')->with('pdfText', '');
    }

    public function aiSide(Request $request)
    {
    $projId = $request->input('projId');

    $selectedProject = Projets::find($projId);

    if (!$selectedProject) {
        return view('visiteur.aiSide')->with('selectedProject', null);
    }

    // return view('visiteur.aiSide')->with('selectedProject', $selectedProject);
    return view('visiteur.aiSide');
    
}

    


    public function searchResults(Request $request)
    {
        $searchTerm = $request->searchTerm;

    $results = Projets::where(function ($query) use ($searchTerm) {
        $query->where('theme', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('abstract', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('members', 'LIKE', '%' . $searchTerm . '%')
                ->where('is_valid',1)
              ;
        })->get();
        return view('visiteur.search')
            ->with('results',$results)
            ->with('oldTerm',$searchTerm);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new project instance
        $projet = new Projets();
    
        // Assign values to project attributes from the request data
        $projet->theme = $request->projet_theme;
        $projet->abstract = $request->projet_abstract;
        $projet->members = $request->members;
        $projet->domaine = $request->domaine;
        $projet->Type_projet = $request->typeProjet;
        $projet->mots = $request->mots;
        $projet->chef_email = $request->chefMail;
        $projet->encadreur_email = $request->emailEncadreur;
        $projet->encadreurs = $request->encadreurs;
    
        // Handle file uploads (memoire_doc) with PDF verification:
        $memoire_doc = $request->file('memoire_doc');
    
        // Verify that the uploaded file is a PDF
        if ($memoire_doc->getClientOriginalExtension() !== 'pdf') {
            return redirect()->back()->with('error', 'Le document doit être au format PDF.');
        }
    
        $memoire_doc_name = $memoire_doc->getClientOriginalName();
        $projet->memoire_path = $memoire_doc_name;
    
        // Move the file to the specified directory
        $memoire_doc->move(public_path("uploads/themes/{$projet->theme}/memoire"), $memoire_doc_name);
    
        $projet->lien = $request->lien_doc;
    
        // Check and validate matricules
        $matricules = explode(',', $request->verificationCode);
        $missingMatricules = [];
    
        foreach ($matricules as $matricule) {
            $matricule = trim($matricule);
            $matriculeExists = DB::table('etudiant')->where('matricule', $matricule)->exists();
            if (!$matriculeExists) {
                $missingMatricules[] = $matricule;
            }
        }
    
        if (!empty($missingMatricules)) {
            $errorMessage = 'Les matricules suivants ne sont pas présents dans la table étudiant : ' . implode(', ', $missingMatricules);
            return redirect()->back()->with('error', $errorMessage);
        }
    
        // Display success message
        $request->session()->flash('success', 'Votre document a été pris en compte, vous recevrez plus de détails par Mail.');
    
        // Send the email with the code
        // Mail::to($projet->chef_email)->send(new CodeGenerated($verification_code));
    
        // Save the project data and display success/error messages
        if ($projet->save()) {
            $request->flash("succes", "Document enregistré avec succès");
            return redirect()->route('visiteur.all');
        } else {
            return redirect()->back();
        }
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($projId,$memName)
    {
        $proj = Projets::where("id",$projId)->first();
        $path = public_path()."/uploads/themes/{$proj->theme}/memoire/$memName";

        $headers = array(
            'Content-Type: application/pdf',
          );

          return response()->download($path, $memName, $headers);

    }





    // ...
    

    
    public function extractSummaryAlgo($text, $maxSentences = 3)
    {
        // Tokenize the text into sentences
        $sentences = preg_split('/[.!?]/', $text, -1, PREG_SPLIT_NO_EMPTY);
    
        // Calculate the length of each sentence and store it in an associative array
        $sentenceLengths = array();
        foreach ($sentences as $sentence) {
            $sentenceLengths[$sentence] = strlen($sentence);
        }
    
        // Sort the sentences based on their length (from shortest to longest)
        asort($sentenceLengths);
    
        // Select the $maxSentences shortest sentences to form the summary
        $summarySentences = array_slice(array_keys($sentenceLengths), 0, $maxSentences);
    
        // Concatenate the summary sentences into a single string
        $summary = implode(' ', $summarySentences);
    
        // If the summary is too short, add more sentences to it
        while (Str::wordCount($summary) < 50 && $maxSentences < count($sentences)) {
            $maxSentences++;
            $summarySentences = array_slice(array_keys($sentenceLengths), 0, $maxSentences);
            $summary = implode(' ', $summarySentences);
        }
    
        return $summary;
    }
    
    

public function extractTextById($projId)
{
    $selectedProject = Projets::find($projId);

    if (!$selectedProject) {
        return view('visiteur.aiSide')->with('projectInfo', null)->with('error', 'Project not found');
    }

    $memoire_path = str_replace(['{', '}'], '', $selectedProject->memoire_path);
    $theme = str_replace(['{', '}'], '', $selectedProject->theme);
    $memoirePath = public_path("uploads\\themes\\{$theme}\\memoire\\{$memoire_path}");

    // dd($memoirePath);

    // if (!Storage::exists($memoirePath)) {
    //     return view('visiteur.aiSide')->with('projectInfo', null)->with('error', 'Memoire file not found');
    // }

    $parser = new Parser();
    $pdf = $parser->parseFile($memoirePath);

    // Extract text from each page of the PDF
    $pdfText = '';
    foreach ($pdf->getPages() as $page) {
        $pdfText .= $page->getText();
    }

    return $pdfText;
}





public function aiSearchMemoire(Request $request)
{
    $projId = $request->input('projId');

    // Retrieve project information based on the project ID
    $selectedProject = Projets::find($projId);

    if (!$selectedProject) {
        return view('visiteur.aiSide')->with('error', 'Project not found');
    }

    
    // Extract relevant information to display on the AI side
    $projectInfo = [
        'theme' => $selectedProject->theme,
        'abstract' => $selectedProject->abstract,
        'language' => $selectedProject->language,
        'author' => $selectedProject->members,
        'contact' => $selectedProject->chef_email,
        // Add other relevant project information here
    ];
    
    $pdfText = $this->extractTextById($projId);

    $summary = $this->extractSummaryAlgo($pdfText);

    return view('visiteur.aiSide')->with('projectInfo', $projectInfo)->with('pdfText', $pdfText)->with('summary', $summary);
    // return view('visiteur.aiSide')->with('projectInfo', $projectInfo);
}



public function extractMemoireText(Request $request)
{
    $projId = $request->input('projId');

    $selectedProject = Projets::find($projId);

    if (!$selectedProject) {
        return view('visiteur.memoireText')->with('pdfText', 'Memoire not found');
    }

  // Remove the braces {} from the theme and memoire paths

  $memoire_path = str_replace(['{', '}'], '', $selectedProject->memoire_path);
  $theme = str_replace(['{', '}'], '', $selectedProject->theme);
  $memoirePath =  public_path("uploads\\themes\\{$theme}\\memoire\\{$memoire_path}");

  // For debugging purposes, let's display the generated file path
//   dd($memoirePath);

    // if (!Storage::exists($memoirePath)) {
    //     return view('visiteur.memoireText')->with('pdfText', 'Memoire file not found');
    // }

    $parser = new Parser();
    $pdf = $parser->parseFile($memoirePath);

    // Extract text from each page of the PDF
    $pdfText = '';
    foreach ($pdf->getPages() as $page) {
        $pdfText .= $page->getText();
    }

    // Now you have the extracted text from the PDF memoire.
    // You can use it as needed, for example, display it in a view or process it further.

    return view('visiteur.memoireText')->with('pdfText', $pdfText);
}






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function single_project($id)
    {
        $theProject = Projets::find($id);
        $apiKey = env('OPENAI_API_KEY');
        if(!$theProject){
            return Redirect::route('visiteur.all');
        }
        return view('visiteur.singleProject')->with('selected',$theProject)->with('apikey',$apiKey);
    }

    public function createSecond(){
        return view('visiteur.submitSecondDoc');
    }

    public function storeSecond(Request $request){
        $selectedProj = Projets::where('verification_code',$request->codeFinale)->first();
        if($selectedProj){
            if($selectedProj->is_valid == 1){
                $request->session()->flash("erreur","Ce Projet a deja ete marque comme valide");
                return redirect()->route('visiteur.creerFinale');
            }
            else if($selectedProj->is_valid == 3){
                $request->session()->flash("erreur","Ce code a deja ete utilise");
                return redirect()->route('visiteur.creerFinale');
            }
            else if($selectedProj->is_valid == 2){
                if($request->hasFile('memoire_doc')){

                    $memoire_doc_name = $request->file('memoire_doc')->getClientOriginalName();
                    $selectedProj->memoire_path = $memoire_doc_name;
                    $request->file('memoire_doc')->move(public_path("uploads/themes/{$selectedProj->theme}/memoire/resoumission"), $memoire_doc_name);


                    $attestation_doc_name = $request->file('attestation_doc')->getClientOriginalName();
                    $selectedProj->attestation_path = $attestation_doc_name;
                    $request->file('attestation_doc')->move(public_path("uploads/themes/{$selectedProj->theme}/attestation/resoumission"), $attestation_doc_name);

                    $selectedProj->is_valid = 3;

                    if($selectedProj->save()){
                        $request->session()->flash("success","Vos documents ont ete resoumis avec succes!. vous receverez un mail quand l'administrateur verifie");
                        return redirect()->route('visiteur.creerFinale');

                    }
                    else redirect()->back();
                } else if($request->chefMat){
                    $request->session()->flash("success","Code Valide, Vous pouver maintenant resoumetre vos document");
                    return view('visiteur.submitSecondDoc')->with("codeCorrect",true)->with('verifiCode',$selectedProj->verification_code);
                }
            }

        }

        else{
            $request->session()->flash("erreur","Ce code est invalide");
            return redirect()->route('visiteur.creerFinale');
        }
    }
}
