<?php

namespace App\Http\Controllers\EcoleDoctorat;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\EcoleDoctorat\Dossier;

class MessageController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }

    public function index()
    {
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $messages=Message::latest()->paginate(50);
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('ecoleDoctorat.message.index',[
            'messages'=>$messages,
            'n'=>1,
            'message_i'=>1,
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
        if(! Gate::allows('super_admin', Auth::user()) && !  Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'titre'=>['required'],
            'contenu'=>['required']
        ]);
        $data=$request->only('titre', 'contenu');
        Message::create($data);
        return back();
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
        $message=Message::findOrFail($id);
        return response()->json($message);
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

        $request->validate([
            'titre'=>['required'],
            'contenu'=>['required']
        ]);
        $data=$request->only('titre', 'contenu');
        // dd($data);
        Message::where('id', $request->id)
                ->update($data);
        $message=Message::findOrFail($request->id);
        return response()->json($message);
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

        Message::where('id', $id)->delete();
        return back();
    }
}
