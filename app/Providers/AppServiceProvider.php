<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ClienteObserver;
use App\Cliente;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Cliente::observe(ClienteObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
