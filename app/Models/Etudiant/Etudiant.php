<?php

namespace App\Models\Etudiant;

use App\Models\Admin\Niveau;
use App\Models\Admin\Filiere;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant\EtudiantsGroupesTd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Etudiant extends Authenticatable
{
    protected $fillable=['filiere_id', 'niveau_id', 'matricule', 'noms', 'telephone', 'email', 'photo', 'password'];
    use HasFactory;
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
    public function niveau(){
        return $this->belongsTo(Niveau::class);
    }
    public function etudiantGroupeTds(){
        return $this->hasMany(EtudiantsGroupesTd::class);
    }
}
