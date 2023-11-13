<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\ChargeTd;
use App\Models\Admin\Enseignant;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
        // dd(Auth::user());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(Auth::user());
        //   $password=$request->session()->get('password');
        if($request->session()->has('echec')){
            $value= $request->session()->get('echec');
            // dd($value);
            return view('admin.user.index',[
                'user_i'=>1,
                'value'=>$value
            ]);
        }
        if($request->session()->has('success')){
            $success= $request->session()->get('success');
            // dd($value);
            return view('admin.user.index',[
                'user_i'=>1,
                'success'=>$success
            ]);
        }
        return view('admin.user.index',[
            'user_i'=>1,
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
        if($request->email !=Auth::user()->email){


            $request->validate([
                'name'=>['required', 'min:2', 'max:100'],
                'email'=>['required', 'email', 'unique:users'],
                'telephone'=>['max:9']
            ]);
            $data=$request->only('name', 'email');
            User::where('id', Auth::user()->id)
                ->update($data);
            if(Auth::user()->profil_id !=5){

                Enseignant::where('id', Auth::user()->enseignant_id)
                            ->update([
                                'noms'=>$request->name,
                                'telephone'=>$request->telephone,
                                'email'=>$request->email,
                                'bureau'=>$request->bureau
                            ]);
            }else{
                ChargeTd::where('id', Auth::user()->enseignant_id)
                        ->update([
                            'noms'=>$request->name,
                                'telephone'=>$request->telephone,
                                'email'=>$request->email,
                        ]);
            }
        }else{
            $request->validate([
                'name'=>['required', 'min:2', 'max:100'],
                'telephone'=>['max:9']
            ]);
            $data=$request->only('name');
            User::where('id', Auth::user()->id)
                ->update($data);
                if(Auth::user()->profil_id !=5){

                    Enseignant::where('id', Auth::user()->enseignant_id)
                        ->update([
                            'noms'=>$request->name,
                            'telephone'=>$request->telephone,
                            'bureau'=>$request->bureau
                        ]);
                }else{
                    ChargeTd::where('id', Auth::user()->enseignant_id)
                            ->update([
                                'noms'=>$request->name,
                                    'telephone'=>$request->telephone,
                            ]);
                }

        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storePassword(Request $request)
    {
        // dd('ok');
        if(Hash::check($request->cpassword, Auth::user()->password)){
            $request->validate([
                'password' => ['required', 'confirmed'],
            ]);
            // , Rules\Password::defaults()
            User::where('id', Auth::user()->id)
                ->update([
                    'password'=>Hash::make($request->password)
                ]);
                $request->session()->flash('success', 'Changement reussi');
                // Session::put('success', "Changement Reussi");
                // return view('admin.user.index',[
                //     'success'=>"Changement reussi",
                //     'user_i'=>1,
                // ]);
        }else{
                $request->session()->flash('echec', 'Echec de changement');
                // return redirect()->route('Admin.user.index');
            }
        return redirect()->route('Admin.user.index');

        // Auth::verify()=$request->session()->get('password');
        // if($request->session()->has('success')){

        // }

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
