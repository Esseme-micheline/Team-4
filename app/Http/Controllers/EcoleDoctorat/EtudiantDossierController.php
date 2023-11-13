<?php

namespace App\Http\Controllers\EcoleDoctorat;

use Illuminate\Http\Request;
use App\Models\EcoleDoctorat\Etat;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Archive;
use App\Models\EcoleDoctorat\Dossier;
use App\Models\EcoleDoctorat\Document;
use App\Models\EcoleDoctorat\Evolution;
use Illuminate\Support\Facades\Storage;
use App\Models\EcoleDoctorat\Changement;

class EtudiantDossierController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $dossier=Dossier::find($id);
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();

        $changements=Changement::where('dossier_id', $id)
                                ->where('etat', 0)->get();
        return view('ecoleDoctorat.etudiantDossier.index',[
            'changements'=>$changements,
            'dossier'=>$dossier,
            'dossier_nombre'=>$dossier_nombre,
            'dossier_nombre_1'=>$dossier_nombre_1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeRequete(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if($request->action=="valider"){
            $changement=Changement::find($request->changement);
            $dossier=$changement->dossier;
            $etudiant_id=$changement->dossier->etudiant_id;
            // dd($etudiant_id);
            $change_val=$request->change_val;
            if(count($request->change_val)>0){

                for($i=0; $i<count($request->change_val); $i++){
                    if($change_val[$i]==1){
                        $data_dossier['encadreur_id']=$changement->encadreur_id;
                        $data_changement['encadreur_id']=$dossier->encadreur_id;
                        $data_changement['etat']=1;
                    }elseif($change_val[$i]==2){
                        $data_dossier['coEncadreur_id']=$changement->coEncadreur_id;
                        $data_changement['coEncadreur_id']=$dossier->coEncadreur_id;
                        $data_changement['etat']=1;
                    }elseif($change_val[$i]==3){
                        $data_dossier['cooEncadreur_id']=$changement->cooEncadreur_id;
                        $data_changement['cooEncadreur_id']=$dossier->cooEncadreur_id;
                        $data_changement['etat']=1;
                    }elseif($change_val[$i]==4){
                        $data_dossier['theme_recherche']=$changement->theme;
                        $data_changement['theme']=$dossier->theme_recherche;
                        $data_changement['etat']=1;
                    }else{
                        return back();
                    }

                }
            }

            $data_dossier['status']=1;
            Dossier::where('id', $changement->dossier_id)
                        ->update($data_dossier);
            Changement::where('id', $request->changement)
                        ->update($data_changement);
            Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>4,
            'acteur'=>'Administrateur',
            'objet'=>'Demande de changement'
        ]);
            return back();

        }elseif($request->action=="rejeter"){
            Dossier::where('id', $changement->dossier_id)
                    ->update([
                        'status'=>1
                    ]);
            $changement=Changement::find($request->changement);
            $etudiant_id=$changement->dossier->etudiant_id;
            Evolution::create([
                'etudiant_id'=>$etudiant_id,
                'etat_id'=>3,
                'acteur'=>'Administrateur',
                'objet'=>'Demande de changement'
            ]);

            $changement->delete();
            return back();
            // dd($request->all());
            // dd('mauvais');
        }else{
            return back();
        }

    }
    // public function fichier(Request $request){
    //     $filename=time().'.'.$request->file->extension();
    //     $valeur=$request->file->storeAs('dossier', $filename, 'public');
    //     Document::create([
    //         'dossier_id'=>$request->id,
    //         'nature_id'=>2,
    //         'documents'=>$valeur,
    //     ]);
    //     dd($valeur);
    //     return view('test',[
    //         'docs'=>$val,
    //     ]);
    //    dd($request->all());
    // }
    public function storeDate(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'date'=>['required', 'date'],
        ]);
        // dd($request->dossier_id);
        $dossier=Dossier::find($request->dossier_id);
        $archive=$dossier->only('etudiant_id', 'encadreur_id', 'coEncadreur_id', 'cooEncadreur_id', 'filiere_id', 'niveau_id', 'unite_recherche_id', 'annee_id', 'president_jury_id', 'examinateur_jury_id', 'coexaminateur_jury_id', 'reference', 'theme_recherche', 'note_lecture_Pr', 'note_lecture_En', 'note_lecture_Ex', 'etat');
        $archive['observation']=$request->date;
        $archive_doc=DB::table('archives')->insertGetId($archive);
        $dossier=Archive::find($archive_doc);
        // dd($dossier);
        $date=$dossier->observation;
        $etudiant_id=$dossier->etudiant_id;
        Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>9,
            'acteur'=>'Administrateur',
            'objet'=>'Demande  d\'autorisation'
        ]);
        $docs=Document::where('dossier_id', $request->dossier_id)->get();
        foreach($docs as $doc){
            Storage::disk('public')->delete($doc->documents);
            // dd($doc->documents);
            // dd();
        }
        Dossier::where('id', $request->dossier_id)->delete();
        return redirect()->route('Ecole_Doctorat.dossier.index');
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function updateDoc($id){
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $dossier=Dossier::findOrFail($id);
        $etudiant_id=$dossier->etudiant_id;
        Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>4,
            'acteur'=>'Administrateur',
            'objet'=>'Demande  d\'autorisation'
        ]);
        Dossier::where('id', $id)
                    ->update([
                        'status'=>4
                    ]);
        Document::where('dossier_id', $id)->update(['etat'=>1]);
        return back();
    }
    public function destroy($id)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        Dossier::where('id', $id)
                    ->update([
                        'status'=>1
                    ]);
        $dossier=Dossier::findOrFail($id);
        $etudiant_id=$dossier->etudiant_id;
        $docs=Document::where('dossier_id', $id)->get();
        foreach($docs as $doc){
            Storage::disk('public')->delete($doc->documents);
            // dd($doc->documents);
            // dd();
        }
        // dd($doc);
        Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>3,
            'acteur'=>'Administrateur',
            'objet'=>'Demande  d\'autorisation'
        ]);
        Document::where('dossier_id', $id)->delete();
        return back();
    }
}
