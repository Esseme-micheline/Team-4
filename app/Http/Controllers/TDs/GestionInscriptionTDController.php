<?php

namespace App\Http\Controllers\TDs;

use App\Models\Admin\Td;
use App\Models\Admin\Ue;
use App\Models\Admin\Niveau;
use Illuminate\Http\Request;
use App\Models\Admin\Filiere;
use App\Models\Admin\GroupeTd;
use App\Models\Etudiant\Etudiant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Etudiant\EtudiantGroupeTd;

class GestionInscriptionTDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $filieres= Filiere::select('id', 'code', 'intitule')->OrderBy('intitule')->get();
        $ues=Ue::select('id', 'code', 'intitule')->OrderBy('code')->get();
        return view('TDs.indexUe',[
            'ues'=>$ues
        ]);
    }
    public function createForm($id)
    {
        $niveaux=Niveau::select('id', 'intitule')->where('id', '<', 5)->get();
        $filieres= Filiere::select('id', 'code', 'intitule')->OrderBy('intitule')->get();
        $ue=Ue::find($id);
        return view('TDs.formEtudiant', [
            'niveaux'=>$niveaux,
            'filieres'=>$filieres,
            'ue'=>$ue,
            'id'=>$id
        ]);
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'noms'=>['required', 'min:4', 'max:100', 'unique:etudiants'],
            'telephone'=>['required', 'unique:etudiants', 'integer', 'min:650000000', 'max:699999999'],
            'email'=>['max:100'],
            'filiere_id'=>['required', 'integer'],
            'niveau_id'=>['required', 'integer'],
        ]);
        // dd($request->all());
        $data=$request->only('noms', 'telephone', 'email', 'filiere_id', 'niveau_id');
        $data['password']=Hash::make('default');
        // dd($request->session()->get('ajoutetudiant'));
        Etudiant::create($data);
        $request->session()->flash('Ajout_nouv', $request->noms.' Votre mot de passe pars defaut est "default". Svp retenez bien se mot de passe est respecter bien l\'authographe. Vous pouvez maintenant entrez vos information personnel et vous inscrire.');
        return redirect()->route('Inscription.showTdUe', $id);
    }

    public function show_niv(){
        $niveaux=Niveau::select('id', 'intitule')->where('id', '<', 5)->get();
        return response()->json($niveaux);
    }

    public function show($niv_id, $fil_id)
    {
        // dd('ok');
        $ues=Ue::select('id', 'code', 'intitule')->where('filiere_id', $fil_id)->where('niveau_id', $niv_id)->OrderBy('intitule')->get();
        foreach($ues as $ue){
             foreach($ue->tds as $td){
                $td->groupeTds;
             }

        }
        return response()->json($ues);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTdUe(Request $request, $id)
    {
        $ue=Ue::find($id);
        $tds=Td::select('id')->where('ue_id', $id)->get();
        $groupeTds=GroupeTd::select('id', 'intitule', 'periode', 'capacite', 'salle')->whereIn('td_id', $tds)->OrderBy('salle')->get();
        $groupeTds_ids=GroupeTd::select('id')->whereIn('td_id', $tds)->get();
        $etudiant_groupe_td=[];
        foreach($groupeTds_ids as $groupeTds_id){
            $key=EtudiantGroupeTd::select('groupe_td_id')->where('groupe_td_id', $groupeTds_id->id)->get()->count();
            $etudiant_groupe_td[$groupeTds_id->id]=$key;
        }
        if($request->session()->has('Inscription_reussi')){
            return view('TDs.showTd', [
                'ue'=>$ue,
                'groupeTds'=>$groupeTds,
                'etudiant_groupe_td'=>$etudiant_groupe_td,
                'inscription_reussi'=>$request->session()->get('Inscription_reussi')
            ]);
        }
        if($request->session()->has('Inscription_deja')){
            return view('TDs.showTd', [
                'ue'=>$ue,
                'groupeTds'=>$groupeTds,
                'etudiant_groupe_td'=>$etudiant_groupe_td,
                'inscription_deja'=>$request->session()->get('Inscription_deja')
            ]);
        }
        if($request->session()->has('Inscription_erreur')){
            return view('TDs.showTd', [
                'ue'=>$ue,
                'groupeTds'=>$groupeTds,
                'etudiant_groupe_td'=>$etudiant_groupe_td,
                'inscription_erreur'=>$request->session()->get('Inscription_erreur')
            ]);
        }
        if($request->session()->has('Ajout_nouv')){
            return view('TDs.showTd', [
                'ue'=>$ue,
                'groupeTds'=>$groupeTds,
                'etudiant_groupe_td'=>$etudiant_groupe_td,
                'inscription_reussi'=>$request->session()->get('Ajout_nouv')
            ]);
        }
        if($request->session()->has('Inscription_plein')){
            return view('TDs.showTd', [
                'ue'=>$ue,
                'groupeTds'=>$groupeTds,
                'etudiant_groupe_td'=>$etudiant_groupe_td,
                'inscription_plein'=>$request->session()->get('Inscription_plein')
            ]);
        }
        return view('TDs.showTd', [
            'ue'=>$ue,
            'groupeTds'=>$groupeTds,
            'etudiant_groupe_td'=>$etudiant_groupe_td
        ]);

    }
    public function signTd(Request $request, $id){
        if($request->session()->has('Ajout_nouv')){
            return view('TDs.log', [
                'ajout_nouv'=>$request->session()->get('Ajout_nouv'),
                'id'=>$id
            ]);
        }
        return view('TDs.log', [
            'id'=>$id
        ]);
    }
    public function RegistrationTD(Request $request, $id){
            $request->validate([
                'username'=>['required', 'max:9'],
                'password'=>['required']
            ]);

        $matricule = $request->username;
        $password = $request->password;
        $groupeTd=GroupeTd::find($request->id);
        if (Auth::guard('webetudiant')->attempt(['matricule' => $matricule, 'password' => $password])) {
            // dd('ok');
            $etudiant=Etudiant::where('matricule', $matricule)->get();

            if($groupeTd->td->ue->filiere_id==$etudiant[0]->filiere_id){
                if($groupeTd->td->ue->niveau_id==$etudiant[0]->niveau_id){
                    $td_id=$groupeTd->td->id;
                    $groupeTds=GroupeTd::where('td_id', $td_id)->select('id')->get();
                    if(EtudiantGroupeTd::where('etudiant_id', $etudiant[0]->id)->whereIn('groupe_td_id', $groupeTds)->get()->count()==0){
                        if($groupeTd->capicite - EtudiantGroupeTd::where('groupe_td_id', $id)->get()->count() >0){
                            EtudiantGroupeTd::create([
                                'etudiant_id'=>$etudiant[0]->id,
                                'groupe_td_id'=>$id
                            ]);
                            $request->session()->flash('Inscription_reussi', $etudiant[0]->noms.', vous venez de vous inscrire au groupe de '.$groupeTd->intitule);
                        }else{
                            $request->session()->flash('Inscription_plein', $etudiant[0]->noms.', le nombre total de places pour le groupe '.$groupeTd->intitule.' est atteint. Essayer un autre groupe');
                        }


                    }else{
                        // dd('Erreur');
                        $request->session()->flash('Inscription_deja', $etudiant[0]->noms.', vous vous etes déja inscrire à un groupe de TD pour cette UE.');
                    }
                }
                else{
                    $request->session()->flash('Inscription_erreur', $etudiant[0]->noms.', vous n\'etes pas authorisée à vous inscrire a se groupe de TD.');
                }
            }else{
                $request->session()->flash('Inscription_erreur', $etudiant[0]->noms.', vous n\'etes pas authorisée à vous inscrire a se groupe de TD.');
            }
            // return redirect()->route('etudiant.td');
        }elseif(Auth::guard('webetudiant')->attempt(['telephone' => $matricule, 'password' => $password])){
            // dd('erre');
            $etudiant=Etudiant::where('telephone', $matricule)->get();
            // $groupeTd=GroupeTd::find($id);
            if($groupeTd->td->ue->filiere_id==$etudiant[0]->filiere_id){
                if($groupeTd->td->ue->niveau_id==$etudiant[0]->niveau_id){
                    $td_id=$groupeTd->td->id;
                    $groupeTds=GroupeTd::where('td_id', $td_id)->select('id')->get();
                    if(EtudiantGroupeTd::where('etudiant_id', $etudiant[0]->id)->whereIn('groupe_td_id', $groupeTds)->get()->count()==0){

                        if($groupeTd->capicite - EtudiantGroupeTd::where('groupe_td_id', $id)->get()->count() >0){
                            EtudiantGroupeTd::create([
                                'etudiant_id'=>$etudiant[0]->id,
                                'groupe_td_id'=>$id
                            ]);
                            $request->session()->flash('Inscription_reussi', $etudiant[0]->noms.', vous venez de vous inscrire au groupe de '.$groupeTd->intitule);
                        }else{
                            $request->session()->flash('Inscription_plein', $etudiant[0]->noms.', le nombre total de places pour le groupe '.$groupeTd->intitule.' est atteint. Essayer un autre groupe');
                        }

                    }else{
                        // dd('Erreur');
                        $request->session()->flash('Inscription_deja', $etudiant[0]->noms.', vous vous etes déja inscrire à un groupe de TD pour cette UE.');
                    }
                }
                else{
                    $request->session()->flash('Inscription_erreur', $etudiant[0]->noms.', vous n\'etes pas authorisée à vous inscrire a se groupe de TD.');
                }
            }else{
                $request->session()->flash('Inscription_erreur', $etudiant[0]->noms.', vous n\'etes pas authorisée à vous inscrire a se groupe de TD.');
            }
            // 650864735
        }
         else {
            return redirect()->back()->withErrors([
                'mdp' => 'Verifier le matricule et le mot de passe, puis reessayer !'
            ]);
        }
        return redirect()->route('Inscription.showTdUe', $groupeTd->td->ue->id);
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
