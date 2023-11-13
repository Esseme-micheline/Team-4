<?php

namespace App\Models\Admin;

use App\Models\Admin\Filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    protected $fillable=['code', 'intitule'];
    public function filieres(){
        return $this->hasMany(Filiere::class);
    }
    use HasFactory;
}
