<?php

namespace App\Models\Admin;

use App\Models\Admin\Ue;
use App\Models\Admin\GroupeTd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Td extends Model
{
    use HasFactory;
    protected $fillable=['ue_id', 'code', 'intitule'];
    public function ue(){
        return $this->belongsTo(Ue::class);
    }
    public function groupeTds(){
        return $this->hasMany(GroupeTd::class);
    }
}
