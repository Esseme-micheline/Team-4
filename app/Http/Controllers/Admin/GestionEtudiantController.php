<?php

namespace App\Http\Controllers\Admin;

// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\PDF;
use PDF;
use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Exports\EtudiantsExport;
use App\Imports\EtudiantsImport;
use App\Models\Etudiant\Etudiant;
use App\Models\EcoleDoctorat\Etat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EcoleDoctorat\Dossier;
use App\Models\EcoleDoctorat\Evolution;

class GestionEtudiantController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');

    }
    public function index(Request $request){
        // dd(Gate::allows('super_admin', Auth::user()));
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
            // dd(Auth::user()->departement->filieres);
            if(Auth::user()->departement->filieres->count()>0){
            foreach(Auth::user()->departement->filieres as $dept){
                $filiere_id[]=$dept->id;
            }
                $etudiants=Etudiant::select('id', 'noms', 'matricule', 'filiere_id', 'niveau_id')->whereIn('filiere_id', $filiere_id)->Orderby('noms')->paginate(50);
            }else{
                $etudiants=null;
            }
        }elseif(Gate::allows('doyen_Ecole', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->where('id', '>', 4)->orderBy('intitule')->get();
            $etudiants=Etudiant::select('id', 'noms', 'matricule', 'filiere_id', 'niveau_id')->where('niveau_id', '>', 4)->Orderby('noms')->paginate(50);
        }
        else{


            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
            $etudiants=Etudiant::select('id', 'noms', 'matricule', 'filiere_id', 'niveau_id')->Orderby('noms')->paginate(50);
        }
        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        /* dd($request->session()->has('ajoutetudiant'));
        if($request->session()->has('Ajout_Etudiant')){
            dd('ok');
            return view('admin.gestionEtudiant.index',[
                'etudiants'=>$etudiants,
                'filieres'=>$filieres,
                'niveaux'=>$niveaux,
                'ajout_nom'=>$request->session()->get('Ajout_Etudiant'),
                'n'=>1,
                'etudiant_i'=>1,
                'dossier_nombre_1'=>$dossier_nombre_1,
                'dossier_nombre'=>$dossier_nombre
            ]);
        } */
        return view('admin.gestionEtudiant.index',[
            'etudiants'=>$etudiants,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'n'=>1,
            'etudiant_i'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);

    }
    public function show(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }

        if($request->filiere_id !=null && $request->niveau_id !=null){
            return redirect()->route('Admin.etudiant.links', [$request->filiere_id, $request->niveau_id]);

        }elseif($request->filiere_id !=null && $request->niveau_id==null){
            if(Gate::allows('doyen_Ecole', Auth::user())){
                abort(403);
            }
            return redirect()->route('Admin.etudiant.links', [$request->filiere_id, 0]);
        }elseif($request->filiere_id ==null && $request->niveau_id!=null){
            if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
                abort(403);
            }else{
                return redirect()->route('Admin.etudiant.links', [0, $request->niveau_id]);
                            }

        }
        else{
            return redirect()->route('Admin.etudiant.index');
        }

    }
    public function links($filiere_id, $niveau_id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
        }elseif(Gate::allows('doyen_Ecole', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->where('id', '>', 4)->orderBy('intitule')->get();
        }
        else{
            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
       }

       $dossier_nombre=Dossier::where('status', 0)->get()->count();
       $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        if($filiere_id !=0 && $niveau_id !=0){
            $etudiants=Etudiant::where('filiere_id', $filiere_id)
                                ->where('niveau_id', $niveau_id)
                                ->OrderBy('noms')
                                ->paginate(50);
            return view('admin.gestionEtudiant.index',[
                'etudiants'=>$etudiants,
                'filieres'=>$filieres,
                'niveaux'=>$niveaux,
                'n'=>1,
                'filiere_id'=>$filiere_id,
                'niveau_id'=>$niveau_id,
                'dossier_nombre_1'=>$dossier_nombre_1,
                'dossier_nombre'=>$dossier_nombre
            ]);
        }elseif($filiere_id !=0 && $niveau_id ==0){
            $etudiants=Etudiant::where('filiere_id', $filiere_id)
                                ->OrderBy('noms')
                                ->paginate(50);
            return view('admin.gestionEtudiant.index',[
                'etudiants'=>$etudiants,
                'filieres'=>$filieres,
                'niveaux'=>$niveaux,
                'n'=>1,
                'filiere_id'=>$filiere_id,
                'niveau_id'=>$niveau_id,
                'dossier_nombre_1'=>$dossier_nombre_1,
                'dossier_nombre'=>$dossier_nombre
            ]);

        }elseif($filiere_id ==0 && $niveau_id !=0){
            $etudiants=Etudiant::where('niveau_id', $niveau_id)
                                ->OrderBy('noms')
                                ->paginate(50);
            return view('admin.gestionEtudiant.index',[
                'etudiants'=>$etudiants,
                'filieres'=>$filieres,
                'niveaux'=>$niveaux,
                'n'=>1,
                'filiere_id'=>$filiere_id,
                'niveau_id'=>$niveau_id,
                'dossier_nombre_1'=>$dossier_nombre_1,
                'dossier_nombre'=>$dossier_nombre
            ]);

        }else{
            return 'erreur';
        }
    }
    public function formImport(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'code')->where('departement_id', Auth::user()->departement_id)->orderBy('code')->get();
            $niveaux=Niveau::select('id', 'code')->OrderBy('code')->get();
        }elseif(Gate::allows('doyen_Ecole', Auth::user())){
            $filieres=Filiere::select('id', 'code')->orderBy('code')->get();
            $niveaux=Niveau::select('id', 'code')->where('id', '>', 4)->orderBy('code')->get();
        }
        else{

            $filieres=Filiere::select('id', 'code')->Orderby('code')->get();
            $niveaux=Niveau::select('id', 'code')->OrderBy('code')->get();
        }

        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('admin.gestionEtudiant.formImport',[
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'etudiant_i'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);
    }
    public function import(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        // dd($request->all());
        (new EtudiantsImport($request->niveau_id, $request->filiere_id))->import(request()->file('import'));
        return redirect()->route('Admin.etudiant.index');
    }
    public function formExport(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }

        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        if($request->filiere_id !=0 && $request->niveau_id !=0){

            return view('admin.gestionEtudiant.formExport',[
                'filiere_id'=>$request->filiere_id,
                'niveau_id'=>$request->niveau_id,
                'etudiant_i'=>1
            ]);
        }elseif($request->filiere_id !=0 && $request->niveau_id==0){
            return view('admin.gestionEtudiant.formExport',[
                'filiere_id'=>$request->filiere_id,
                'etudiant_i'=>1
            ]);
        }elseif($request->filiere_id ==0 && $request->niveau_id!=0){
            if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
                abort(403);
            }else{
            return view('admin.gestionEtudiant.formExport',[
                'niveau_id'=>$request->niveau_id,
                'etudiant_i'=>1
            ]);
        }
        }else{
            if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
                abort(403);
            }else{
                return view('admin.gestionEtudiant.formExport',[
                    'etudiant_i'=>1
                ]);
            }
        }

    }
    public function export(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'export'=>['required']
        ]);

        // dd($request);
        if($request->filiere_id !=0 && $request->niveau_id !=0){
            $filiere=Filiere::find($request->filiere_id)->code;
            $niveau=Niveau::find($request->niveau_id)->code;
            $doss=$filiere.'_'.$niveau.'_'.date('Y').'-'.date('Y', strtotime('+1 year'));
            if($request->export=='xlsx'){
                return Excel::download(new EtudiantsExport($request->niveau_id, $request->filiere_id), $doss.'.xlsx');
            }elseif($request->export=='csv'){
                return Excel::download(new EtudiantsExport($request->niveau_id, $request->filiere_id), $doss.'.csv');
            }
            elseif($request->export=='pdf'){
                $filiere=Filiere::find($request->filiere_id);
                // dd($filiere->intitule);
                $niveau=Niveau::find($request->niveau_id)->code;
                $etudiants=Etudiant::select('matricule', 'noms')->where('filiere_id', $request->filiere_id)
                                ->where('niveau_id', $request->niveau_id)
                                ->OrderBy('noms')
                                ->get();
                $pdf = PDF::loadView('admin.pdf.Etudiant', [
                    'etudiants'=>$etudiants,
                    'niveau'=>$niveau,
                    'filiere'=>$filiere,
                    'n'=>1
                ]);
                return $pdf->download( $doss.'.pdf');
            }else{
                return back();
            }
        }elseif($request->filiere_id !=0 && $request->niveau_id==0){
            $filiere=Filiere::find($request->filiere_id)->code;
            $niveau=Niveau::find($request->niveau_id)->code;
            $doss=$filiere.'_'.date('Y').'-'.date('Y', strtotime('+1 year'));
            if($request->export=='xlsx'){
                return Excel::download(new EtudiantsExport(0, $request->filiere_id), $doss.'.xlsx');
            }elseif($request->export=='csv'){
                return Excel::download(new EtudiantsExport(0, $request->filiere_id), $doss.'.csv');
            }

            elseif($request->export=='pdf'){
                $filiere=Filiere::find($request->filiere_id);
                $etudiants=Etudiant::select('matricule', 'noms')->where('filiere_id', $request->filiere_id)
                                ->OrderBy('noms')
                                ->get();
                $pdf = PDF::loadView('admin.pdf.Etudiant', [
                    'etudiants'=>$etudiants,
                    'n'=>1,
                    'filiere'=>$filiere
                ]);
                return $pdf->download($doss.'.pdf');
            }else{
                return back();
            }
        }elseif($request->filiere_id ==0 && $request->niveau_id!=0){
            $filiere=Filiere::find($request->filiere_id)->code;
            $niveau=Niveau::find($request->niveau_id)->code;
            $doss=$niveau.'_'.date('Y').'-'.date('Y', strtotime('+1 year'));
            if($request->export=='xlsx'){
                return Excel::download(new EtudiantsExport($request->niveau_id, 0), $doss.'.xlsx');
            }elseif($request->export=='csv'){
                return Excel::download(new EtudiantsExport($request->niveau_id, 0), $doss.'.csv');
            }

            elseif($request->export=='pdf'){
                $niveau=Niveau::find($request->niveau_id)->code;
                $etudiants=Etudiant::select('matricule', 'noms')->where('niveau_id', $request->niveau_id)
                                ->OrderBy('noms')
                                ->get();
                $pdf = PDF::loadView('admin.pdf.Etudiant', [
                    'etudiants'=>$etudiants,
                    'n'=>1,
                    'niveau'=>$niveau
                ]);
                return $pdf->download($doss.'.pdf');
            }else{
                return back();
            }
        }else{
            $doss='ANNEE_'.date('Y').'-'.date('Y', strtotime('+1 year'));
            if($request->export=='xlsx'){
                return Excel::download(new EtudiantsExport(0, 0), $doss.'.xlsx');
            }elseif($request->export=='csv'){
                return Excel::download(new EtudiantsExport(0, 0), $doss.'.csv');
            }

            elseif($request->export=='pdf'){
                $etudiants=Etudiant::select('matricule', 'noms')->get();
                $pdf = PDF::loadView('admin.pdf.Etudiant', [
                    'etudiants'=>$etudiants,
                    'n'=>1
                ]);
                return $pdf->download($doss.'.pdf');
            }else{
                return back();
            }
        }


    }
    public function create(){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if(Gate::allows('doyen_Ecole', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->orderBy('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->where('id', '>', 4)->orderBy('intitule')->get();

        }else{

            $filieres=Filiere::select('id', 'intitule')->orderby('intitule')->get();
            $niveaux=Niveau::select('id', 'intitule')->orderby('intitule')->get();
        }

        $dossier_nombre=Dossier::where('status', 0)->get()->count();
        $dossier_nombre_1=Dossier::where('status', '>', 0)->get()->count();
        return view('admin.gestionEtudiant.create',[
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'etudiant_c'=>1,
            'dossier_nombre_1'=>$dossier_nombre_1,
            'dossier_nombre'=>$dossier_nombre
        ]);
    }
    public function createFil($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
        }else{
            $filieres=Filiere::select('id', 'intitule')->orderby('intitule')->get();

        }

        $niveaux=Niveau::select('id', 'intitule')->orderby('intitule')->get();
        return view('admin.gestionEtudiant.create',[
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'filiere_id'=>$id,
            'etudiant_c'=>1
        ]);
    }
    public function createNiv($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user())){
            abort(403);
        }
        $filieres=Filiere::select('id', 'intitule')->orderby('intitule')->get();
        $niveaux=Niveau::select('id', 'intitule')->orderby('intitule')->get();
        return view('admin.gestionEtudiant.create',[
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
            'niveau_id'=>$id,
            'etudiant_c'=>1,
        ]);
    }
    public function store(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'matricule'=>['required', 'unique:etudiants', 'min:3', 'max:20'],
            'noms'=>['required', 'string', 'max:100'],
            'niveau_id'=>['required', 'integer'],
            'filiere_id'=>['required', 'integer']
        ]);
        $data=$request->only('matricule', 'noms', 'filiere_id', 'niveau_id');
        $data['password']=Hash::make('default');
        Etudiant::create($data);
        return redirect()->route('Admin.etudiant.index');
    }
    public function reset($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        Etudiant::where('id', $id)
                ->update([
                    'password' => Hash::make('default')
                ]);
        Evolution::create([
            'acteur'=>"Administrateur",
            'etat_id'=>10,
            'etudiant_id'=>$id,
            'objet'=>'Demande de reinitialisation du mot de passe'
        ]);
        return back();

    }
    public function showEt(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        if( Gate::allows('chef_Dept', Auth::user()) || Gate::allows('secretaire', Auth::user())){
            // $filieres=Filiere::select('id', 'intitule')->where('departement_id', Auth::user()->departement_id)->orderBy('intitule')->get();
            // $niveaux=Niveau::select('id', 'intitule')->orderBy('intitule')->get();
            // dd(Auth::user()->departement->filieres);
            if(Auth::user()->departement->filieres->count()>0){
            foreach(Auth::user()->departement->filieres as $dept){
                $filiere_id[]=$dept->id;
            }
            if($request->search==null){

                $etudiants=Etudiant::select('id', 'noms', 'matricule', 'filiere_id', 'niveau_id')->whereIn('filiere_id', $filiere_id)->Orderby('noms')->get();
                }else{
                    $etudiants=DB::table('etudiants')
                                ->select('id', 'matricule', 'noms', 'filiere_id', 'niveau_id')
                                ->whereIn('filiere_id', $filiere_id)
                                ->where('noms', 'like', $request->search.'%')
                                ->OrderBy('noms')
                                ->get();
                }
            }else{
                $etudiants=null;
            }
        }elseif(Gate::allows('doyen_Ecole', Auth::user())){
            if($request->search==null){
                $etudiants=Etudiant::select('id', 'noms', 'matricule',  'filiere_id', 'niveau_id')->where('niveau_id', '>', 4)->orderBy('noms')->get();
            }else{
                $etudiants=DB::table('etudiants')
                                ->select('id', 'matricule', 'noms', 'filiere_id', 'niveau_id')
                                ->where('noms', 'like', $request->search.'%')
                                ->where('niveau_id', '>', 4)
                                ->OrderBy('noms')
                                ->get();
            }
        }
        else{

            if($request->search==null){
                $etudiants=Etudiant::select('id', 'noms', 'matricule',  'filiere_id', 'niveau_id')->orderBy('noms')->get();
            }else{
                $etudiants=DB::table('etudiants')
                                ->select('id', 'matricule', 'noms', 'filiere_id', 'niveau_id')
                                ->where('noms', 'like', $request->search.'%')
                                ->OrderBy('noms')
                                ->get();
            }
            // dd($etudiants);
        }
        $filieres=Filiere::select('id', 'code')->get();
        $niveaux=Niveau::select('id', 'code')->get();
        return response()->json([
            'etudiants'=>$etudiants,
            'filieres'=>$filieres,
            'niveaux'=>$niveaux,
        ]);

    }
    public function edit($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $etudiant=Etudiant::findOrfail($id);
        return response()->json($etudiant);
    }
    public function update(Request $request){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $request->validate([
            'noms'=>['required', 'min:3'],
        ]);
        if($request->matricule !=null){
            $data=$request->only('matricule', 'noms','telephone', 'email');
            Etudiant::where('id', $request->id)
                        ->update($data);
        }else{
            Etudiant::where('id', $request->id)
                        ->update([
                            'niveau_id'=>$request->niveau_id
                        ]);
        }
        $etudiant=Etudiant::find($request->id);
        Evolution::create([
            'acteur'=>"Administrateur",
            'etat_id'=>11,
            'etudiant_id'=>$request->id,
            'objet'=>'Requete'
        ]);
        $niveaux=Niveau::select('id', 'code')->get();
        return response()->json([
            'etudiant'=>$etudiant,
            'niveaux'=>$niveaux
        ]);
    }
    public function destroy($id){
        if(! Gate::allows('super_admin', Auth::user()) && ! Gate::allows('chef_Dept', Auth::user()) && ! Gate::allows('secretaire', Auth::user()) && ! Gate::allows('doyen_Ecole', Auth::user())){
            abort(403);
        }
        $etudiant=Etudiant::find($id);
        $etudiant->delete();
        return back();
    }
}
