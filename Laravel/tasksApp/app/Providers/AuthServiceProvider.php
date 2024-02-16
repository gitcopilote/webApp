<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User; // En supposant que votre modèle User est dans l'espace de noms App\Models

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Les associations de modèles avec leurs politiques respectives.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Post' => 'App\Policies\PostPolicy', // En supposant que vous avez une classe PostPolicy
    ];

    /**
     * Enregistrez les services d'authentification/autorisation.
     */
    public function boot(): void
    {
        Gate::define('administrateur', function (User $user) {
            return $user->isAdmin();
        });





        

        Gate::define('magasinier', function (User $user) {
            return $user->isStorekeeper();
        });


        Gate::define('maintenancier', function (User $user) {
            return $user->isMaintainer();
        });



        // Gate::define('main_maga', function (User $user) {
        //     return $user->isMain_maga(['maintenancier','magasinier']);
        // });


        // Gate::define('admin_main', function (User $user) {
        //     return $user->isAdmin_main(['maintenancier','administrateur']);
        // });



        
    }
}
