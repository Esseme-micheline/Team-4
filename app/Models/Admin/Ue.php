<?php

namespace App\Models\Admin;

use App\Models\Admin\Td;
use App\Models\Admin\Niveau;
use App\Models\Admin\Filiere;
use App\Models\Admin\TdSpecial;
use App\Models\Admin\Attribution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ue extends Model
{
    use HasFactory;
    protected $fillable=['filiere_id', 'niveau_id', 'code', 'intitule'];
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
    public function niveau(){
        return $this->belongsTo(Niveau::class);
    }
    public function tds(){
        return $this->hasMany(Td::class);
    }
    public function tdSpecials(){
        return $this->hasMany(TdSpecial::class);
    }
    public function attributions(){
        return $this->hasMany(Attribution::class);
    }
}
