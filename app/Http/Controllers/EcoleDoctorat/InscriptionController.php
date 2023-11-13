<?php

namespace App\Http\Controllers\EcoleDoctorat;

use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Dossier;
use App\Models\EcoleDoctorat\Evolution;

class InscriptionController extends Controller
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
        $dossiers=Dossier::where('status', 0)->paginate(50);
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        $dossier_nombre=$dossiers->count();
        $filiere=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
        $niveaux=Niveau::select('id', 'intitule')->where('id', '>', 4)->orderBy('intitule')->get();
        return view('ecoleDoctorat.inscription.index',[
            'inscriptions'=>$dossiers,
            'n'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre,
            'inscription_i'=>1,
            'niveaux'=>$niveaux,
            'filieres'=>$filiere
        ]);
    }

    public function show(Request $request)
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
    }


    public function update($id)
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // $etudiant_id=Dossier::find($id)->etudiant_id;
        // dd($etudiant_id);
        Dossier::where('id', $id)
                ->update([
                    'status'=>1
                ]);
        $etudiant_id=Dossier::find($id)->etudiant_id;
        Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>4,
            'acteur'=>'Administrateur',
            'objet'=>'Demande d\'inscription'
        ]);
        return back();
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
        $dossier=Dossier::findOrFail($id);
        $etudiant_id=$dossier->etudiant_id;
        Evolution::create([
            'etudiant_id'=>$etudiant_id,
            'etat_id'=>3,
            'acteur'=>'Administrateur',
            'objet'=>'Demande d\'inscription'
        ]);
        $dossier->delete();
        return back();
    }
}
