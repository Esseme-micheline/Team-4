<?php

namespace App\Models\Admin;

use App\Models\Admin\Td;
use App\Models\Admin\TdSpecial;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant\EtudiantGroupeTd;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupeTd extends Model
{
    use HasFactory;
    protected $fillable=['td_id', 'td_special_id', 'intitule','charge_td_id', 'salle', 'capacite', 'periode'];

    public function td(){
        return $this->belongsTo(Td::class);
    }

    public function charge_td(){
        return $this->belongsTo(ChargeTd::class);
    }
    public function td_special(){
        return $this->belongsTo(TdSpecial::class);
    }
    public function etudiantGroupeTds(){
        return $this->hasMany(EtudiantGroupeTd::class);
    }
}
