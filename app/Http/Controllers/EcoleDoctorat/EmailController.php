<?php

namespace App\Http\Controllers\EcoleDoctorat;

use App\Mail\JuryMail;
use Illuminate\Http\Request;
use App\Models\EcoleDoctorat\Etat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\EcoleDoctorat\Dossier;
use App\Models\EcoleDoctorat\Evolution;

class EmailController extends Controller
{
    /*--construction de l'url hacher--*/
    public function index(Request $request, $id)
    {
        // dd($id);
        $dossier=Dossier::findOrFail($id);
        // dd($dossier);

        $urlPresident = $dossier->theme_recherche;
        $urlPresident .= $dossier->president_jury_id;

        $urlEncadreur =$dossier->theme_recherche;
        $urlEncadreur .= $dossier->encadreur_id;

        $urlExaminateur =$dossier->theme_recherche;
        $urlExaminateur .= $dossier->examinateur_jury_id;

        $urlPresident = Hash::make($urlPresident);
        $urlEncadreur = Hash::make($urlPresident);
        $urlExaminateur = Hash::make($urlPresident);

        $urlPresident = str_replace('/', '_', $urlPresident);
        $urlEncadreur = str_replace('/', '_', $urlEncadreur);
        $urlExaminateur = str_replace('/', '_', $urlExaminateur);

    //   $test=  Dossier::find($id)->update([

    //         'url_note_lecture_Pr' => $urlPresident,
    //         'url_note_lecture_En' => $urlEncadreur,
    //         'url_note_lecture_Ex' => $urlExaminateur
    //     ]);
    if($dossier->president_jury->email ==null){
        $request->session()->flash('email_null_pr', 'Vous n\'avez pas insérée d\'email au president du jury');
    }
    if($dossier->encadreur->email==null){
        $request->session()->flash('email_null_en', 'Vous n\'avez pas insérée d\'email à l\'encadreur');
    }
    if($dossier->examinateur_jury->email==null){
        $request->session()->flash('email_null_ex', 'Vous n\'avez pas insérée d\'email à l\'examinateur');
    }
    if(! $request->session()->has('email_null_pr') && ! $request->session()->has('email_null_en') && ! $request->session()->has('email_null_ex')){
            $test= DB::update('update dossiers set url_note_lecture_Pr = ?,
                                                        url_note_lecture_En = ?,
                                                        url_note_lecture_Ex = ?
                                                        where id = ?',
                                                        [$urlPresident, $urlEncadreur, $urlExaminateur, $id]);


                $this->envoieMail($id);
                $request->session()->flash('email_success', 'Les emails ont été envoyée aux jurys');
        }
        return redirect()->route('Ecole_Doctorat.dossier.index');
    }

    /*--Envoi des Email--*/
    public function envoieMail($id){
        // dd($id);

        $dossier = Dossier::findOrFail($id);

        // dd($dossier->documents[0]->documents);
        // 'url' => "/Ecole_Doctorat/noteEtudiant/".$dossier->url_note_lecture_Pr,
        $president = [
            'theme_recherche' => $dossier->theme_recherche,
            'url' => route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_Pr),
            'patch_mem'=>$dossier->documents[0]->documents,
        ];
        // 'url' => "/Ecole_Doctorat/noteEtudiant/".$dossier->url_note_lecture_En,
        $encadreur = [
            'theme_recherche' => $dossier->theme_recherche,
            'url' => route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_En),
            'patch_mem'=>$dossier->documents[0]->documents,
        ];

        $examinateur = [
            'theme_recherche' => $dossier->theme_recherche,
            'url' => route('Ecole_Doctorat.email.noterEtudiant', $dossier->url_note_lecture_Ex),
            'patch_mem'=>$dossier->documents[0]->documents,
        ];
        // dd($dossier->examinateur_jury->email);


            Mail::to($dossier->president_jury->email)->send(new JuryMail($president));

            Mail::to($dossier->encadreur->email)->send(new JuryMail($encadreur));

            Mail::to($dossier->examinateur_jury->email)->send(new JuryMail($examinateur));

            Dossier::where('id', $id)
                    ->update([
                        'status'=>5,
                    ]);
            $etat_id=Etat::insertGetId([
                'libelle'=>'Votre dossier a été envoyé aux membres du jurys'
            ]);
            Evolution::create([
                'acteur'=>"Administrateur",
                'etat_id'=>$etat_id,
                'etudiant_id'=>$dossier->etudiant_id,
                'objet'=>'Demande  d\'autorisation'
            ]);

    }

    /*--Affichage de formulaire pour noter--*/
    public function noterEtudiant($url){
        $president =  Dossier::where('url_note_lecture_Pr', $url)->get();
        $encadreur =  Dossier::where('url_note_lecture_En', $url)->get();
        $examinateur= Dossier::where('url_note_lecture_Ex', $url)->get();

        // dd($president);
        if(sizeof($president) != 0){

            return view('ecoleDoctorat.email.formulaireEtudiant', [
                'url'=>$url,
                'theme'=>$president[0]->theme_recherche
            ] );
        }

        if(sizeof($encadreur) != 0){
            return view('ecoleDoctorat.email.formulaireEtudiant', [
                'url'=>$url,
                'theme'=>$encadreur[0]->theme_recherche
            ] );
        }

        if(sizeof($examinateur) != 0){
            // dd($examinateur[0]->theme_recherche);
            return view('ecoleDoctorat.email.formulaireEtudiant',[
                'url'=>$url,
                'theme'=>$examinateur[0]->theme_recherche
            ]  );
        }

        abort(403);
        // return back();
    }

    /*--Insertion de la note et suppression de l'url--*/
    public function note(Request $request,$url ){
        $request->validate([
            'note'=>['required', 'max:20', 'min:10', 'integer'],
        ]);

        $president =  Dossier::where('url_note_lecture_Pr', $url)->get();
        $encadreur =  Dossier::where('url_note_lecture_En', $url)->get();
        $examinateur= Dossier::where('url_note_lecture_Ex', $url)->get();

        // dd($president);
        if(sizeof($president) != 0){
            $status=Dossier::find($president[0]->id)->status;
            $status=$status+1;
            Dossier::where('id', $president[0]->id)->update([
                'note_lecture_Pr' => $request->note,
                'url_note_lecture_Pr' => null,
                'status'=>$status

            ]);
            if($status==6){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>6,
                    'etudiant_id'=>$president[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==7){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>7,
                    'etudiant_id'=>$president[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==8){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>8,
                    'etudiant_id'=>$president[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }
        }

        if(sizeof($encadreur) != 0){
            $status=Dossier::find($encadreur[0]->id)->status;
            $status=$status+1;
            Dossier::where('id', $encadreur[0]->id)->update([
                'note_lecture_En' => $request->note,
                'url_note_lecture_En' => null,
                'status'=>$status
            ]);
            if($status==6){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>6,
                    'etudiant_id'=>$encadreur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==7){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>7,
                    'etudiant_id'=>$encadreur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==8){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>8,
                    'etudiant_id'=>$encadreur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }
        }

        if(sizeof($examinateur) != 0){
            $status=Dossier::find($examinateur[0]->id)->status;
            $status=$status+1;
            Dossier::where('id', $examinateur[0]->id)->update([
                'note_lecture_Ex' => $request->note,
                'url_note_lecture_Ex' => null,
                'status'=>$status
            ]);
            if($status==6){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>6,
                    'etudiant_id'=>$examinateur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==7){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>7,
                    'etudiant_id'=>$examinateur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }elseif($status==8){
                Evolution::create([
                    'acteur'=>"Administrateur",
                    'etat_id'=>8,
                    'etudiant_id'=>$examinateur[0]->etudiant_id,
                    'objet'=>'Demande  d\'autorisation'
                ]);
            }
        }

        return view('ecoleDoctorat.email.success');
    }

}
