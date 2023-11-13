<?php

namespace App\Models\Admin;

use App\Models\Admin\Ue;
use App\Models\Etudiant\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{
    use HasFactory;
    protected $fillable=['code', 'intitule', 'etudiant_nombre'];

    public function ues(){
        return $this->hasMany(Ue::class);
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
}
