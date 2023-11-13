<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Td;
use Illuminate\Http\Request;
use App\Models\Admin\ChargeTd;
use App\Models\Admin\GroupeTd;
use App\Imports\GroupeTDImport;
use App\Models\Admin\TdSpecial;
use App\Models\Admin\Attribution;
use App\Models\Etudiant\Etudiant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Etudiant\EtudiantGroupeTd;

class GestionGroupeTDController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function indexGroupeTd($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }
                // dd('ok');
                    if($data_ue_id !=null){
                        $tds=Td::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                }else{
                    abort(403);
                }
            }else{
                    abort(403);
                }
            $groupesTDs=GroupeTd::where('td_id', $id)->OrderBy('intitule')->paginate(50);
        }elseif(Gate::allows('chargeTD', Auth::user())){
            if(Auth::user()->charge_td->groupe_tds->count() > 0){
                // $groupesTDs=Auth::user()->charge_td->groupe_tds;
                $tds=null;
                foreach(Auth::user()->charge_td->groupe_tds as $groupeTD){
                    $data_td[]=$groupeTD->id;
                }
                // dd($data_td);
                $groupesTDs=GroupeTd::where('td_id', $id)->whereIn('id', $data_td)->OrderBy('intitule')->paginate(50);
                // dd($groupesTDs);
            }else{
                abort(403);
            }


        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $tds=Td::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
                $groupesTDs=GroupeTd::where('td_id', $id)->OrderBy('intitule')->paginate(50);
            }else{
                abort(403);
            }

        }
        else{
            $tds=Td::select('id', 'code')->OrderBy('code')->get();
            $groupesTDs=GroupeTd::where('td_id', $id)->OrderBy('intitule')->paginate(50);
        }


        return view('admin.gestionGroupTD.gestionGroupe.index',[
            'groupe_tds'=>$groupesTDs,
            'tds'=>$tds,
            'td_id'=>$id,
            'n'=>1,
            'groupe_i'=>1
        ]);
    }
    public function formImport($id){
        return view('admin.gestionGroupTD.gestionGroupe.formImport',[
            'id'=>$id,
            'groupe_i'=>1
        ]);
    }
    public function import(Request $request, $id){
        $request->validate([
            'id'=>['required'],
            'import'=>['required', 'file']]);
            (new GroupeTDImport($request->id))->import(request()->file('import'));
        return redirect()->route('Admin.GroupeTD.TD.index', $id);
    }
    public function indexGroupeTdSpecial($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // dd('ok');
        if(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }
                    if($data_ue_id !=null){
                        $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                }else{
                    abort(403);
                }
            }
            else{
                    abort(403);
                }
                $groupesTDs=GroupeTd::where('td_special_id', $id)->OrderBy('intitule')->get();
        }
        elseif(Gate::allows('chargeTD', Auth::user())){
            // dd('oks');
            if(Auth::user()->charge_td->groupe_tds->count() > 0){
                foreach(Auth::user()->charge_td->groupe_tds as $groupeTD){
                    $data_td_special[]=$groupeTD->id;
                }
                $groupesTDs=GroupeTd::where('td_special_id', $id)->whereIn('id', $data_td_special)->OrderBy('intitule')->paginate(50);
                $td_specials=null;
            }else{
                abort(403);
            }


        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
                $groupesTDs=GroupeTd::where('td_special_id', $id)->OrderBy('intitule')->paginate(50);
            }else{
                abort(403);
            }

        }
        else{
            $td_specials=TdSpecial::select('id', 'code')->OrderBy('code')->get();
            $groupesTDs=GroupeTd::where('td_special_id', $id)->OrderBy('intitule')->paginate(50);
        }
        return view('admin.gestionGroupTD.gestionGroupe.index',[
            'groupe_tds'=>$groupesTDs,
            'td_specials'=>$td_specials,
            'tdSpecial_id'=>$id,
            'n'=>1,
            'groupe_i'=>1
        ]);

    }
    public function voir($id){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        return view('admin.gestionGroupTD.gestionGroupe.voir',[
            'id'=>$id,
            'groupe_i'=>1
        ]);
    }
    public function showEtudiant($id){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
//         $fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
// asort($fruits);
//         dd($fruits);
        $groupeTD_name=GroupeTd::find($id)->intitule;
        $etudiants_groupes_tds=EtudiantGroupeTd::where('groupe_td_id', $id)->get();
        if($etudiants_groupes_tds->count()>0){
            foreach($etudiants_groupes_tds as $etudiants_groupes_td){
                $data_etudiant[]=['noms'=>$etudiants_groupes_td->etudiant['noms'],
                                'matricule'=>$etudiants_groupes_td->etudiant['matricule'],
                                 'id'=>$etudiants_groupes_td->id,
                                 'etudiant_id'=>$etudiants_groupes_td->etudiant_id];
                // dd($etudiants_groupes_td->etudiant['noms']);
            }
            asort($data_etudiant);
            // dd($data_etudiant);
        }else{
            $data_etudiant=null;
        }
        // dd($data_etudiant);
        // foreach($data_etudiant as $etudiant){
        //     dd($etudiant['matricule']);
        // }
        return view('admin.gestionGroupTD.gestionGroupe.etudiant',[
            'etudiants_groupes_tds_count'=>$etudiants_groupes_tds,
            'etudiants_groupes_tds'=>$data_etudiant,
            'n'=>1,
            'groupe_td_nom'=>$groupeTD_name,
            'groupe_i'=>1,
            'id'=>$id
        ]);
    }
    public function unsubscribeEtudiant($id){
        $id=(int)$id;
        $etudiants_groupes_td=EtudiantGroupeTd::find($id);
        // dd($etudiants_groupes_td);
        $etudiants_groupes_td->delete();
        return back();
    }
    public function showEtudiantOne($id){
        $id=(int)$id;
        $etudiant=Etudiant::select('matricule', 'noms', 'telephone', 'email')->where('id', $id)->get();
        return response()->json($etudiant);
    }

    public function createGroupeTd($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }
                    if($data_ue_id !=null){
                        $tds=Td::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                }else{
                    abort(403);
                }
            }else{
                    abort(403);
                }
        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $tds=Td::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
            }else{
                abort(403);
            }

        }
        else{
            $tds=Td::select('id', 'code')->OrderBy('code')->get();
        }
        $td=Td::find($id)->code;
        $td_nom=$td.'_Groupe_I';
        $chargeTds=ChargeTd::select('id', 'noms')->OrderBy('noms')->get();
        // dd($td);
        return view('admin.gestionGroupTD.gestionGroupe.create',[
            'tds'=>$tds,
            'td_id'=>$id,
            'groupe_i'=>1,
            'td_nom'=>$td_nom,
            'charge_tds'=>$chargeTds
        ]);
    }
    public function createGroupeTdSpeciale($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }
                    if($data_ue_id !=null){
                        $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                }else{
                    abort(403);
                }
            }else{
                    abort(403);
                }
        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
            }else{
                abort(403);
            }

        }
        else{
            $td_specials=TdSpecial::select('id', 'code')->OrderBy('code')->get();
        }
        $chargeTds=ChargeTd::select('id', 'noms')->OrderBy('noms')->get();
        $td=TdSpecial::find($id)->code;
        $td_nom=$td.'_Groupe_I';
        return view('admin.gestionGroupTD.gestionGroupe.create',[
            'td_specials'=>$td_specials,
            'tdSpecial_id'=>$id,
            'groupe_i'=>1,
            'charge_tds'=>$chargeTds,
            'td_nom'=>$td_nom
        ]);
    }

    public function storeGroupeTd(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $request->validate([
            'intitule'=>['required', 'max:100', 'min:3', 'unique:groupe_tds'],
            'td_id'=>['required', 'integer'],
            'charge_td_id'=>['required'],
            'salle'=>['required'],
            'capacite'=>['required'],
            'jour'=>['required'],
            'heureDebut'=>['required'],
            'heureFin'=>['required']
        ]);
        $periode=$request->jour.' '.$request->heureDebut.'-'.$request->heureFin;
        // dd($periode);
        // 'unique:groupe_tds'
        $data= $request->only('intitule','charge_td_id', 'td_id', 'salle', 'capacite');
        $data['periode']=$periode;
        GroupeTd::create($data);
        return redirect()->route('Admin.GroupeTD.TD.index', $request->td_id);

    }
    public function storeGroupeTdSpeciale(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $request->validate([
            'intitule'=>['required', 'max:100', 'min:3', 'unique:groupe_tds'],
            'td_special_id'=>['required', 'integer'],
            'charge_td_id'=>['required'],
            'salle'=>['required'],
            'capacite'=>['required'],
            'jour'=>['required'],
            'heureDebut'=>['required'],
            'heureFin'=>['required']
        ]);
        $periode=$request->jour.' '.$request->heureDebut.'-'.$request->heureFin;
        // dd($periode);
        // 'unique:groupe_tds'
        $data= $request->only('charge_td_id', 'intitule', 'td_special_id', 'charge_td_id', 'salle', 'capacite');
        $data['periode']=$periode;
        // dd($data);
        GroupeTd::create($data);
        return redirect()->route('Admin.GroupeTD.TDSpeciale.index', $request->td_special_id);
    }

    public function show(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // dd($request);
            if(!isset($request->td_id) && !isset($request->td_special_id)){
                // dd($request);
                return back();
            }elseif(isset($request->td_id)){
                return redirect()->route('Admin.GroupeTD.TD.index', $request->td_id);
            }elseif(isset($request->td_special_id)){
                return redirect()->route('Admin.GroupeTD.TDSpeciale.index', $request->td_special_id);
            }
    }


    public function edit(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $groupeTD=GroupeTd::find($request->id);
        return response()->json($groupeTD);
    }


    public function update(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        GroupeTd::where('id', $request->id)
                ->update([
                    'intitule'=>$request->intitule,
                    'periode'=>$request->periode,
                    'capacite'=>$request->capacite,
                    'salle'=>$request->salle,

                ]);
        $groupeTD=GroupeTd::find($request->id);
        return response()->json($groupeTD);
    }


    public function destroy($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $td= GroupeTd::findOrFail($id);
        $td->delete();
        return back();
    }
}
