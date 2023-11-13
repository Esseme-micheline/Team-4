<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Td;
use App\Models\Admin\Ue;
use Illuminate\Http\Request;
use App\Models\Admin\TdSpecial;
use App\Models\Admin\Attribution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionTDController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }

        if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
                $tds=Td::whereIn('ue_id', $data)->orderBy('code')->get();
                $tdSpecials=TdSpecial::whereIn('ue_id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
                $tds=null;
                $tdSpecials=null;
            }

        }elseif(Gate::allows('chargeTD', Auth::user())){
            if(Auth::user()->charge_td->groupe_tds->count() > 0){
                // dd(Auth::user()->charge_td->groupe_tds->count());
                foreach(Auth::user()->charge_td->groupe_tds as $groupe_td){
                    if($groupe_td->td_special_id !=null){
                        $data_td_special[]=$groupe_td->td_special_id;
                    }
                    if($groupe_td->td_id !=null){
                        $data_td[]=$groupe_td->td_id;
                    }
                }

            }
            $ues=null;
            if(isset($data_td)){
                $tds=Td::whereIn('id', $data_td)->orderBy('code')->get();
            }else{
                $tds=null;
            }
            if(isset($data_td_special)){
                $tdSpecials=TdSpecial::whereIn('ue_id', $data_td_special)->orderBy('code')->get();
            }else{
                $tdSpecials=null;
            }
            // dd($tds);
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
                        $tds=Td::whereIn('ue_id', $data_ue_id)->get();
                        $tdSpecials=TdSpecial::whereIn('ue_id', $data_ue_id)->get();
                        $ues=Ue::whereIn('id', $data_ue_id)->get();
                    // $attributions=Attribution::whereIn('ue_id', $data_ue_id)->paginate(50);
                }else{
                    $tds=null;
                    $tdSpecials=null;
                    $ues=null;
                }
            }else{
                    $tds=null;
                    $tdSpecials=null;
                    $ues=null;
                }
        }
        else{
            $tds=Td::all();
            $tdSpecials=TdSpecial::all();
            $ues=Ue::all();
        }
        return view('admin.gestionGroupTD.index',[
            'tds'=>$tds,
            'tdSpecials'=>$tdSpecials,
            'n'=>1,
            'ues'=>$ues,
            'groupe_i'=>1
        ]);
    }
    public function show(Request $request){
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
                        $ues=Ue::whereIn('id', $data_ue_id)->get();
                    // $attributions=Attribution::whereIn('ue_id', $data_ue_id)->paginate(50);
                }else{
                    $ues=null;
                }
            }else{
                    $ues=null;
                }
        }
         elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
            }

        }
        else{
            $ues=Ue::all();
        }
        if($request->ue_id!=null && $request->Td_id !=null){
            // dd('ok');
            $ue_id=$request->ue_id;
            $td_id=$request->Td_id;
            if($request->Td_id==1){
                $tds=Td::where('ue_id', $request->ue_id)->Orderby('code')->get();
                return view('admin.gestionGroupTD.index',[
                    'tds'=>$tds,
                    'ue_id'=>$ue_id,
                    'td_id'=>$td_id,
                    'tdSpecials'=>null,
                    'n'=>1,
                    'ues'=>$ues,
                    'groupe_i'=>1
                ]);
            }else{
                $ue_tdSpecial_id=$ue_id;
                $tdSpecials=TdSpecial::where('ue_id', $request->ue_id)->Orderby('code')->get();
                return view('admin.gestionGroupTD.index',[
                    'tdSpecials'=>$tdSpecials,
                    'ue_id'=>$ue_id,
                    'td_id'=>$td_id,
                    'n'=>1,
                    'ues'=>$ues,
                    'ue_tdSpecial_id'=>$ue_tdSpecial_id,
                    'groupe_i'=>1
                ]);
            }
        }elseif($request->ue_id==null && $request->Td_id !=null){
            if(! Gate::allows('super_admin', Auth::user())){
                abort(403);
            }
            $td_id=$request->Td_id;
            if($request->Td_id==1){
                $tds=Td::all();
                return view('admin.gestionGroupTD.index',[
                    'tds'=>$tds,
                    'td_id'=>$td_id,
                    'n'=>1,
                    'ues'=>$ues,
                    'groupe_i'=>1
                ]);
            }else{
                $tdSpecials=TdSpecial::all();
                return view('admin.gestionGroupTD.index',[
                    'tdSpecials'=>$tdSpecials,
                    'td_id'=>$td_id,
                    'n'=>1,
                    'ues'=>$ues,
                    'groupe_i'=>1

                ]);
            }
        }elseif($request->ue_id!=null && $request->Td_id ==null){
            $tds=Td::where('ue_id', $request->ue_id)->Orderby('code')->get();
            $tdSpecials=TdSpecial::where('ue_id', $request->ue_id)->Orderby('code')->get();
            $ues=Ue::all();
            $ue_id=$request->ue_id;
            return view('admin.gestionGroupTD.index',[
                'tds'=>$tds,
                'tdSpecials'=>$tdSpecials,
                'n'=>1,
                'ues'=>$ues,
                'ue_id'=>$ue_id,
                'groupe_i'=>1
            ]);
        }else{
            return redirect()->route('Admin.groupeTD.index');
        }
    }
    public function showTd($id){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
            }

        }else{

            $ues=Ue::all();
        }
        $ue_id=$id;
        $td_id=1;
        $tds=Td::where('ue_id', $id)->Orderby('code')->get();
                return view('admin.gestionGroupTD.index',[
                    'tds'=>$tds,
                    'ue_id'=>$ue_id,
                    'td_id'=>$td_id,
                    'tdSpecials'=>null,
                    'n'=>1,
                    'ues'=>$ues,
                    'groupe_i'=>1
                ]);
    }
    public function showTdSpecial($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
            }

        }else{
            $ues=Ue::all();

        }
        $ue_id=$id;
        $td_id=2;
        $tdSpecials=TdSpecial::where('ue_id', $id)->Orderby('code')->get();
                return view('admin.gestionGroupTD.index',[
                    'tdSpecials'=>$tdSpecials,
                    'td_id'=>$td_id,
                    'ue_id'=>$ue_id,
                    'n'=>1,
                    'ues'=>$ues,
                    'ue_tdSpecial_id'=>$id,
                    'groupe_i'=>1

                ]);

    }
    public function createTd($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) ||  Gate::allows('secretaire', Auth::user())){

            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){

                    if($filiere->ues->count()>0){
                        // dd($filiere->ues);
                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }
                }

                // dd($data_ue_id);
                    if($data_ue_id !=null){
                        $ues=Ue::select('id', 'code')->whereIn('id', $data_ue_id)->OrderBy('code')->get();
                    // $attributions=Attribution::whereIn('ue_id', $data_ue_id)->paginate(50);
                }else{
                    $ues=null;

                    // dd('oks');
                }
            }else{
                    $ues=null;
                }
        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
            }

        }
        else{
            $ues=Ue::select('id', 'code')->OrderBy('code')->get();
        }
        // dd($ues);

        return view('admin.gestionGroupTD.create',[
            'ues'=>$ues,
            'ue_id'=>$id,
            'groupe_i'=>1
        ]);
    }
    public function createTdSpeciale($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
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
                        $ues=Ue::select('id', 'code')->whereIn('id', $data_ue_id)->OrderBy('code')->get();
                    // $attributions=Attribution::whereIn('ue_id', $data_ue_id)->paginate(50);
                }else{
                    $ues=null;
                }
            }else{
                    $ues=null;
                }
        }elseif(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            if($attributions->count() >0){

                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->get();
            }else{
                $ues=null;
            }

        }
        else{
            $ues=Ue::select('id', 'code')->OrderBy('code')->get();
        }
        $ue_tdSpecial_id=$id;
        return view('admin.gestionGroupTD.create',[
            'ues'=>$ues,
            'ue_id'=>$id,
            'ue_tdSpecial_id'=>$ue_tdSpecial_id,
            'groupe_i'=>1
        ]);

    }
    public function store(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $request->validate([
            'ue_id'=>['required', 'integer'],
            'intitule'=>['required', 'max:50'],
        ]);
        if(Td::where('ue_id', $request->ue_id)->get()->count() > 0){
            abort(403);
        }
        $code = Ue::find($request->ue_id)->code;
        $code="TD_".$code;
        // dd($code);
        $data=$request->only('ue_id', 'intitule');
        $data['code']=$code;
        Td::create($data);
        return redirect()->route('Admin.groupeTD.showTd', $request->ue_id);
    }
    public function storeTdSpecial(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $request->validate([
            'ue_id'=>['required', 'integer'],
            'intitule'=>['required', 'max:50'],
            'prix'=>['required', 'integer'],
        ]);
        if(TdSpecial::where('ue_id', $request->ue_id)->get()->count() > 0){
            abort(403);
        }
        $code = Ue::find($request->ue_id)->code;
        $code="TDSpecial_".$code;
        // dd($code);
        $data=$request->only('ue_id', 'intitule', 'prix');
        $data['code']=$code;
        TdSpecial::create($data);
        return redirect()->route('Admin.groupeTD.showTdSpecial', $request->ue_id);

    }
    public function edit(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $td=Td::findOrFail($request->id);
        return response()->json($td);
    }
    public function editTdSpecial(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $tdSpecials=TdSpecial::findOrFail($request->id);
        return response()->json($tdSpecials);
    }
    public function update(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        Td::where('id', $request->id)
            ->update([
                'code'=>$request->code,
                'intitule'=>$request->intitule
            ]);
        $td=Td::findOrFail($request->id);
        return response()->json($td);
    }
    public function updateTdSpecial(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        TdSpecial::where('id', $request->id)
            ->update([
                'code'=>$request->code,
                'intitule'=>$request->intitule,
                'prix'=>$request->prix
            ]);
            $tdSpecials=TdSpecial::findOrFail($request->id);
            return response()->json($tdSpecials);
    }
    public function destroy($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $td=Td::findOrFail($id);
        $td->delete();
        return back();
    }
    public function destroyTdSpecial($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        $td=TdSpecial::findOrFail($id);
        $td->delete();
        return back();
    }
}
