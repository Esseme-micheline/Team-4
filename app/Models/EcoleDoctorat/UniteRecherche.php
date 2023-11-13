<?php

namespace App\Models\EcoleDoctorat;

use App\Models\EcoleDoctorat\Dossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniteRecherche extends Model
{
    protected $fillable=['code', 'intitule'];
    use HasFactory;
    public function dossiers(){
        return $this->hasMany(Dossier::class);
    }
}
