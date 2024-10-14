<?php

namespace Atin\LaravelReferrals;

use Illuminate\Support\ServiceProvider;

class ReferralsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('/migrations')
        ], 'laravel-referrals-migrations');
    }
}