<?php

namespace App\Models\Admin;

use App\Models\Admin\ChargeTd;
use App\Models\Admin\GroupeTd;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\PresencesSceancesTd;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SceanceTd extends Model
{
    use HasFactory;
    protected $table="seance_tds";
    protected $fillable=['groupe_td_id', 'intitule', 'description', 'capacite', 'date', 'heureDebut', 'heureFin', 'salle'];

    public function groupe_td(){
        return $this->belongsTo(GroupeTd::class);
    }
    public function presences_sciences_tds(){
        return $this->hasMany(PresencesSceancesTd::class);
    }
}
