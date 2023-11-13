<?php

namespace App\Http\Controllers\EcoleDoctorat;

use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Models\Admin\Departement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Dossier;

class ReportingController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index(){
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $dossier_nombre=Dossier::all()->count();
        $niveaux=Niveau::select('id','code')->where('id', '>', 4)->get();
        $departements=Departement::select('id', 'code')->orderBy('code')->get();
        $filieres=Filiere::select('id', 'code')->orderBy('code')->get();
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        foreach($departements as $departement){
            $filieres=$departement->filieres;
            if($filieres->count()>0 && $niveaux->count()>0){
                foreach($niveaux as $niveau){

                    foreach($filieres as $filiere){
                            $datas[]=Dossier::where('filiere_id', $filiere->id)
                                            ->where('niveau_id', $niveau->id)->get()->count();
                    }
                        $nombre=0;
                    for($i=0; $i<count($datas); $i++){
                        $nombre+=$datas[$i];
                    }
                    $datas=[];
                    $data[]=[
                        'niveau'=>$niveau->code,
                        'departement'=>$departement->code,
                        'nombre'=>$nombre,
                    ];
                }
            }
        }
        $authorisation_nombre=Dossier::whereIn('status', [3, 4])->get()->count();
        $attente_note_nombre=Dossier::whereIn('status', [5, 6, 7])->get()->count();
        $authorisation_valider_nombre=Dossier::where('status', 9)->get()->count();
        return view('ecoleDoctorat.index',[
            'dossier_nombre'=>$dossier_nombre,
            'attente_note_nombre'=>$attente_note_nombre,
            // 'datas'=>$data,

            'authorisation_valider_nombre'=>$authorisation_valider_nombre,
            'authorisation_nombre'=>$authorisation_nombre,
            'reporting'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);
    }
}
