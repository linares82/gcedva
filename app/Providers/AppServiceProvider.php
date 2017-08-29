<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ClienteObserver;
use App\Observers\EmpleadoObserver;
use App\Observers\AlumnoObserver;
use App\Cliente;
use App\Empleado;
use App\Alumno;

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
        Empleado::observe(EmpleadoObserver::class);
        Alumno::observe(AlumnoObserver::class);
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
