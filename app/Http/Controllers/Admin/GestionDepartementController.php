<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Departement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionDepartementController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $departements=Departement::latest()->orderBy('code')->paginate(50);
        return view('admin.gestionDepartement.index',[
            'departements'=>$departements,
            'n'=>1,
            'departement_i'=>1
        ]);
    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(!isset($request->search)){
            $departement=Departement::all();
        }else{
            $departement=DB::table('departements')
                            ->where('intitule', 'like', '%'.$request->search.'%')
                            ->orderBy('code')
                            ->get();
        }
        return response()->json($departement);
    }
    public function create(){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        return view('admin.gestionDepartement.create',[
            'departement_c'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $request->validate([
            'code'=>['required', 'max:25', 'min:3', 'unique:departements'],
            'intitule'=>['required', 'max:100']
        ]);
        $data=$request->except('_token', '_method', 'submit');
        Departement::create($data);
        return redirect()->route('Admin.departement.index');
    }
    public function edit(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $departement=Departement::findOrFail($request->id);
        return response()->json($departement);
    }

    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        Departement::where('id', $request->id)
                    ->update([
                        'code'=>$request->code,
                        'intitule'=>$request->intitule
                    ]);
        $departement=Departement::findOrFail($request->id);
        return response()->json($departement);
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $departement=Departement::findOrFail($id);
        $departement->delete();
        return back();
    }
}
