<?php

namespace App\Models\EcoleDoctorat;

use App\Models\EcoleDoctorat\Dossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jury extends Model
{
    protected $fillable=['noms', 'grade', 'telephone', 'email', 'universite', 'faculte', 'departement'];
    use HasFactory;
    public function dossiers(){
        return $this->hasMany(Dossier::class, 'encadreur_id');
    }
    public function dossiers_jury(){
        return $this->hasMany(Dossier::class, 'president_jury_id');
    }
    public function dossiers_examinateur(){
        return $this->hasMany(Dossier::class, 'examinateur_jury_id');
    }
}
