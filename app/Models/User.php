<?php

namespace App\Models;

use App\Models\Admin\ChargeTd;
use App\Models\Admin\Enseignant;
use App\Models\Admin\Departement;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enseignant_id',
        'profil_id',
        'charge_td_id',
        'departement_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function enseignant(){
        return $this->belongsTo(Enseignant::class);
    }
    public function charge_td(){
        return $this->belongsTo(ChargeTd::class);
    }
    public function departement(){
        return $this->belongsTo(Departement::class);
    }
}
