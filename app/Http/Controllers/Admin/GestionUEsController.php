<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Ue;
use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Models\Admin\Attribution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionUEsController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('enseignant', Auth::user())){
            $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
            // dd($attributions->count());
            if($attributions->count()>0){
                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->paginate(50);
                foreach($ues as $ue){
                    $data_f[]=$ue->filiere_id;
                }

                // dd($data_f);
                $filieres=Filiere::select('id', 'intitule')->whereIn('id', $data_f)->orderBy('intitule')->get();

            }else{
                $ues=null;
                $filieres=null;
            }

            // dd($ues);
        }elseif(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            // dd(Auth::user()->departement->filieres);
            if(Auth::user()->departement->filieres->count()>0){
                foreach(Auth::user()->departement->filieres as $filiere){
                    if($filiere->ues->count()>0){

                        foreach($filiere->ues as $ue){

                            $data_ue_id[]=$ue->id;
                        }
                    }

                }
                if(isset($data_ue_id)){

                    $ues=Ue::whereIn('id', $data_ue_id)->orderBy('code')->paginate(50);
                }else{
                    $ues=null;
                }
            }else{
                    $ues=null;
                }
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
            // dd($ues);
        }
        else{
            $ues=Ue::latest()->orderBy('code')->paginate(50);
            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        }
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        return view('admin.gestionUEs.index',[
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'ues'=>$ues,
            'n'=>1,
            'ue_i'=>1
        ]);
    }
    public function showFil($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
        }else{

            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        }
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        $ues=Ue::where('filiere_id', $id)
                    ->orderBy('code')
                    ->paginate(50);
            return view('admin.gestionUEs.index',[
                        'filieres'=>$filieres,
                        'niveaux'=>$niveaux,
                        'ues'=>$ues,
                        'n'=>1,
                        'filiere_id'=>$id,
                        'ue_i'=>1
                    ]);

    }
    public function showNiv($id){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        $ues=Ue::where('niveau_id', $id)
                    ->orderBy('code')
                    ->paginate(50);
            return view('admin.gestionUEs.index',[
                        'filieres'=>$filieres,
                        'niveaux'=>$niveaux,
                        'ues'=>$ues,
                        'n'=>1,
                        'niveau_id'=>$id,
                        'ue_i'=>1

                    ]);
    }
    public function show(Request $request){
        if(Gate::allows('doyen_Ecole', Auth::user()) || Gate::allows('chargeTD', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
        }elseif(Gate::allows('enseignant', Auth::user())){
            // dd(Auth::user()->enseignant->attributi²ons);
            if(Auth::user()->enseignant->attributions->count() >0){
                foreach(Auth::user()->enseignant->attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)->orderBy('code')->paginate(50);
                foreach($ues as $ue){
                    $data_f[]=$ue->filiere_id;
                }

                // dd($data_f);
                $filieres=Filiere::select('id', 'intitule')->whereIn('id', $data_f)->orderBy('intitule')->get();

            }else{
                $ues=null;
                $filieres=null;
            }
        }

        else{

            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        }
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        if($request->filiere_id !=null && $request->niveau_id !=null){
            if(Gate::allows('enseignant', Auth::user())){
                $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)
                        ->where('filiere_id', $request->filiere_id)
                        ->where('niveau_id', $request->niveau_id)
                        ->orderBy('code')->paginate(50);

                // dd($ues);
            }else{
            $ues=Ue::where('filiere_id', $request->filiere_id)
                    ->where('niveau_id', $request->niveau_id)
                    ->orderBy('code')
                    ->paginate(50);
            }
            return view('admin.gestionUEs.index',[
                        'filieres'=>$filieres,
                        'niveaux'=>$niveaux,
                        'ues'=>$ues,
                        'n'=>1,
                        'filiere_id'=>$request->filiere_id,
                        'niveau_id'=>$request->niveau_id,
                        'ue_i'=>1

                    ]);
        }elseif($request->filiere_id !=null && $request->niveau_id ==null){
            if(Gate::allows('enseignant', Auth::user()) ){
                $attributions=Attribution::where('enseignant_id', Auth::user()->enseignant['id'])->paginate(50);
                foreach($attributions as $attribution){
                    $data[]=$attribution->ue_id;
                }
                $ues=Ue::whereIn('id', $data)
                        ->where('filiere_id', $request->filiere_id)
                        ->orderBy('code')->paginate(50);

                // dd($ues);
            }
            else{
                $ues=Ue::where('filiere_id', $request->filiere_id)
                        ->orderBy('code')
                        ->paginate(50);
            }
            return view('admin.gestionUEs.index',[
                        'filieres'=>$filieres,
                        'niveaux'=>$niveaux,
                        'ues'=>$ues,
                        'n'=>1,
                        'filiere_id'=>$request->filiere_id,
                        'ue_i'=>1
                    ]);
        }elseif($request->filiere_id ==null && $request->niveau_id !=null){
            if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user()) || Gate::allows('enseignant', Auth::user())){
                abort(403);
            }
            else{
                $ues=Ue::where('niveau_id', $request->niveau_id)->orderBy('code')
                    ->paginate(50);
            }
            return view('admin.gestionUEs.index',[
                        'filieres'=>$filieres,
                        'niveaux'=>$niveaux,
                        'ues'=>$ues,
                        'n'=>1,
                        'niveau_id'=>$request->niveau_id,
                        'ue_i'=>1

                    ]);
        }else{
            return redirect()->route('Admin.ue.index');
        }

    }
    public function create($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $filiere_id=$id;
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
        }else{

            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        }
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        return view('admin.gestionUEs.create',[
            'filiere_id'=>$filiere_id,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'ue_i'=>1
        ]);
    }
    public function createNiv($id){
        if(! Gate::allows('super_admin', Auth::user()) ){
            abort(403);
        }
        $niveau_id=$id;
        $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        return view('admin.gestionUEs.create',[
            'niveau_id'=>$niveau_id,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'ue_i'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }


            for($i=0; $i<count($request->code); $i++){
                if($request->code[$i] !=null && $request->intitule[$i] !=null && $request->filiere_id !=null && $request->niveau_id !=null){
                    if(Ue::where('code', $request->code[$i])->get()->count()==0){
                        Ue::create([
                            'filiere_id'=>$request->filiere_id,
                            'niveau_id'=>$request->niveau_id,
                            'code'=>$request->code[$i],
                            'intitule'=>$request->intitule[$i],
                        ]);
                    }else{
                        continue;
                    }

                }
            }
        return redirect()->route('Admin.ue.index');
    }
    public function edit(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $ue=Ue::findOrFail($request->id);
        return response()->json($ue);
    }
    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        Ue::where('id', $request->id)
            ->update([
                'code'=>$request->code,
                'intitule'=>$request->intitule
            ]);
        $ue=Ue::findOrFail($request->id);
        return response()->json($ue);
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $ue=Ue::findOrFail($id);
        $ue->delete();
        return back();
    }
}
