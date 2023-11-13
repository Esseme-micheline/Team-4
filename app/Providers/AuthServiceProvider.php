<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('super_admin', function(User $user){
            return $user->profil_id==0;
        });
        Gate::define('doyen_Ecole', function(User $user){
            return $user->profil_id==1;
        });
        Gate::define('chef_Dept', function(User $user){
            return $user->profil_id==2;
        });
        Gate::define('enseignant', function(User $user){
            return $user->profil_id==3;
        });
        Gate::define('secretaire', function(User $user){
            return $user->profil_id==4;
        });
        Gate::define('chargeTD', function(User $user){
            return $user->profil_id==5;
        });
        Gate::define('etudiant',function(User $user){
            return $user->profil_id==6;
        });
    }
}
