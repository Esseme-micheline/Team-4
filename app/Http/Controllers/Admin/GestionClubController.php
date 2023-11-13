<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Club;
use Illuminate\Http\Request;
use App\Models\Admin\Departement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GestionClubController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            // $filieres=Filiere::where('departement_id', Auth::user()->departement_id)->orderBy('code')->paginate(10);
            $clubs=Club::where('departement_id', Auth::user()->departement_id)->orderBy('code')->paginate(50);
            $departements=null;
        }else{
            $clubs=Club::latest()->orderBy('code')->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
        }
        // dd($departements);
        return view("admin.gestionClub.index",[
            'clubs'=>$clubs,
            'departements'=>$departements,
            'n'=>1,
            'club_i'=>1
        ]);
    }
    public function showC(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        if(!isset($request->search)){
            $clubs=Club::all();
        }else{
            $clubs=DB::table('clubs')
                            ->where('intitule', 'like', $request->search.'%')
                            ->get();
        }
        $departements=Departement::select('id', 'code')->orderBy('code')->get();
        return response()->json([
            'club'=>$clubs,
            'departement'=>$departements
        ]);
    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user())){
            abort(403);
        }
        $id=$request->departement_id;
        if($id !=null){
            $clubs=Club::where('departement_id', $id)->orderBy('code')->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
            return view('admin.gestionClub.index',[
                'clubs'=>$clubs,
                'departements'=>$departements,
                'n'=>1,
                'id'=>$id,
                'club_i'=>1
            ]);
        }else{
            return redirect()->route('Admin.club.index');
        }
    }
    // Pour le controller qui vient de la vue admin.indexDept
    public function showDept($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
            $clubs=Club::where('departement_id', $id)->orderBy('code')->paginate(50);
            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
            return view('admin.gestionClub.index',[
                'clubs'=>$clubs,
                'departements'=>$departements,
                'n'=>1,
                'id'=>$id,
                'club_i'=>1
            ]);
    }
    public function create($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $departements=Departement::select('id', 'intitule')->where('id', Auth::user()->departement_id)->orderBy('code')->get();
        }else{

            $departements=Departement::select('id', 'intitule')->orderBy('code')->get();
        }
        return view('admin.gestionClub.create',[
            'id'=>$id,
            'departements'=>$departements,
            'club_i'=>1
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $request->validate([
            'code'=>['required', 'max:25', 'min:3', 'unique:clubs'],
            'intitule'=>['required', 'max:100']
        ]);
        $data=$request->except('_token', '_method', 'submit');
        Club::create($data);
        return redirect()->route('Admin.club.index');
    }
    public function edit(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $club=Club::findOrFail($request->id);
        return response()->json($club);
    }
    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        Club::where('id', $request->id)
                    ->update([
                        'code'=>$request->code,
                        'intitule'=>$request->intitule
                    ]);
        $club=Club::findOrFail($request->id);
        return response()->json($club);
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $club=Club::findOrFail($id);
        $club->delete();
        return redirect()->route('Admin.club.index');
    }
}
