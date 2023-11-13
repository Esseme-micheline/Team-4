<?php

namespace App\Models\EcoleDoctorat;

use App\Models\EcoleDoctorat\Jury;
use App\Models\EcoleDoctorat\Dossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Changement extends Model
{
    protected $fillable=['dossier_id', 'encadreur_id', 'coEncadreur_id', 'cooEncadreur_id', 'theme', 'etat'];
    use HasFactory;

    public function dossier(){
        return $this->belongsTO(Dossier::class);
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
}
