<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\ChargeTd;
use App\Models\Admin\Enseignant;
use App\Models\Admin\Departement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GestionUtilisateurController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('super_admin', Auth::user())){
            // $enseignants=Enseignant::
            $utilisateurs = User::where('id', '<>', Auth::user()->id)->OrderBy('name')->paginate(50);
        }else{
            $utilisateurs=User::where('charge_td_id', '<>', 'null')->OrderBy('name')->paginate(50);
        }
        return view('admin.gestionUtilisateur.index',[
            'utilisateurs'=>$utilisateurs,
            'n'=>1,
            'utilisateur_i'=>1

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('super_admin', Auth::user())){

            $utilisateurs = User::select('enseignant_id')->where('enseignant_id', '<>', 'null')->get();
            // dd($utilisateurs);
            $enseignants=Enseignant::select('id', 'noms')->whereNotIn('id', $utilisateurs)->OrderBy('noms')->get();
            $departements=Departement::select('id', 'intitule')->OrderBy('intitule')->get();
        }else{
            $utilisateurs = User::select('charge_td_id')->where('charge_td_id', '<>', 'null')->get();
            // dd($utilisateurs);
            $enseignants=ChargeTd::select('id', 'noms')->whereNotIn('id', $utilisateurs)->OrderBy('noms')->get();
            // dd($enseignants);
            $departements=null;
        }
        return view('admin.gestionUtilisateur.create',[
            'enseignants'=>$enseignants,
            'utilisateur_c'=>1,
            'departements'=>$departements
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
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if(Gate::allows('super_admin', Auth::user())){
            $request->validate([
                'enseignant_id'=>['required', 'unique:users'],
                'profil_id'=>['required']
            ]);
            $enseignant=Enseignant::find($request->enseignant_id);
            $data=$request->only('enseignant_id', 'profil_id', 'departement_id');
        }else{
            $request->validate([
                'charge_td_id'=>['required', 'unique:users'],
                'profil_id'=>['required']
            ]);
            $enseignant=ChargeTd::find($request->charge_td_id);
            $data=$request->only('profil_id', 'charge_td_id');
        }
        if($request->password !=null){
            $data['password']=Hash::make($request->password);
        }else{
            $data['password']=Hash::make('default');
        }
        $data['email']=$enseignant->email;
        // dd($data['email']);
        $data['name']=$enseignant->noms;
        // dd($data);
        User::create($data);
        return redirect()->route('Admin.Utilisateur.index');
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
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        User::where('id', $id)->delete();
        return back();
    }
}
