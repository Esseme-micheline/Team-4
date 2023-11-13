<?php

namespace App\Models\EcoleDoctorat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{
    protected $fillable=['etudiant_id', 'etat_id', 'acteur', 'objet'];
    use HasFactory;
}
