<?php

namespace App\Models\Etudiant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubEtudiant extends Model
{
    protected $table="club_etudiant";
    protected $timestamp=false;
    use HasFactory;
}
