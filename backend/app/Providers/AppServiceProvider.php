<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Gate::define('crear-producto', function (User $user) {
            return in_array($user->rol, ['admin', 'editor']); // [cite: 33, 34]
        });

        Gate::define('editar-producto', function (User $user) {
            return in_array($user->rol, ['admin', 'editor']); // [cite: 36, 37]
        });

        Gate::define('eliminar-producto', function (User $user) {
            return $user->esAdmin(); // [cite: 39, 40]
        });
    }
}