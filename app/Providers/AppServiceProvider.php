<?php

namespace App\Providers;

use Auth;
use App\Caja;
use App\Pago;
use App\Aviso;
use App\Adeudo;
use App\Alumno;
use App\Egreso;
use App\Mueble;
use App\Cliente;
use App\Empleado;
use App\Prospecto;
use App\AsistenciaR;
use App\Inscripcion;
use App\Seguimiento;
use App\Transference;
use Studio\Totem\Totem;
use App\AsignacionTarea;
use App\CuentasEfectivo;
use App\HCalifPonderacion;
use App\PeticionMultipago;
use App\Observers\CajaObserver;
use App\Observers\PagoObserver;
use App\CalificacionPonderacion;
use App\Observers\AvisoObserver;
use App\Observers\AdeudoObserver;
use App\Observers\AlumnoObserver;
use App\Observers\EgresoObserver;
use App\Observers\MuebleObserver;
use App\Observers\ClienteObserver;
use App\Observers\EmpleadoObserver;
use App\Observers\ProspectoObserver;
use App\Observers\AsistenciaRObserver;
use App\Observers\InscripcionObserver;
use App\Observers\SeguimientoObserver;
use App\Observers\TransferenceObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\AsignacionTareaObserver;
use App\Observers\CuentasEfectivoObserver;
use App\Observers\PeticionMultipagoObserver;
use App\Observers\CalificacionPonderacionObserver;

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
        Alumno::observe(AlumnoObserver::class);
        AsistenciaR::observe(AsistenciaRObserver::class);
        Adeudo::observe(AdeudoObserver::class);
        AsignacionTarea::observe(AsignacionTareaObserver::class);
        Aviso::observe(AvisoObserver::class);
        CuentasEfectivo::observe(CuentasEfectivoObserver::class);
        CalificacionPonderacion::observe(CalificacionPonderacionObserver::class);
        Caja::observe(CajaObserver::class);
        Cliente::observe(ClienteObserver::class);
        Empleado::observe(EmpleadoObserver::class);
        Egreso::observe(EgresoObserver::class);
        Inscripcion::observe(InscripcionObserver::class);
        Pago::observe(PagoObserver::class);
        PeticionMultipago::observe(PeticionMultipagoObserver::class);
        Prospecto::observe(ProspectoObserver::class);
        Mueble::observe(MuebleObserver::class);
        Seguimiento::observe(SeguimientoObserver::class);
        Transference::observe(TransferenceObserver::class);
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
