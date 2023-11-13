<?php

namespace App\Models\Admin;

use App\Models\Admin\Ue;
use App\Models\Admin\Enseignant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribution extends Model
{
    protected $fillable=['enseignant_id', 'ue_id'];
    use HasFactory;
    public function enseignant(){
        return $this->belongsTO(Enseignant::class);
    }
    public function ue(){
        return $this->belongsTo(Ue::class);
    }
}
