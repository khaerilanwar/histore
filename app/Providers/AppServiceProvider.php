<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Definisikan Gate
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 1;
        });
        Gate::define('isCashier', function (User $user) {
            return $user->role === 2;
        });

        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
        Model::preventLazyLoading();
    }
}
