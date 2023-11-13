<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Etudiant\Requete;
use App\Models\Admin\Attribution;
use App\Models\EcoleDoctorat\Etat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Evolution;
use Illuminate\Support\Facades\Storage;

class RequeteController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\reponse
     */
    public function index()
    {
        // dd(Gate::allows('doyen_Ecole', Auth::user()));
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::select('ue_id')->where('enseignant_id', Auth::user()->enseignant['id'])->get();

            if($attributions->count() > 0){
                // dd($attributions);
                foreach($attributions as $attribution){
                    $ue_id[]=$attribution->ue_id;
                }
                // dd($ue_id);
            }
            if(isset($ue_id)){
                // dd('ok');
                $requetes=Requete::where('statut', 0)->whereIn('ue_id', $ue_id)->paginate(50);
            }else{
                $requetes=null;
            }
        }elseif(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){

            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }

            }
            if(isset($data_ue_id)){
                // dd($data_ue_id);
                $requetes=Requete::where('statut', 0)
                            ->whereIn('ue_id', $data_ue_id)
                            ->paginate(50);
                // dd('hul');

            }else{
                $requetes=null;
            }
         }
        else{

            $requetes=Requete::where('statut', 0)->paginate(50);
        }
        return view('admin.requete.index',[
            'requetes'=>$requetes,
            'n'=>1,
            'requete_i'=>1
        ]);
    }
    // public function fichier(Request $request){
    //     // dd($request->all());
    //     $filename=time().'.'.$request->file->extension();
    //     $valeur=$request->file->storeAs('dossier', $filename, 'public');
    //     Requete::where('id', $request->id)
    //         ->update([
    //         'document'=>$valeur,
    //     ]);
    //     dd($valeur);
    //     return view('test',[
    //         'docs'=>$val,
    //     ]);
    //    dd($request->all());
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\reponse
     */
    public function voir($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) && Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $requete=Requete::find($id);
        return view('admin.requete.voir',[
            'requete'=>$requete,
            'requete_i'=>1
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\reponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\reponse
     */
    public function edit($id)
    {
        // {{ route('Admin.user.index') }}
        //
    }


    public function update(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) && Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if($request->action=='valider'){
            Requete::where('id', $request->id)
                    ->update([
                        'reponse'=>$request->reponse,
                        'statut'=>1
                    ]);
            $etudiant_id=Requete::find($request->id)->etudiant['id'];
            if($request->reponse !=null){
                $etat_id=Etat::insertGetId([
                        'libelle'=>$request->reponse,
                        ]);
                Evolution::create([
                        'etudiant_id'=>$etudiant_id,
                        'etat_id'=>$etat_id,
                        'objet'=>'Requete',
                        'acteur'=>'Administrateur'
                    ]);
            }else{
                Evolution::create([
                    'etudiant_id'=>$etudiant_id,
                    'etat_id'=>4,
                    'objet'=>'Requete',
                    'acteur'=>'Administrateur'
                ]);
            }
            // return back();
        }elseif($request->action=='rejeter'){
            $etudiant_id=Requete::find($request->id)->etudiant['id'];
            if($request->reponse !=null){
                $etat_id=Etat::insertGetId([
                        'libelle'=>$request->reponse,
                        ]);
                Evolution::create([
                    'etudiant_id'=>$etudiant_id,
                    'etat_id'=>$etat_id,
                    'objet'=>'Requete',
                    'acteur'=>'Administrateur'
                ]);

            }else{
                Evolution::create([
                    'etudiant_id'=>$etudiant_id,
                    'etat_id'=>3,
                    'objet'=>'Requete',
                    'acteur'=>'Administrateur'
                ]);
            }
            $requete=Requete::find($request->id);
            Storage::disk('public')->delete($requete->document);
            Requete::where('id', $request->id)->delete();
            return redirect()->route('Admin.requete.index');

        }else{
            return back();
        }
        return redirect()->route('Admin.requete.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\reponse
     */
    public function destroy($id)
    {
        //
    }
}
