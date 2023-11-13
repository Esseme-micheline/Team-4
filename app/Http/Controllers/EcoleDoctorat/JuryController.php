<?php

namespace App\Http\Controllers\EcoleDoctorat;

use Illuminate\Http\Request;
use App\Models\Admin\Departement;
use App\Models\EcoleDoctorat\Jury;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Dossier;

class JuryController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $juries=Jury::select('id', 'noms', 'email')->paginate(50);
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        // foreach($juries as $jury){
        //     dd($jury);
        // }
        $departements=Departement::select('code', 'intitule')->orderBy('intitule')->get();
        return view('ecoleDoctorat.juries.index',[
            'juries'=>$juries,
            'n'=>1,
            'jury_s'=>1,
            'departements'=>$departements,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre,
        ]);
    }
    public function voir($id){
            $jury = Jury::findOrfail($id);
            $dossier_nombre=Dossier::where('status', 0)->get()->count();
            $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
            // dd($jury->noms);
            // $dossier=Dossier::where('')
            return view('ecoleDoctorat.juries.voir',[
                'jury'=>$jury,
                'jury_s'=>1,
                'dossier_nombre_1'=>$dossier_nombre_1,
                'dossier_nombre'=>$dossier_nombre,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $departements=Departement::select('code', 'intitule')->orderby('intitule')->get();
        return view('ecoleDoctorat.juries.create', [
            'jury_s'=>1,
            'departements'=>$departements
        ]);
    }
    // public function test_input($data) {
    //     $data = trim($data);
    //     $data = stripslashes($data);
    //     $data = htmlspecialchars($data);
    //     return $data;
    //   }

    public function store(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'noms'=>['required', 'min:3', 'max:100'],
            'grade'=>['max:50'],
            'telephone'=>[ 'max:9'],
            'email'=>['required', 'email', 'max:100', 'unique:juries'],
            'universite'=>['max:60'],
            'faculte'=>['max:60'],
            'departement'=>['max:60']
        ]);
        $data=$request->only('noms', 'grade', 'telephone', 'email', 'universite', 'faculte', 'departement');
        Jury::create($data);
        return redirect()->route('Ecole_Doctorat.jury.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $jury=Jury::find($id);
        return response()->json([
            'jury'=>$jury,
        ]);
    }
    public function update(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        /* $request->validate([
            'noms'=>['required', 'min:3', 'max:100'],
            'grade'=>['max:50'],
            'telephone'=>[ 'max:9'],
            'email'=>['required', 'email', 'max:100', 'unique:juries'],
            'universite'=>['max:60'],
            'faculte'=>['max:60'],
            'departement'=>['max:60']
        ]); */
        $data=$request->only('noms', 'grade', 'telephone', 'email', 'universite', 'faculte', 'departement');
        Jury::where('id', $request->id)
            ->update($data);
        $jury=Jury::find($request->id);
        return response()->json($jury);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $jury=Jury::find($id);
        $jury->delete();
        return back();
    }
}
