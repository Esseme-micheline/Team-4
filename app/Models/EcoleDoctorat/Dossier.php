<?php

namespace App\Models\EcoleDoctorat;

use App\Models\Admin\Niveau;
use App\Models\Admin\Filiere;
use App\Models\Etudiant\Etudiant;
use App\Models\EcoleDoctorat\Jury;
use App\Models\EcoleDoctorat\Annee;
use App\Models\EcoleDoctorat\Document;
use Illuminate\Database\Eloquent\Model;
use App\Models\EcoleDoctorat\Changement;
use App\Models\EcoleDoctorat\UniteRecherche;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dossier extends Model
{
    protected $fillable=['etudiant_id', 'encadreur_id', 'coEncadreur_id', 'cooEncadreur_id', 'filiere_id', 'unite_recherche_id', 'annee_id', 'president_jury_id', 'examinateur_jury_id',
                        'coexaminateur_jury_id', 'theme_recherche', 'note_lecture_Pr', 'note_lecture_En', 'note_lecture_Ex', 'status', 'etat', 'observation', 'uid'];
    use HasFactory;

    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function encadreur(){
        return $this->belongsTo(Jury::class, 'encadreur_id');
    }
    public function coEncadreur(){
        return $this->belongsTo(Jury::class, 'coEncadreur_id');
    }
    public function cooEncadreur(){
        return $this->belongsTo(Jury::class, 'cooEncadreur_id');
    }
    public function president_jury(){
        return $this->belongsTo(Jury::class, 'president_jury_id');
    }
    public function examinateur_jury(){
        return $this->belongsTo(Jury::class, 'examinateur_jury_id');
    }
    public function coexaminateur_jury(){
        return $this->belongsTo(Jury::class, 'coexaminateur_jury_id');
    }
    public function annee(){
        return $this->belongsTo(Annee::class);
    }
    public function unite_recherche(){
        return $this->belongsTo(UniteRecherche::class);
    }
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
    public function niveau(){
        return $this->belongsTo(Niveau::class);
    }
    public function changements(){
        return $this->hasMany(Changement::class);
    }
    public function documents(){
        return $this->hasMany(Document::class);
    }
    // public function change_etat(){
    //     // dd('ojk');
    //     return $this->hasMany(Changement::class->where('etat', 0)->get()->count());
    // }
}
