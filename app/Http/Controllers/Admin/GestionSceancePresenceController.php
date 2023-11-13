<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Admin\Td;
use App\Models\Admin\Ue;
use Illuminate\Http\Request;
use App\Models\Admin\GroupeTd;
use App\Models\Admin\SceanceTd;
use App\Models\Admin\TdSpecial;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\PresencesSceancesTd;
use App\Models\Etudiant\EtudiantGroupeTd;


class GestionSceancePresenceController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $groupe_td_id=SceanceTd::find($id)->groupe_td_id;
        $td=GroupeTd::findOrFail($groupe_td_id)->td_special_id;
        if($td !=null){
            $isTdSpecial=true;
        }else{
            $isTdSpecial=false;
        }
        $presences_sceances=PresencesSceancesTd::where('seance_td_id', $id)->get();
        $presences_sceances_count=$presences_sceances->count();
        if($presences_sceances->count()>0){
                foreach($presences_sceances as $presences_sceance){
                    $data_etudiant[]=['noms'=>$presences_sceance->etudiant['noms'],
                                    'matricule'=>$presences_sceance->etudiant['matricule'],
                                    'id'=>$presences_sceance->id,
                                    'status'=>$presences_sceance->status];
                    // dd($etudiants_groupes_td->etudiant['noms']);
                }
                asort($data_etudiant);
            // dd($presences_sceances);
        }else{
            $data_etudiant=null;
        }
        // dd($data_etudiant);
        return view('admin.gestionSceanceTD.gestionPresence.index',[
            'isTdSpecial'=>$isTdSpecial,
            'presences_sceances_count'=>$presences_sceances_count,
            'presences_sceances'=>$data_etudiant,
            'sceance_td_id'=>$id,
            'n'=>1,
            'groupe_i'=>1
        ]);

    }

    public function create($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $groupe_td_id=SceanceTd::findOrFail($id)->groupe_td_id;
        $etudiants_groupes_tds=EtudiantGroupeTd::where('groupe_td_id', $groupe_td_id)->get();
        $etudiants_groupes_tds_count=$etudiants_groupes_tds->count();
        if($etudiants_groupes_tds->count()>0){
            foreach($etudiants_groupes_tds as $etudiants_groupes_td){
                $data_etudiant[]=['noms'=>$etudiants_groupes_td->etudiant['noms'],
                                'matricule'=>$etudiants_groupes_td->etudiant['matricule'],
                                 'id'=>$etudiants_groupes_td->etudiant_id];
                // dd($etudiants_groupes_td->etudiant['noms']);
            }
            asort($data_etudiant);
            // dd($data_etudiant);
        }else{
            $data_etudiant=null;
        }
        return view('admin.gestionSceanceTD.gestionPresence.create',[
            'etudiants_groupes_tds_count'=>$etudiants_groupes_tds_count,
            'etudiants_groupes_tds'=>$data_etudiant,
            'id'=>$id,
            'n'=>1,
            'groupe_i'=>1
        ]);
    }

    public function store(Request $request)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $groupe_td_id=SceanceTd::find($request->sceance_td_id)->groupe_td_id;
        $etudiants_groupes_tds=EtudiantGroupeTd::where('groupe_td_id', $groupe_td_id)->get();
        if($request->status !=null){
            // dd('ok');
            $status=$request->status;
            // dd(count($status));
            // dd($etudiants_groupes_tds->count());
            if($etudiants_groupes_tds->count()==count($status)){
                // dd('hum');
                for($i=0; $i<count($status); $i++){
                    PresencesSceancesTd::create([
                        'etudiant_id'=>$status[$i],
                        'seance_td_id'=>$request->sceance_td_id,
                        'status'=>1
                    ]);
                }
            }else{
                // dd($status);
                foreach($etudiants_groupes_tds as $etudiants_groupes_td){
                    $verif=false;
                    // dd($etudiants_groupes_td->etudiant_id);
                    if(count($status)>1){
                        for($i=0; $i<count($status); $i++){
                            if($etudiants_groupes_td->etudiant_id==(int)$status[$i]){
                                // dd((int)$status[$i]);
                                PresencesSceancesTd::create([
                                    'etudiant_id'=>(int)$status[$i],
                                    'seance_td_id'=>$request->sceance_td_id,
                                    'status'=>1
                                ]);
                                $verif=true;
                                break;
                            }
                        }
                        if($verif==false){
                            PresencesSceancesTd::create([
                                'etudiant_id'=>$etudiants_groupes_td->etudiant_id,
                                'seance_td_id'=>$request->sceance_td_id,
                                'status'=>0
                            ]);
                        }
                    }else{
                        // dd((int)$status[0]);
                        if($etudiants_groupes_td->etudiant_id==(int)$status[0]){

                            PresencesSceancesTd::create([
                                'etudiant_id'=>(int)$status[0],
                                'seance_td_id'=>$request->sceance_td_id,
                                'status'=>1
                            ]);
                        }else{

                            PresencesSceancesTd::create([
                                'etudiant_id'=>$etudiants_groupes_td->etudiant_id,
                                'seance_td_id'=>$request->sceance_td_id,
                                'status'=>0
                            ]);
                        }
                    }
                }
            }
        }else{
            return back();
        }
        return redirect()->route('Admin.Presencesceance.index', $request->sceance_td_id);
    }

    public function exportPDF($id){
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $id=(int)$id;
        // dd($id);
        $sceance=SceanceTd::find($id);
        // dd($sceance->intitule);
        // dd($sceance->groupe_td);
        if($sceance->groupe_td->td_special==null){
            // dd('ok');
            $td_bool=true;
            // $ue=Ue::find($td->ue_id);
        }else{
            $td_bool=false;
            // $ue=Ue::find($td->ue_id);

        }

        // dd($td_bool);
        // dd($td_bool);
        $presences_sceances=PresencesSceancesTd::where('seance_td_id', $id)
                                            ->where('status', 1)->get();
        $presences_sceances_Absent=PresencesSceancesTd::where('seance_td_id', $id)
                                            ->where('status', 0)->get();
        foreach($presences_sceances as $presences_sceance){
                    $data_etudiant[]=['noms'=>$presences_sceance->etudiant['noms'],
                                    'matricule'=>$presences_sceance->etudiant['matricule'],
                                    'id'=>$presences_sceance->id,
                                    'status'=>$presences_sceance->status];
                    // dd($etudiants_groupes_td->etudiant['noms']);
                }
        asort($data_etudiant);
        foreach($presences_sceances_Absent as $presences_sceance){
                    $data_etudiant_absent[]=['noms'=>$presences_sceance->etudiant['noms'],
                                    'matricule'=>$presences_sceance->etudiant['matricule'],
                                    'id'=>$presences_sceance->id,
                                    'status'=>$presences_sceance->status];
                    // dd($etudiants_groupes_td->etudiant['noms']);
                }
        asort($data_etudiant_absent);
        // dd($data_etudiant);
        $pdf=PDF::loadView('admin.pdf.Presence',[
            'presences_sceances_count'=>$presences_sceance->count(),
            'presences_sceances_Absent_count'=>$presences_sceances_Absent->count(),
            'presences_sceances'=>$data_etudiant,

            'presences_sceances_Absent'=>$data_etudiant_absent  ,
            'n'=>1,
            'sceance'=>$sceance,
            'td_bool'=>$td_bool
        ]);
        return $pdf->download('presence.pdf');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $id=(int)$id;
        // dd($id);
        $presences_sceance=PresencesSceancesTd::find((int)$id);
        // dd($presences_sceance);
        $etudiant=$presences_sceance->etudiant['noms'];
        return response()->json([
            'presence'=>$presences_sceance,
            'noms'=>$etudiant
        ]);

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
        if(Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        PresencesSceancesTd::where('id', $request->id)
                            ->update([
                                'status'=>$request->status
                            ]);
        $presences_sceance=PresencesSceancesTd::find($request->id);
        return response()->json($presences_sceance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        $presences_sceances=PresencesSceancesTd::where('seance_td_id', $id)->delete();
        return back();
    }
}
