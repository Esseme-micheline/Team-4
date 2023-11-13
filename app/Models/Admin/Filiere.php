<?php

namespace App\Models\Admin;

use App\Models\Admin\Ue;
use App\Models\Admin\Departement;
use App\Models\Etudiant\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable=['departement_id', 'code', 'intitule', 'etudiant_nombre', 'ue_nombre'];
    public function departement(){
        return $this->belongsTo(Departement::class);
    }
    public function ues(){
        return $this->hasMany(Ue::class);
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
}
