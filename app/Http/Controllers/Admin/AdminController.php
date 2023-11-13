<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Td;
use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Models\Admin\TdSpecial;
use App\Models\Etudiant\Etudiant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
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
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }

        // dd();
        $etudiant_nombre=Etudiant::all()->count();
        $niveaux=Niveau::select('id','code')->orderBy('code')->get();
        $filieres=Filiere::select('id', 'code')->orderBy('code')->get();
        if($filieres->count()>0){
            foreach($filieres as $filiere){
                $datas[$filiere->code]=Etudiant::where('filiere_id', $filiere->id)->get()->count();
            }
        }else{
            $datas['Aucune']=0;
        }
        if($niveaux->count()>0){
            foreach($niveaux as $niveau){
                $data[$niveau->code]=Etudiant::where('niveau_id', $niveau->id)->get()->count();
            }
        }
        else{
            $data['Aucun']=0;
        }


        return view('admin.index',[
            'etudiant_nombre'=>$etudiant_nombre,
            'datas'=>$data,
            'datas_filiere'=>$datas,
            'admin_i'=>1
        ]);
    }
    public function indexDept($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        return view('admin.indexDepartement',[
            'id'=>$id,
            'departement_i'=>1
        ]);
    }
    public function indexFil($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        return view('admin.indexFiliere',[
            'id'=>$id,
            'filiere_i'=>1
        ]);
    }
    public function indexNiv($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }

        return view('admin.indexNiveau',[
            'id'=>$id,
            'niveau_i'=>1,
        ]);
    }
    public function indexUE($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        $nombre_td=Td::where('ue_id', $id)->get()->count();
        $nombre_td_special=TdSpecial::where('ue_id', $id)->get()->count();
        return view('admin.indexUE',[
            'id'=>$id,
            'ue_i'=>1,
            'nombre_td'=>$nombre_td,
            'nombre_td_special'=>$nombre_td_special
        ]);
    }
    public function indexTd($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }

        return view('admin.indexTd',[
            'id'=>$id,
            'groupe_i'=>1
        ]);
    }
    public function indexTdSpecial($id){
        if(Gate::allows('doyen_Ecole', Auth::user()) ){
            abort(403);
        }
        return view('admin.indexTd',[
            'id'=>$id,
            'tdSpecial_id'=>$id,
            'groupe_i'=>1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
