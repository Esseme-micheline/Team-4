<?php

namespace App\Models\Etudiant;

use App\Models\Admin\Ue;
use App\Models\Etudiant\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requete extends Model
{
    protected $fillable=['etudiant_id', 'ue_id', 'contenu', 'objet', 'document', 'reponse','stattus', 'uid'];
    use HasFactory;
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function ue(){
        return $this->belongsTo(Ue::class);
    }
}
