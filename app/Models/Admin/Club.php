<?php

namespace App\Models\Admin;

use App\Models\Admin\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    protected $fillable=['departement_id', 'code', 'intitule'];
    public function departement(){
        return $this->belongsTo(Departement::class);
    }
    use HasFactory;
}
