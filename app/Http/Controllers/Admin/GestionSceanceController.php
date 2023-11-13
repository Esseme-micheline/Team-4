<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Td;
use Illuminate\Http\Request;
use App\Models\Admin\ChargeTd;
use App\Models\Admin\GroupeTd;
use App\Models\Admin\SceanceTd;
use App\Models\Admin\TdSpecial;
use App\Models\Admin\Attribution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionSceanceController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
        // if(! Gate::allows('super_admin', Auth::user()) || ! Gate::allows('chef_Dept', Auth::user()) || ! Gate::allows('enseignant', Auth::user()) || ! Gate::allows('secretaire', Auth::user())){
        //     abort(403);
        // }
    }
    public function index($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        $sceance_tds=SceanceTd::where('groupe_td_id', $id)->orderBy('intitule')->paginate(50);
        $td_nom=GroupeTd::find($id)->td_special_id;
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
                            $tds=Td::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                            foreach($td_specials as $td_special){
                                $data_td_special[]=$td_special->id;
                            }
                            foreach($tds as $td){
                                $data_td[]=$td->id;
                            }
                }else{
                    abort(403);
                }
            }

            if($td_nom==null){

                $isTdSpecial=false;
                $groupe_tds=GroupeTd::select('id', 'intitule')->whereIn('td_id', $data_td)->OrderBy('intitule')->get();
            }else{
                $groupe_tds=GroupeTd::select('id', 'intitule')->whereIn('td_special_id', $data_td_special)->OrderBy('intitule')->get();
                $isTdSpecial=true;
            }
        }else{
            if($td_nom==null){
                $isTdSpecial=false;
                $groupe_tds=DB::table('groupe_tds')->select('id', 'intitule')->where('td_id', '<>', 'null')->OrderBy('intitule')->get();
            }else{
                $groupe_tds=DB::table('groupe_tds')->select('id', 'intitule')->where('td_special_id', '<>', 'null')->OrderBy('intitule')->get();
                $isTdSpecial=true;
            }
        }

        return view('admin.gestionSceanceTD.index',[
            'groupe_tds'=>$groupe_tds,
            'sceance_tds'=>$sceance_tds,
            'isTdSpecial'=>$isTdSpecial,
            'n'=>1,
            'groupe_td_id'=>$id,
            'groupe_i'=>1
        ]);
    }


    public function create($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        if(Gate::allows('chargeTD', Auth::user())){
            $groupe_tds=GroupeTd::select('id', 'intitule')->where('charge_td_id', Auth::user()->charge_td->id)->OrderBy('intitule')->get();
            $groupe_tdSpecials=null;
        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->get();
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
                $tds=Td::select('id', 'code')->whereIn('ue_id', $data)->OrderBy('code')->get();
                foreach($td_specials as $td_special){
                    $data_td_special[]=$td_special->id;
                }
                foreach($tds as $td){
                    $data_td[]=$td->id;
                }
                // dd($data_td);
                $groupe_tds=GroupeTd::whereIn('td_id', $data_td)->OrderBy('intitule')->get();
                $groupe_tdSpecials=GroupeTd::whereIn('td_special_id', $data_td_special)->OrderBy('intitule')->get();
                // dd($groupe_tdSpecials);
            }else{
                abort(403);
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
                    if($data_ue_id !=null){
                            $td_specials=TdSpecial::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                            $tds=Td::select('id', 'code')->whereIn('ue_id', $data_ue_id)->OrderBy('code')->get();
                            foreach($td_specials as $td_special){
                                $data_td_special[]=$td_special->id;
                            }
                            foreach($tds as $td){
                                $data_td[]=$td->id;
                            }
                            // dd($data_td);
                            $groupe_tds=GroupeTd::whereIn('td_id', $data_td)->OrderBy('intitule')->get();
                            $groupe_tdSpecials=GroupeTd::whereIn('td_special_id', $data_td_special)->OrderBy('intitule')->get();
                }else{
                    abort(403);
                }
            }
            else{
                    abort(403);
                }
                // $groupesTDs=GroupeTd::where('td_special_id', $id)->OrderBy('intitule')->get();
        }
        else{

            $groupe_tds=GroupeTd::select('id', 'intitule')->OrderBy('intitule')->get();
            $groupe_tdSpecials=null;
        }
        $td=GroupeTd::find($id)->td_special_id;
        if($td==null){
            $isTdSpecial=false;

        }else{

            $isTdSpecial=true;
        }
        return view('admin.gestionSceanceTD.create',[
            'groupe_tds'=>$groupe_tds,
            'groupe_tdSpecials'=>$groupe_tdSpecials,
            'isTdSpecial'=>$isTdSpecial,
            'groupe_td_id'=>$id,
            'groupe_i'=>1
        ]);
    }

    public function store(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // dd('ojj');
        // il y a encore des verification a encore a faire
        $request->validate([
            'groupe_td_id'=>['required', 'integer'],
            'description'=>['required', 'min:3',],
            'date'=>['date','required'],
            'heureDebut'=>['required'],
            'heureFin'=>['required'],
            'salle'=>['required', 'max:20']
        ]);
        $groupe_td=GroupeTd::find($request->groupe_td_id)->intitule;
        $intitule=$groupe_td.'_'.$request->date;
        // dd($intitule);
        $data= $request->only('groupe_td_id', 'capacite', 'description', 'date', 'heureDebut', 'heureFin', 'salle');
        $data['intitule']=$intitule;
        // dd($data);
        SceanceTd::create($data);
        return redirect()->route('Admin.sceanceTd.index', $request->groupe_td_id);
    }


    public function show(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if($request->groupe_td_id !=null && $request->charge_td_id !=null){
            $sceance_tds=SceanceTd::where('groupe_td_id', $request->groupe_td_id)
                                    ->where('charge_td_id', $request->charge_td_id)->orderBy('intitule')->paginate(50);

        $charge_tds=ChargeTd::select('id', 'noms')->orderBy('noms')->get();
        $td=GroupeTd::find($request->groupe_td_id)->td_special_id;
        if($td==null){
            $isTdSpecial=false;
            $groupe_tds=DB::table('groupe_tds')->select('id', 'intitule')->where('td_id', '<>', 'null')->OrderBy('intitule')->get();
        }else{
            $groupe_tds=DB::table('groupe_tds')->select('id', 'intitule')->where('td_special_id', '<>', 'null')->OrderBy('intitule')->get();
            $isTdSpecial=true;
        }
        $charge_td_id=$request->charge_td_id;
        return view('admin.gestionSceanceTD.index',[
            'charge_tds'=>$charge_tds,
            'groupe_tds'=>$groupe_tds,
            'sceance_tds'=>$sceance_tds,
            'isTdSpecial'=>$isTdSpecial,
            'n'=>1,
            'groupe_td_id'=>$request->groupe_td_id,
            'charge_td_id'=>$charge_td_id,
            'groupe_i'=>1
        ]);
        }elseif($request->groupe_td_id ==null && $request->charge_td_id !=null){
             $sceance_tds=SceanceTd::where('charge_td_id', $request->charge_td_id)->orderBy('intitule')->paginate(50);
             $groupe_tds=DB::table('groupe_tds')->select('id', 'intitule')->OrderBy('intitule')->get();
        $charge_tds=ChargeTd::select('id', 'noms')->orderBy('noms')->get();
        $charge_td_id=$request->charge_td_id;
        return view('admin.gestionSceanceTD.index',[
            'charge_tds'=>$charge_tds,
            'groupe_tds'=>$groupe_tds,
            'sceance_tds'=>$sceance_tds,
            'n'=>1,
            'charge_td_id'=>$charge_td_id,
            'groupe_i'=>1
        ]);
        }elseif($request->groupe_td_id !=null && $request->charge_td_id ==null){
            return redirect()->route('Admin.sceanceTd.index', $request->groupe_td_id);
        }else{
            return back();
        }
        dd($request);
    }


    public function edit(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        $sceance_td=SceanceTd::findOrFail($request->id);
        return response()->json($sceance_td);
    }


    public function update(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        SceanceTd::where('id', $request->id)
                    ->update([
                        'intitule'=>$request->intitule,
                        'description'=>$request->description,
                        'date'=>$request->date,
                        'heureDebut'=>$request->heureDebut,
                        'heureFin'=>$request->heureFin,
                        'salle'=>$request->salle,
                        'capacite'=>$request->capacite
                    ]);
        $sceance_td=SceanceTd::findOrFail($request->id);
        return response()->json($sceance_td);
    }


    public function destroy($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $sceance_td=SceanceTd::findOrFail($id);
        $sceance_td->delete();
        return back();
    }
}
