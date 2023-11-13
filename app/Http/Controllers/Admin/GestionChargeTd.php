<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\ChargeTd;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class GestionChargeTd extends Controller
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
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $chargeTds=ChargeTd::latest()->paginate(50);
        return view('admin.gestionChargeTd.index',[
            'ChargeTds'=>$chargeTds,
            'n'=>1,
            'charge_i'=>1
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
        return view('admin.gestionChargeTd.create',[
            'charge_i'=>1
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
        $request->validate([
            'noms'=>['required', 'min:5', 'max:100', 'unique:charge_tds'],
            'telephone'=>['required', 'min:9', 'max:9'],
            'email'=>['email', 'max:100'],
        ]);
        $data=$request->only('noms', 'telephone', 'email',);
        $data['password']=Hash::make('default');
        ChargeTd::create($data);
        return redirect()->route('Admin.ChargeTd.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if($request->search==null){
            $chargeTds=ChargeTd::select('id', 'noms', 'telephone')->OrderBy('noms')->get();
        }else{
            $chargeTds=DB::table('charge_tds')
                            ->select('id', 'noms', 'telephone')
                            ->where('noms', 'likes', $request->search.'%')
                            ->OrderBy('noms')->get();
        }
        return response()->json($chargeTds);
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
        $chargeTd=ChargeTd::findOrFail($id);
        $chargeTd->delete();
        return back();
    }
}
