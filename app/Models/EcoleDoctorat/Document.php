<?php

namespace App\Models\EcoleDoctorat;

use App\Models\EcoleDoctorat\Nature;
use App\Models\EcoleDoctorat\Dossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    protected $fillable=['dossier_id', 'nature_id', 'documents', 'etat'];
    use HasFactory;

    public function nature(){
        return $this->belongsTo(Nature::class);
    }
    public function dossier(){
        return $this->belongsTo(Dossier::class);
    }
}
