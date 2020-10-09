<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\AdeudoObserver;
use App\Observers\CajaObserver;
use App\Observers\ClienteObserver;
use App\Observers\EmpleadoObserver;
use App\Observers\AlumnoObserver;
use App\Observers\InscripcionObserver;
use App\Observers\SeguimientoObserver;
use App\Observers\AsignacionTareaObserver;
use App\Observers\AsistenciaRObserver;
use App\Observers\AvisoObserver;
use App\Observers\CalificacionPonderacionObserver;
use App\Observers\CuentasEfectivoObserver;
use App\Observers\PagoObserver;
use App\Observers\EgresoObserver;
use App\Observers\MuebleObserver;
use App\Observers\TransferenceObserver;
use App\Adeudo;
use App\Caja;
use App\Cliente;
use App\Empleado;
use App\Alumno;
use App\Inscripcion;
use App\Seguimiento;
use App\AsignacionTarea;
use App\AsistenciaR;
use App\Aviso;
use App\CalificacionPonderacion;
use App\CuentasEfectivo;
use App\Egreso;
use App\HCalifPonderacion;
use App\Mueble;
use App\Pago;
use App\Transference;
use Studio\Totem\Totem;
use Auth;

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
        Caja::observe(CajaObserver::class);
        Cliente::observe(ClienteObserver::class);
        Empleado::observe(EmpleadoObserver::class);
        Alumno::observe(AlumnoObserver::class);
        Inscripcion::observe(InscripcionObserver::class);
        Seguimiento::observe(SeguimientoObserver::class);
        AsignacionTarea::observe(AsignacionTareaObserver::class);
        Aviso::observe(AvisoObserver::class);
        CuentasEfectivo::observe(CuentasEfectivoObserver::class);
        Pago::observe(PagoObserver::class);
        Egreso::observe(EgresoObserver::class);
        Transference::observe(TransferenceObserver::class);
        Mueble::observe(MuebleObserver::class);
        AsistenciaR::observe(AsistenciaRObserver::class);
        CalificacionPonderacion::observe(CalificacionPonderacionObserver::class);
        Adeudo::observe(AdeudoObserver::class);
        Totem::auth(function ($request) {
            // return true / false . For e.g.
            return Auth::check();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('mailgun.client', function () {
            return \Http\Adapter\Guzzle6\Client::createWithConfig([
                // your Guzzle6 configuration
            ]);
        });
    }
}
