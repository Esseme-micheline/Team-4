<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Ue;
use Illuminate\Http\Request;
use App\Models\Admin\Enseignant;
use App\Models\Admin\Attribution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionAttributionController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('enseignant', Auth::user())){
            abort(403);
        }
        if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
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
                    $attributions=Attribution::whereIn('ue_id', $data_ue_id)->paginate(50);
                }else{
                    $attributions=null;
                }
                }else{
                    $attributions=null;
                }
        }
        else{
            $attributions=Attribution::latest()->paginate(50);
        }

        return view('admin.gestionAttribution.index',[
            'attributions'=>$attributions,
            'n'=>1,
            'attribution_i'=>1
        ]);

    }
    public function show(){

    }
    public function create($id){

        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            // dd(Auth::user()->departement->filieres);
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){

                    foreach($filiere->ues as $ue){

                        $data_ue_id[]=$ue->id;
                    }
                }
                if(isset($data_ue_id)){

                    $ues=Ue::select('id', 'code')->whereIn('id', $data_ue_id)->orderBy('code')->get();
                }else{
                    $ues=null;
                }
                }else{
                    $ues=null;
                }
        }else{

            $ues=Ue::select('id', 'code')->OrderBy('code')->get();
        }
        $utilisateurs=User::whereIn('profil_id', [0, 1])->select('enseignant_id')->get();
        $enseignant=Enseignant::select('id', 'noms')->whereNotIn('id', $utilisateurs)->OrderBy('noms')->get();
        return view('admin.gestionAttribution.create',[
            'enseignants'=>$enseignant,
            'enseignant_id'=>$id,
            'ues'=>$ues,
            'attribution_i'=>1,
        ]);

    }
    public function createAt(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            if(Auth::user()->departement->filieres->count()>0){
            foreach(Auth::user()->departement->filieres as $filiere){

                foreach($filiere->ues as $ue){

                    $data_ue_id[]=$ue->id;
                }
            }
            $ues=Ue::select('id', 'code')->whereIn('id', $data_ue_id)->orderBy('code')->get();
            }else{
                $ues=null;
            }
        }else{

            $ues=Ue::select('id', 'code')->OrderBy('code')->get();
        }
        $enseignant=Enseignant::select('id', 'noms')->OrderBy('noms')->get();
        return view('admin.gestionAttribution.create',[
            'enseignants'=>$enseignant,
            'ues'=>$ues,
            'attribution_i'=>1,
        ]);

    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $request->validate([
            'enseignant_id'=>['required'],
            'ue_id'=>['required']
        ]);
        // dd(count($request->ue_id));
        if(count($request->ue_id) >1){
            for($i=0; $i<count($request->ue_id); $i++){
                if(Attribution::where('ue_id', $request->ue_id[$i])->where('enseignant_id', $request->enseignant_id)->get()->count()==0){
                    Attribution::create([
                        'enseignant_id'=>$request->enseignant_id,
                        'ue_id'=>$request->ue_id[$i],
                    ]);
                }else{
                    continue;
                }
            }
        }else{
            if(Attribution::where('ue_id', $request->ue_id[0])->where('enseignant_id', $request->enseignant_id)->get()->count()==0){
                Attribution::create([
                    'enseignant_id'=>$request->enseignant_id,
                    'ue_id'=>$request->ue_id[0],
                ]);
            }
        }
        return redirect()->route('Admin.attribution.index');
    }
    public function edit(){

    }
    public function update(Request $request){

    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $attribution=Attribution::find($id);
        $attribution->delete();
        return back();
    }
}
