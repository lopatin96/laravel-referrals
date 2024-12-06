<?php

namespace Atin\LaravelReferrals;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;

class ReferralsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        \Event::listen(Registered::class, static function ($event) {
            $referrerId = request()->cookie('referrer_id');

            $event->user->forceFill([
                'referrer_id' => User::where('id', $referrerId)->exists() ? $referrerId : null,
            ])->save();

            cookie()->queue(cookie()->forget('referrer_id'));
        });

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('/migrations')
        ], 'laravel-referrals-migrations');
    }
}
