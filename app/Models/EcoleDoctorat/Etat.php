<?php

namespace App\Models\EcoleDoctorat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $fillable=['libelle'];
    use HasFactory;
}
