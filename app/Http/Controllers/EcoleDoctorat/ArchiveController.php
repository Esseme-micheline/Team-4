<?php

namespace App\Http\Controllers\EcoleDoctorat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Archive;
use App\Models\EcoleDoctorat\Dossier;

class ArchiveController extends Controller
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
        $dossiers=Archive::latest()->paginate(50);
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('ecoleDoctorat.archive.index',[
            'archives'=>$dossiers,
            'n'=>1,
            'archive_i'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);
    }
    /* public function show(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // dd($request->all());
        $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        $niveaux=Niveau::select('id', 'intitule')->where('id', '>', 3)->orderBy('intitule')->get();
        if($request->filiere_id !=null && $request->niveau_id !=null){
            // dd('pas encore');
            $dossiers=Dossier::where('filiere_id', $request->filiere_id)
                                ->where('niveau_id', $request->niveau_id)
                                ->paginate(50);
        return view('ecoleDoctorat.inscription.index',[
            'inscriptions'=>$dossiers,
            'n'=>1,
            'inscription_i'=>1,
            'niveaux'=>$niveaux,
            'filieres'=>$filieres,
            'filiere_id'=>$request->filiere_id,
            'niveau_id'=>$request->niveau_id,
        ]);
        }elseif($request->filiere_id !=null && $request->niveau_id==null){
            // dd('ok');
            $dossiers=Dossier::where('filiere_id', $request->filiere_id)
                                ->where('status', 0)
                                ->paginate(50);
        return view('ecoleDoctorat.inscription.index',[
            'inscriptions'=>$dossiers,
            'n'=>1,
            'inscription_i'=>1,
            'niveaux'=>$niveaux,
            'filieres'=>$filieres,
            'filiere_id'=>$request->filiere_id,
        ]);
        }elseif($request->filiere_id ==null && $request->niveau_id!=null){
            // dd('pas encore');
            $dossiers=Dossier::where('niveau_id', $request->niveau_id)
                                ->paginate(50);

        return view('ecoleDoctorat.inscription.index',[
            'inscriptions'=>$dossiers,
            'n'=>1,
            'inscription_i'=>1,
            'niveaux'=>$niveaux,
            'filieres'=>$filieres,
            'niveau_id'=>$request->niveau_id,
        ]);
        }else{
            return redirect()->route('Ecole_Doctorat.Inscription.index');
        }
    } */

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
