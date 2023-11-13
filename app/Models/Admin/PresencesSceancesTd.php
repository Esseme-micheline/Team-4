<?php

namespace App\Models\Admin;

use App\Models\Admin\SceanceTd;
use App\Models\Etudiant\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresencesSceancesTd extends Model
{
    use HasFactory;
    protected $table='presences_seances_tds';
    protected $fillable=['etudiant_id', 'seance_td_id', 'status'];

    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function sceance_td(){
        return $this->belongsTo(SceanceTd::class);
    }
}
