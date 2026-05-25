<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Observers\UserObserver;

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
        if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        
        // Register the UserObserver to automatically create a profile when a user is created
        User::observe(UserObserver::class);


    }
}