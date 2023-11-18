<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GestionChargeTd;
use App\Http\Controllers\Admin\RequeteController;
use App\Http\Controllers\Admin\GestionTDController;
use App\Http\Controllers\Admin\GestionUEsController;
use App\Http\Controllers\Admin\GestionClubController;
use App\Http\Controllers\EcoleDoctorat\JuryController;
use App\Http\Controllers\Admin\GestionNiveauController;
use App\Http\Controllers\EcoleDoctorat\EmailController;
use App\Http\Controllers\Admin\GestionFiliereController;
use App\Http\Controllers\Admin\GestionSceanceController;
use App\Http\Controllers\Admin\GestionEtudiantController;
use App\Http\Controllers\Admin\GestionGroupeTDController;
use App\Http\Controllers\EcoleDoctorat\ArchiveController;
use App\Http\Controllers\EcoleDoctorat\DossierController;
use App\Http\Controllers\EcoleDoctorat\MessageController;
use App\Http\Controllers\Admin\GestionEnseignantController;
use App\Http\Controllers\EcoleDoctorat\ReportingController;
use App\Http\Controllers\Admin\GestionAttributionController;
use App\Http\Controllers\Admin\GestionDepartementController;
use App\Http\Controllers\Admin\GestionUtilisateurController;
use App\Http\Controllers\TDs\GestionInscriptionTDController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EcoleDoctorat\InscriptionController;
use App\Http\Controllers\Admin\GestionSceancePresenceController;
use App\Http\Controllers\EcoleDoctorat\UniteRechercheController;
use App\Http\Controllers\EcoleDoctorat\EtudiantDossierController;
use App\Http\Controllers\Visiteur\VisiteurController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\EtudiantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from Codersvibe.com',
        'body' => 'This is my first mail using Gmail SMTP'
    ];
   
    \Mail::to('audreyesseme@gmail.com')->send(new \App\Mail\MyMail($details));
   
    dd("Email is Sent.");
});
// Route qui permet de connaître la langue active
Route::get('locale', 'LocalizationController@getLang')->name('getlang');

// Route qui permet de modifier la langue
Route::get('locale/{lang}', [LocalizationController::class, 'setLang'])->name('setlang');


Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::get('/', [VisiteurController::class, 'index'])->name('visiteur.all');

Route::get('/project/{projId}', [VisiteurController::class, 'single_project'])->name('visiteur.single');
Route::get('/soummetre', [VisiteurController::class, 'create'])->name('visiteur.creer');
Route::post('/soummetre',[VisiteurController::class, 'store'])->name('visiteur.store');
Route::get('/soummetre_Finale', [VisiteurController::class, 'createSecond'])->name('visiteur.creerFinale');
Route::post('/soummetre_Finale', [VisiteurController::class, 'storeSecond'])->name('visiteur.storeFinale');
Route::get('/download/{projId}/{filePath}',[VisiteurController::class, 'download'])->name('visitor.downloadPdf');
Route::get('/category/{category}', [VisiteurController::class, 'getCate'])->name('visiteur.all.category');
Route::get('/search', [VisiteurController::class, 'search'])->name('visiteur.search');
Route::post('/search', [VisiteurController::class, 'searchResults'])->name('visiteur.searchResults');

// New route for extracting text from the PDF 
Route::get('/extractText', [VisiteurController::class, 'extractText'])->name('visiteur.extractText');
Route::post('/extract-memoire-text', [VisiteurController::class, 'extractMemoireText'])->name('visiteur.extractMemoireText');
Route::get('/ai-side', [VisiteurController::class, 'aiSide'])->name('visiteur.aiSide');
Route::post('/aiSearchMemoire', [VisiteurController::class, 'aiSearchMemoire'])->name('visiteur.aiSearchMemoire');
Route::post('/ai-analysis', [VisiteurController::class, 'aiAnalysis'])->name('visiteur.aiAnalysis');



// Route::get('/extractText', [VisiteurController::class, 'extractText'])->name('visiteur.extractText');
// Route::get('/extract-memoire-text/{projId}', [VisiteurController::class, 'extractMemoireText'])->name('visiteur.extractMemoireText');

// Route::get('/Inscription/TDs/{niv_id}/{fil_id}', [GestionInscriptionTDController::class, 'show'])->name('Inscription.show');
// Route::get('/Inscription/Niveau', [GestionInscriptionTDController::class, 'show_niv'])->name('Inscription.show_niv');
// Route::get('/Inscription/GroupeTd/{id}', [GestionInscriptionTDController::class, 'showTdUe'])->name('Inscription.showTdUe');














// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('Admin/User/index', [UserController::class, 'index'])->name('Admin.user.index'); 
Route::post('Admin/User/store', [UserController::class, 'store'])->name('Admin.user.store');
Route::post('Admin/User/storePassword', [UserController::class, 'storePassword'])->name('Admin.user.storePassword');
// Route::get('Admin/User/', [UserController::class, ''])->name('Admin.user');
// Route::get('Admin/User/', [UserController::class, ''])->name('Admin.user');
// Route::get('Admin/User/', [UserController::class, ''])->name('Admin.user');

/* Route Gestion Utilisateur */
Route::get('Admin/Utilisateur/create', [GestionUtilisateurController::class, 'create'])->name('Admin.Utilisateur.create');
Route::post('Admin/Utilisateur/store', [GestionUtilisateurController::class, 'store'])->name('Admin.Utilisateur.store');
Route::get('Admin/Utilisateur/index', [GestionUtilisateurController::class, 'index'])->name('Admin.Utilisateur.index');
Route::get('Admin/Utilisateur/delete/{id}', [GestionUtilisateurController::class, 'destroy'])->name('Admin.Utilisateur.delete');

/* Route pour les admin */
Route::get('Admin', [AdminController::class, 'index'])->name('Admin.index');
Route::get('Admin/indexDept/{id}', [AdminController::class, 'indexDept'])->name('Admin.indexDept');
Route::get('Admin/indexFil/{id}', [AdminController::class, 'indexFil'])->name('Admin.indexFil');
Route::get('Admin/indexNiv/{id}', [AdminController::class, 'indexNiv'])->name('Admin.indexNiv');
Route::get('Admin/indexUE/{id}', [AdminController::class, 'indexUE'])->name('Admin.indexUE');
Route::get('Admin/indexTd/{id}', [AdminController::class, 'indexTd'])->name('Admin.indexTd');
Route::get('Admin/indexTdSpecial/{id}', [AdminController::class, 'indexTdSpecial'])->name('Admin.indexTdSpecial');

/* Attribution */
Route::get('Admin/Attribution/index', [GestionAttributionController::class, 'index'])->name('Admin.attribution.index');
/* Creation */
Route::get('Admin/Attribution/create/{id}', [GestionAttributionController::class, 'create'])->name('Admin.attribution.create');
Route::get('Admin/Attribution/createAt', [GestionAttributionController::class, 'createAt'])->name('Admin.attribution.createAt');
Route::post('Admin/Attribution/store', [GestionAttributionController::class, 'store'])->name('Admin.attribution.store');
/* Suppression */
Route::get('Admin/Attribution/delete/{id}', [GestionAttributionController::class, 'destroy'])->name('Admin.attribution.delete');

/* Charge Td */
Route::get('Admin/ChargeTd/index', [GestionChargeTd::class, 'index'])->name('Admin.ChargeTd.index');
Route::get('Admin/ChargeTd/show', [GestionChargeTd::class, 'show'])->name('Admin.ChargeTd.show');
Route::get('Admin/ChargeTd/create', [GestionChargeTd::class, 'create'])->name('Admin.ChargeTd.create');
Route::post('Admin/ChargeTd/store', [GestionChargeTd::class, 'store'])->name('Admin.ChargeTd.store');
Route::get('Admin/ChargeTd/delete/{id}', [GestionChargeTd::class, 'destroy'])->name('Admin.ChargeTd.delete');

/* Gestion Club */
Route::get('Admin/Club/index', [GestionClubController::class, 'index'])->name('Admin.club.index');
/* Ajax club */
Route::get('Admin/Club/showC', [GestionClubController::class, 'showC'])->name('Admin.club.showC');
Route::get('Admin/Club/show', [GestionClubController::class, 'show'])->name('Admin.club.show');
Route::get('Admin/Club/showDept/{id}', [GestionClubController::class, 'showDept'])->name('Admin.club.showDept');
Route::get('Admin/Club/create/{id}', [GestionClubController::class, 'create'])->name('Admin.club.create');
Route::post('Admin/Club/store', [GestionClubController::class, 'store'])->name('Admin.club.store');
Route::get('Admin/Club/edit', [GestionClubController::class, 'edit'])->name('Admin.club.edit');
Route::post('Admin/Club/update', [GestionClubController::class, 'update'])->name('Admin.club.update');
Route::get('Admin/Club/delete/{id}', [GestionClubController::class, 'destroy'])->name('Admin.club.delete');

/* Gestion Departement */
Route::get('Admin/Departement/index', [GestionDepartementController::class, 'index'])->name('Admin.departement.index');
Route::get('Admin/Departement/show', [GestionDepartementController::class, 'show'])->name('Admin.departement.show');
Route::get('Admin/Departement/create', [GestionDepartementController::class, 'create'])->name('Admin.departement.create');
Route::post('Admin/Departement/store', [GestionDepartementController::class, 'store'])->name('Admin.departement.store');
Route::get('Admin/Departement/edit', [GestionDepartementController::class, 'edit'])->name('Admin.departement.edit');
Route::post('Admin/Departement/update', [GestionDepartementController::class, 'update'])->name('Admin.departement.update');
Route::get('Admin/Departement/delete/{id}', [GestionDepartementController::class, 'destroy'])->name('Admin.departement.delete');

/* Gestion Enseignant */
Route::get('Admin/Enseignant/index', [GestionEnseignantController::class, 'index'])->name('Admin.enseignant.index');
Route::get('Admin/Enseignant/voir/{id}', [GestionEnseignantController::class, 'voir'])->name('Admin.enseignant.voir');
Route::get('Admin/Enseignant/show', [GestionEnseignantController::class, 'show'])->name('Admin.enseignant.show');
Route::get('Admin/Enseignant/create', [GestionEnseignantController::class, 'create'])->name('Admin.enseignant.create');
Route::post('Admin/Enseignant/store', [GestionEnseignantController::class, 'store'])->name('Admin.enseignant.store');
Route::get('Admin/Enseignant/delete/{id}', [GestionEnseignantController::class, 'destroy'])->name('Admin.enseignant.delete');

/* Gestion Etudiant */
Route::get('Admin/Etudiant/index', [GestionEtudiantController::class, 'index'])->name('Admin.etudiant.index');
Route::get('Admin/Etudiant/show', [GestionEtudiantController::class, 'show'])->name('Admin.etudiant.show');
Route::get('Admin/Etudiant/show/{filiere_id}/{niveau_id}', [GestionEtudiantController::class, 'links'])->name('Admin.etudiant.links');
Route::get('Admin/Etudiant/formImport', [GestionEtudiantController::class, 'formImport'])->name('Admin.Etudiant.formImport');
Route::post('Admin/Etudiant/import', [GestionEtudiantController::class, 'import'])->name('Admin.Etudiant.import');
Route::get('Admin/Etudiant/formExport', [GestionEtudiantController::class, 'formExport'])->name('Admin.etudiant.formExport');
Route::post('Admin/Etudiant/export', [GestionEtudiantController::class, 'export'])->name('Admin.etudiant.export');
Route::get('Admin/Etudiant/create', [GestionEtudiantController::class, 'create'])->name('Admin.etudiant.create');
Route::get('Admin/Etudiant/createFil/{id}', [GestionEtudiantController::class, 'createFil'])->name('Admin.etudiant.createFil');
Route::get('Admin/Etudiant/createNiv/{id}', [GestionEtudiantController::class, 'createNiv'])->name('Admin.etudiant.createNiv');
Route::post('Admin/Etudiant/create', [GestionEtudiantController::class, 'store'])->name('Admin.etudiant.store');
Route::get('Admin/Etudiant/reset/{id}', [GestionEtudiantController::class, 'reset'])->name('Admin.etudiant.reset');
Route::get('Admin/Etudiant/showEt', [GestionEtudiantController::class, 'showEt'])->name('Admin.etudiant.showEt');
Route::get('Admin/Etudiant/edit/{id}', [GestionEtudiantController::class, 'edit'])->name('Admin.etudiant.edit');
Route::post('Admin/Etudiant/update', [GestionEtudiantController::class, 'update'])->name('Admin.etudiant.update');
Route::get('Admin/Etudiant/delete/{id}', [GestionEtudiantController::class, 'destroy'])->name('Admin.etudiant.delete');

/* Gestion Filiere */
Route::get('Admin/Filiere/index', [GestionFiliereController::class, 'index'])->name('Admin.filiere.index');
Route::get('Admin/Filiere/showFil', [GestionFiliereController::class, 'showFil'])->name('Admin.filiere.showFil');
Route::get('Admin/Filiere/show', [GestionFiliereController::class, 'show'])->name('Admin.filiere.show');
Route::get('Admin/Filiere/showDept/{id}', [GestionFiliereController::class, 'showDept'])->name('Admin.filiere.showDept');
Route::get('Admin/Filiere/createFil', [GestionFiliereController::class, 'createFil'])->name('Admin.filiere.createFil');
Route::get('Admin/Filiere/create/{id}', [GestionFiliereController::class, 'create'])->name('Admin.filiere.create');
Route::post('Admin/Filiere/store', [GestionFiliereController::class, 'store'])->name('Admin.filiere.store');
Route::get('Admin/Filiere/edit', [GestionFiliereController::class, 'edit'])->name('Admin.filiere.edit');
Route::post('Admin/Filiere/update', [GestionFiliereController::class, 'update'])->name('Admin.filiere.update');
Route::get('Admin/Filiere/delete/{id}', [GestionFiliereController::class, 'destroy'])->name('Admin.filiere.delete');

/* Gestion GroupeTd*/
Route::get('Admin/GroupeTD/TD/index/{id}', [GestionGroupeTDController::class, 'indexGroupeTd'])->name('Admin.GroupeTD.TD.index');
Route::get('Admin/GroupeTD/TDSpeciale/index/{id}', [GestionGroupeTDController::class, 'indexGroupeTdSpecial'])->name('Admin.GroupeTD.TDSpeciale.index');
Route::get('Admin/GroupeTD/TD/create/{id}', [GestionGroupeTDController::class, 'createGroupeTd'])->name('Admin.GroupeTD.TD.create');
Route::get('Admin/GroupeTD/TDSpeciale/create/{id}', [GestionGroupeTDController::class, 'createGroupeTdSpeciale'])->name('Admin.GroupeTD.TDSpeciale.create');
Route::post('Admin/GroupeTD/TD/store', [GestionGroupeTDController::class, 'storeGroupeTd'])->name('Admin.GroupeTD.TD.store');
Route::post('Admin/GroupeTD/TDSpeciale/store', [GestionGroupeTDController::class, 'storeGroupeTdSpeciale'])->name('Admin.GroupeTD.TDSpeciale.store');
Route::get('Admin/GroupeTD/TD/show', [GestionGroupeTDController::class, 'show'])->name('Admin.GroupeTD.shows');
Route::get('Admin/GroupeTD/TD/edit', [GestionGroupeTDController::class, 'edit'])->name('Admin.GroupeTD.TD.edit');
Route::post('Admin/GroupeTD/TD/update', [GestionGroupeTDController::class, 'update'])->name('Admin.GroupeTD.TD.update');
Route::get('Admin/GroupeTD/TD/delete/{id}', [GestionGroupeTDController::class, 'destroy'])->name('Admin.GroupeTD.TD.delete');
Route::get('Admin/GroupeTD/TD/voir/{id}', [GestionGroupeTDController::class, 'voir'])->name('Admin.GroupeTD.voir');
Route::get('Admin/GroupeTD/TD/showEtudiant/{id}', [GestionGroupeTDController::class, 'showEtudiant'])->name('Admin.GroupeTD.showEtudiant');
Route::get('Admin/GroupeTD/TD/showEtudiantOne/{id}', [GestionGroupeTDController::class, 'showEtudiantOne'])->name('Admin.GroupeTD.showEtudiantOne');
Route::get('Admin/GroupeTD/TD/unsubscribeEtudiant/{id}', [GestionGroupeTDController::class, 'unsubscribeEtudiant'])->name('Admin.GroupeTD.unsubscribeEtudiant');
Route::get('Admin/GroupeTD/Import/{id}', [GestionGroupeTDController::class, 'formImport'])->name('Admin.GroupeTD.formImport');
Route::post('Admin/GroupeTD/Import/{id}', [GestionGroupeTDController::class, 'import'])->name('Admin.GroupeTD.import');

/* Gestion Niveau */
Route::get('Admin/Niveau/index', [GestionNiveauController::class, 'index'])->name('Admin.niveau.index');
Route::get('Admin/Niveau/show', [GestionNiveauController::class, 'show'])->name('Admin.niveau.show');
Route::get('Admin/Niveau/create', [GestionNiveauController::class, 'create'])->name('Admin.niveau.create');
Route::post('Admin/Niveau/store', [GestionNiveauController::class, 'store'])->name('Admin.niveau.store');
Route::get('Admin/Niveau/edit', [GestionNiveauController::class, 'edit'])->name('Admin.niveau.edit');
Route::post('Admin/Niveau/update', [GestionNiveauController::class, 'update'])->name('Admin.niveau.update');
Route::get('Admin/Niveau/delete/{id}', [GestionNiveauController::class, 'destroy'])->name('Admin.niveau.delete');

/* Route Seance */
Route::get('Admin/SeanceTD/index/{id}', [GestionSceanceController::class, 'index'])->name('Admin.sceanceTd.index');
Route::get('Admin/SeanceTD/create/{id}', [GestionSceanceController::class, 'create'])->name('Admin.sceanceTd.create');
Route::post('Admin/SeanceTD/store', [GestionSceanceController::class, 'store'])->name('Admin.sceanceTd.store');
Route::get('Admin/SeanceTD/show', [GestionSceanceController::class, 'show'])->name('Admin.sceanceTd.show');
Route::get('Admin/SeanceTD/edit', [GestionSceanceController::class, 'edit'])->name('Admin.sceanceTd.edit');
Route::post('Admin/SeanceTD/update', [GestionSceanceController::class, 'update'])->name('Admin.sceanceTd.update');
Route::get('Admin/SeanceTD/delete/{id}', [GestionSceanceController::class, 'destroy'])->name('Admin.sceanceTd.delete');

/* Route Seance Presence */
Route::get('Admin/PresenceSeance/index/{id}', [GestionSceancePresenceController::class, 'index'])->name('Admin.Presencesceance.index');
Route::get('Admin/PresenceSeance/create/{id}', [GestionSceancePresenceController::class, 'create'])->name('Admin.Presencesceance.create');
Route::post('Admin/PresenceSeance/store', [GestionSceancePresenceController::class, 'store'])->name('Admin.Presencesceance.store');
Route::get('Admin/PresenceSeance/exportPDF/{id}', [GestionSceancePresenceController::class, 'exportPDF'])->name('Admin.Presencesceance.exportPDF');
Route::get('Admin/PresenceSeance/edit/{id}', [GestionSceancePresenceController::class, 'edit'])->name('Admin.Presencesceance.edit');
Route::post('Admin/PresenceSeance/update', [GestionSceancePresenceController::class, 'update'])->name('Admin.Presencesceance.update');
Route::get('Admin/PresenceSeance/delete/{id}', [GestionSceancePresenceController::class, 'destroy'])->name('Admin.Presencesceance.delete');

/* Gestion TD */
Route::get('Admin/TD/index', [GestionTDController::class, 'index'])->name('Admin.groupeTD.index');
Route::get('Admin/TD/show', [GestionTDController::class, 'show'])->name('Admin.groupeTD.show');
Route::get('Admin/TD/showTd/{id}', [GestionTDController::class, 'showTd'])->name('Admin.groupeTD.showTd');
Route::get('Admin/TD/showTdSpecial/{id}', [GestionTDController::class, 'showTdSpecial'])->name('Admin.groupeTD.showTdSpecial');
Route::get('Admin/TD/createTd/{id}', [GestionTDController::class, 'createTd'])->name('Admin.groupeTD.createTd');
Route::get('Admin/TD/createTdSpeciale/{id}', [GestionTDController::class, 'createTdSpeciale'])->name('Admin.groupeTD.createTdSpeciale');
Route::post('Admin/TD/store', [GestionTDController::class, 'store'])->name('Admin.groupeTD.store');
Route::post('Admin/TD/storeTdSpecial', [GestionTDController::class, 'storeTdSpecial'])->name('Admin.groupeTD.storeTdSpecial');
Route::get('Admin/TD/edit', [GestionTDController::class, 'edit'])->name('Admin.groupeTD.edit');
Route::get('Admin/TD/editTdSpecial', [GestionTDController::class, 'editTdSpecial'])->name('Admin.groupeTD.editTdSpecial');
Route::post('Admin/TD/update', [GestionTDController::class, 'update'])->name('Admin.groupeTD.update');
Route::post('Admin/TD/updateTdSpecial', [GestionTDController::class, 'updateTdSpecial'])->name('Admin.groupeTD.updateTdSpecial');
Route::get('Admin/TD/delete/{id}', [GestionTDController::class, 'destroy'])->name('Admin.groupeTD.delete');
Route::get('Admin/TD/deleteTdSpecial', [GestionTDController::class, 'destroyTdSpecial'])->name('Admin.groupeTD.deleteTdSpecial');

/* Gestion UE */
Route::get('Admin/UE/index', [GestionUEsController::class, 'index'])->name('Admin.ue.index');
Route::get('Admin/UE/showFil/{id}', [GestionUEsController::class, 'showFil'])->name('Admin.ue.showFil');
Route::get('Admin/UE/showNiv/{id}', [GestionUEsController::class, 'showNiv'])->name('Admin.ue.showNiv');
Route::get('Admin/UE/show', [GestionUEsController::class, 'show'])->name('Admin.ue.show');
Route::get('Admin/UE/create/{id}', [GestionUEsController::class, 'create'])->name('Admin.ue.create');
Route::get('Admin/UE/createNiv/{id}', [GestionUEsController::class, 'createNiv'])->name('Admin.ue.createNiv');
Route::post('Admin/UE/store', [GestionUEsController::class, 'store'])->name('Admin.ue.store');
Route::get('Admin/UE/edit', [GestionUEsController::class, 'edit'])->name('Admin.ue.edit');
Route::post('Admin/UE/update', [GestionUEsController::class, 'update'])->name('Admin.ue.update');
Route::get('Admin/UE/delete/{id}', [GestionUEsController::class, 'destroy'])->name('Admin.ue.delete');

/* Gestion de Requete */
Route::get('Admin/Requete/index', [RequeteController::class, 'index'])->name('Admin.requete.index');
Route::get('Admin/Requete/show/{id}', [RequeteController::class, 'voir'])->name('Admin.requete.voir');
Route::post('Admin/Requete/update', [RequeteController::class, 'update'])->name('Admin.requete.update');
// Route::get('Admin/Requete/delete/{id}', [RequeteController::class, ''])->name('Admin.requete.');
// Route::post('Admin/Requete/fichier', [RequeteController::class, 'fichier'])->name('Admin.requete.fichier');
// Route::get('Admin/Requete/v', [RequeteController::class, ''])->name('Admin.requete.');

/* Ecole Doctorat */
/* Reporting */
Route::get('Ecole_Doctorat/Reporting/index', [ReportingController::class, 'index'])->name('Ecole_Doctorat.reporting');

/* Dossier */

#ADMIN VERIFICATIONS (VALIDATION AND REJECTION)
Route::get('Ecole_Doctorat/Dossier/index', [DossierController::class, 'index'])->name('Ecole_Doctorat.dossier.index');

Route::get('Ecole_Doctorat/Dossier/voir/{id}', [DossierController::class, 'show'])->name('Ecole_Doctorat.dossier.voir');

//THESE ARE THE TWO FUNCTIONS
Route::post('Ecole_Doctorat/Dossier/voir/{id}/valider', [DossierController::class, 'valider'])->name('Ecole_Doctorat.dossier.actions.valider');
Route::post('Ecole_Doctorat/Dossier/voir/{id}/rejeter', [DossierController::class, 'rejeter'])->name('Ecole_Doctorat.dossier.actions.rejeter');





Route::get('Ecole_Doctorat/Dossier/show/{filiere_id}/{niveau_id}/{status}', [DossierController::class, 'links'])->name('Ecole_Doctorat.dossier.links');
Route::get('Ecole_Doctorat/Dossier/jury_P', [DossierController::class, 'jury_P'])->name('Ecole_Doctorat.dossier.jury_P');
Route::post('Ecole_Doctorat/Dossier/update', [DossierController::class, 'update'])->name('Ecole_Doctorat.dossier.update');
Route::get('Ecole_Doctorat/Dossier/edit/{id}', [DossierController::class, 'edit'])->name('Ecole_Doctorat.dossier.edit');
Route::post('Ecole_Doctorat/Dossier/edit', [DossierController::class, 'update_theme'])->name('Ecole_Doctorat.dossier.update_theme');
Route::get('Ecole_Doctorat/Dossier/edit', function(){
    abort(403);
});
Route::get('Ecole_Doctorat/Dossier/delete/{id}/{valeur}', [DossierController::class, 'destroy'])->name('Ecole_Doctorat.dossier.delete');

/* Archive */
Route::get('Ecole_Doctorat/Archive/index', [ArchiveController::class, 'index'])->name('Ecole_Doctorat.archive.index');
// Route::get('Ecole_Doctorat/Archive/', [ArchiveController::class, ''])->name('Ecole_Doctorat.archive.');
// Route::get('Ecole_Doctorat/Archive/', [ArchiveController::class, ''])->name('Ecole_Doctorat.archive.');

/* Message */
Route::get('Ecole_Doctorat/Message/index', [MessageController::class, 'index'])->name('Ecole_Doctorat.message.index');
Route::post('Ecole_Doctorat/Message/index', [MessageController::class, 'store'])->name('Ecole_Doctorat.message.store');
Route::get('Ecole_Doctorat/Message/edit/{id}', [MessageController::class, 'edit'])->name('Ecole_Doctorat.message.edit');
Route::post('Ecole_Doctorat/Message/edit', [MessageController::class, 'update'])->name('Ecole_Doctorat.message.update');
Route::get('Ecole_Doctorat/Message/delete/{id}', [MessageController::class, 'destroy'])->name('Ecole_Doctorat.message.delete');

/* Etudiant Dossier */
Route::get('Ecole_Doctorat/EtudiantDossier/index/{id}', [EtudiantDossierController::class, 'index'])->name('Ecole_Doctorat.etudiantDos.index');
Route::post('Ecole_Doctorat/EtudiantDossier/storeRequete', [EtudiantDossierController::class, 'storeRequete'])->name('Ecole_Doctorat.etudiantDos.storeRequete');
Route::post('Ecole_Doctorat/EtudiantDossier/storeDate', [EtudiantDossierController::class, 'storeDate'])->name('Ecole_Doctorat.etudiantDos.storeDate');
Route::get('Ecole_Doctorat/EtudiantDossier/updateDoc/{id}', [EtudiantDossierController::class, 'updateDoc'])->name('Ecole_Doctorat.etudiantDos.updateDoc');
Route::get('Ecole_Doctorat/EtudiantDossier/delete/{id}', [EtudiantDossierController::class, 'destroy'])->name('Ecole_Doctorat.etudiantDos.delete');
// Route::post('Ecole_Doctorat/EtudiantDossier/fichier', [EtudiantDossierController::class, 'fichier'])->name('Ecole_Doctorat.etudiantDos.fichier');

/* Inscription */
Route::get('Ecole_Doctorat/Inscription/index', [InscriptionController::class, 'index'])->name('Ecole_Doctorat.Inscription.index');
Route::get('Ecole_Doctorat/Inscription/show', [InscriptionController::class, 'show'])->name('Ecole_Doctorat.Inscription.show');
Route::get('Ecole_Doctorat/Inscription/update/{id}', [InscriptionController::class, 'update'])->name('Ecole_Doctorat.Inscription.update');
Route::get('Ecole_Doctorat/Inscription/delete/{id}', [InscriptionController::class, 'destroy'])->name('Ecole_Doctorat.Inscription.delete');

/* Jurys */
Route::get('Ecole_Doctorat/Jury/index', [JuryController::class, 'index'])->name('Ecole_Doctorat.jury.index');
Route::get('Ecole_Doctorat/Jury/voir/{id}', [JuryController::class, 'voir'])->name('Ecole_Doctorat.jury.voir');
Route::get('Ecole_Doctorat/Jury/create', [JuryController::class, 'create'])->name('Ecole_Doctorat.jury.create');
Route::post('Ecole_Doctorat/Jury/store', [JuryController::class, 'store'])->name('Ecole_Doctorat.jury.store');
Route::get('Ecole_Doctorat/Jury/edit/{id}', [JuryController::class, 'edit'])->name('Ecole_Doctorat.jury.edit');
Route::post('Ecole_Doctorat/Jury/update', [JuryController::class, 'update'])->name('Ecole_Doctorat.jury.update');
Route::get('Ecole_Doctorat/Jury/delete/{id}', [JuryController::class, 'destroy'])->name('Ecole_Doctorat.jury.delete');

/* Unite de Recherche */
Route::get('Ecole_Doctorat/Unite_Recherche/index', [UniteRechercheController::class, 'index'])->name('Ecole_Doctorat.unite_recherche.index');
Route::get('Ecole_Doctorat/Unite_Recherche/create', [UniteRechercheController::class, 'create'])->name('Ecole_Doctorat.unite_recherche.create');
Route::post('Ecole_Doctorat/Unite_Recherche/store', [UniteRechercheController::class, 'store'])->name('Ecole_Doctorat.unite_recherche.store');
Route::get('Ecole_Doctorat/Unite_Recherche/edit/{id}', [UniteRechercheController::class, 'edit'])->name('Ecole_Doctorat.unite_recherche.edit');
Route::post('Ecole_Doctorat/Unite_Recherche/update', [UniteRechercheController::class, 'update'])->name('Ecole_Doctorat.unite_recherche.update');
Route::get('Ecole_Doctorat/Unite_Recherche/delete/{id}', [UniteRechercheController::class, 'destroy'])->name('Ecole_Doctorat.unite_recherche.delete');

/* Email */
Route::get('Ecole_Doctorat/Email/{id}', [EmailController::class, 'index'])->name('Ecole_Doctorat.email.index');
Route::get('Ecole_Doctorat/EmailEnvoi/{id}', [EmailController::class, 'envoieMail'])->name('Ecole_Doctorat.email.envoieMail');
Route::get('Ecole_Doctorat/NoteEtudiant/{url}', [EmailController::class, 'noterEtudiant'])->name('Ecole_Doctorat.email.noterEtudiant');
Route::post('Ecole_Doctorat/Note/{url}', [EmailController::class, 'note'])->name('Ecole_Doctorat.email.note');



// Route::get('/', [GestionInscriptionTDController::class, 'index'])->name('InscriptionTd.index');
// Route::get('/Inscription/TDs/{niv_id}/{fil_id}', [GestionInscriptionTDController::class, 'show'])->name('Inscription.show');
// Route::get('/Inscription/Niveau', [GestionInscriptionTDController::class, 'show_niv'])->name('Inscription.show_niv');
// Route::get('/Inscription/GroupeTd/{id}', [GestionInscriptionTDController::class, 'showTdUe'])->name('Inscription.showTdUe');



// Route::get('/Inscription/GroupeTd/Registration/{id}', [GestionInscriptionTDController::class, 'signTd'])->name('Inscription.signTd');
Route::post('/Inscription/GroupeTd/{id}', [GestionInscriptionTDController::class, 'RegistrationTD'])->name('Inscription.RegistrationTD');
Route::get('Inscription/form/{id}', [GestionInscriptionTDController::class, 'createForm'])->name('Inscription.form.createForm');
Route::post('Inscription/form/{id}', [GestionInscriptionTDController::class, 'store'])->name('Inscription.form.store');





