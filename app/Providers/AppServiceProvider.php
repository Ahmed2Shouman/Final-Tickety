<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set default string length for database
        Schema::defaultStringLength(191);

        // Share the authenticated user with all views
        View::composer('*', function ($view) {
            $view->with('authUser', Auth::user());
        });

        // Set Stripe API key globally
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
}
