<?php

namespace App\Models\Admin;

use App\Models\Admin\Attribution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable=['noms', 'telephone', 'email', 'password', 'bureau'];
    public function attributions(){
        return $this->hasMany(Attribution::class);
    }
}
