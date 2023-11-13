<?php

namespace App\Models\Admin;

use App\Models\Admin\GroupeTd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargeTd extends Model
{
    protected $fillable=['noms', 'telephone', 'email', 'password', ];
    use HasFactory;
    public function groupe_tds(){
        return $this->hasMany(GroupeTd::class);
    }
}
