<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Ue;
use Illuminate\Http\Request;
use App\Models\Admin\Enseignant;
use App\Models\Admin\Attribution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GestionEnseignantController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }

        $enseignants=Enseignant::latest()->paginate(50);
        return view('admin.gestionEnseignant.index',[
            'enseignants'=>$enseignants,
            'n'=>1,
            'enseignant_i'=>1
        ]);
    }
    public function voir($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $enseignant=Enseignant::find($id);
        if($enseignant->attributions->count()>0){
            $ue_ids=Attribution::select('ue_id')->where('enseignant_id', $id)->get();
            foreach($ue_ids as $ue_id){
                $ue_code[]=Ue::find($ue_id->ue_id)->code;
            }
        }else{
            $ue_code[]='Aucun UE';
        }

        return view('admin.gestionEnseignant.voir',[
            'enseignant'=>$enseignant,
            'ue_code'=>$ue_code,
            'enseignant_i'=>1
        ]);
    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if($request->search==null){
            $enseignants=Enseignant::select('id', 'noms', 'telephone', 'bureau')->OrderBy('noms')->get();
        }else{
            $enseignants=DB::table('enseignants')
                            ->select('id', 'noms', 'telephone', 'bureau')
                            ->where('noms', 'likes', $request->search.'%')
                            ->OrderBy('noms')->get();
        }
        return response()->json($enseignants);
    }
    public function create(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        return view('admin.gestionEnseignant.create',[
            'enseignant_i'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        // dd('oj');
        $request->validate([
            'noms'=>['required', 'min:5', 'max:100', 'unique:enseignants'],
            'telephone'=>[ 'min:9', 'max:9'],
            'email'=>[ 'max:100', 'unique:enseignants', 'unique:users'],
            'bureau'=>[ 'max:20']
        ]);
        $data=$request->only('noms', 'telephone', 'email', 'bureau');
        $data['password']=Hash::make('default');
        Enseignant::create($data);
        return redirect()->route('Admin.enseignant.index');
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $enseignant=Enseignant::findOrFail($id);
        $enseignant->delete();
        return back();
    }
}
