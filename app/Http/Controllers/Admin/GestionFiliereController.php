<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Models\Admin\Departement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionFiliereController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::where('departement_id', Auth::user()->departement_id)->orderBy('code')->paginate(50);
            $departements=Departement::select('intitule')->orderBy('code')->get();

        }else{
            $filieres=Filiere::latest()->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
        }
        return view('admin.gestionFiliere.index',[
            'filieres'=>$filieres,
            'departements'=>$departements,
            'n'=>1,
            'filiere_i'=>1
        ]);

    }
    public function showFil(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(!isset($request->search)){
            $filieres=Filiere::all();
        }else{
            $filieres=DB::table('filieres')
                            ->where('intitule', 'like', $request->search.'%')
                            ->get();
        }
        $departements=Departement::select('id', 'code')->get();
        return response()->json([
            'filiere'=>$filieres,
            'departement'=>$departements
        ]);
    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $id=$request->departement_id;
        if($id !=null){
            $filieres=Filiere::where('departement_id', $id)->orderBy('code')->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
            return view('admin.gestionFiliere.index',[
                'filieres'=>$filieres,
                'departements'=>$departements,
                'n'=>1,
                'id'=>$id,
                'filiere_i'=>1
            ]);
        }else{
            return redirect()->route('Admin.filiere.index');
        }

    }
    // Pour le controller qui vient de la vue admin.indexDept
    public function showDept($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $filieres=Filiere::where('departement_id', $id)->orderBy('code')->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
            return view('admin.gestionFiliere.index',[
                'filieres'=>$filieres,
                'departements'=>$departements,
                'n'=>1,
                'id'=>$id,
                'filiere_i'=>1
            ]);
    }
    public function create($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            // $filieres=Filiere::where('departement_id', Auth::user()->departement_id)->orderBy('code')->paginate(10);
            $departements=Departement::select('id', 'intitule')->where('id', Auth::user()->departement_id)->orderBy('code')->get();

        }else{
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
        }


        return view('admin.gestionFiliere.create',[
            'id'=>$id,
            'departements'=>$departements,
            'filiere_i'=>1

        ]);
    }
    public function createFil(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $dept=false;
        $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
        return view('admin.gestionFiliere.create',[
            'departements'=>$departements,
            'dept'=>$dept,
            'filiere_i'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $request->validate([
            'code'=>['required', 'max:25', 'min:3', 'unique:filieres'],
            'intitule'=>['required', 'max:100']
        ]);
        $data=$request->except('_token', '_method', 'submit');
        Filiere::create($data);
        return redirect()->route('Admin.filiere.index');
    }
    public function edit(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $filiere=Filiere::findOrFail($request->id);
        return response()->json($filiere);
    }
    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        Filiere::where('id', $request->id)
                    ->update([
                        'code'=>$request->code,
                        'intitule'=>$request->intitule
                    ]);
        $filiere=Filiere::findOrFail($request->id);
        return response()->json($filiere);
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $filiere=Filiere::find($id);
        $filiere->delete();
        return back();
    }
}
