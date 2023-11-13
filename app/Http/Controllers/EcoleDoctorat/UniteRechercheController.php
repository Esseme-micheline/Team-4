<?php

namespace App\Http\Controllers\EcoleDoctorat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Dossier;
use App\Models\EcoleDoctorat\UniteRecherche;

class UniteRechercheController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index()
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $unite_recherches=UniteRecherche::select('id', 'code', 'intitule')->orderby('intitule')->paginate(50);
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('ecoleDoctorat.unite_recherche.index',[
            'unite_recherches'=>$unite_recherches,
            'n'=>1,
            'ur_i'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
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
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('ecoleDoctorat.unite_recherche.create',[
            'ur_c'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // $request->validate([
        //     'code'=>['required', 'max:20', 'min:2', 'unique:unite_recherches'],
        //     'intitule'=>['required', 'max:50']
        // ]);
        for($i=0; $i<count($request->code); $i++){
            if($request->code[$i] !=null && $request->intitule[$i] !=null){
                if(UniteRecherche::where('code', $request->code[$i])->get()->count()==0){
                    UniteRecherche::create([
                        'code'=>$request->code[$i],
                        'intitule'=>$request->intitule[$i],
                    ]);
                }else{
                    continue;
                }

            }
        }
        return redirect()->route('Ecole_Doctorat.unite_recherche.index');
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
        $unite_recherche=UniteRecherche::findOrFail($id);
        return response()->json($unite_recherche);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $data=$request->only('code', 'intitule');
        UniteRecherche::where('id', $request->id)
                    ->update($data);
        $unite_recherche=UniteRecherche::findOrFail($request->id);
        return response()->json($unite_recherche);
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
        $unite_recherche=UniteRecherche::findOrFail($id);
        $unite_recherche->delete();
        return back();
    }
}
