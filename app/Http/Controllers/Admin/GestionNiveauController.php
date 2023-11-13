<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionNiveauController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $niveaux=Niveau::latest()->OrderBy('intitule')->paginate(50);

        return view('admin.gestionNiveau.index',[
            'niveaux'=>$niveaux,
            'n'=>1,
            'niveau_i'=>1
        ]);

    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        if(!isset($request->search)){
            $niveaux=Niveau::all();
        }else{
            $niveaux=DB::table('niveaux')->OrderBy('code')
                            ->where('intitule', 'like', $request->search.'%')
                            ->get();
        }
        // dd($niveaux);
        return response()->json($niveaux);


    }
    public function create(){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        return view('admin.gestionNiveau.create',[
            'niveau_c'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $request->validate([
            'code'=>['required', 'max:25', 'min:2', 'unique:niveaux'],
            'intitule'=>['required', 'max:50']
        ]);
        $data=$request->only('code', 'intitule');
        Niveau::create($data);
        return redirect()->route('Admin.niveau.index');
    }
    public function edit(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $niveau=Niveau::findOrFail($request->id);
        return response()->json($niveau);
    }
    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $data=$request->except('_token', '_method', 'submit');
        Niveau::where('id', $request->id)
                ->update($data);
        $niveau=Niveau::find($request->id);
        return response()->json($niveau);

    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $niveau=Niveau::find($id);
        $niveau->delete();
        return back();
    }
}
