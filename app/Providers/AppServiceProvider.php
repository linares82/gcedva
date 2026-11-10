<?php

namespace App\Providers;


use App\Adeudo;
use App\Alumno;
use App\AsignacionTarea;
use App\AsistenciaR;
use App\Aviso;
use App\Caja;
use App\CalificacionPonderacion;
use App\Cliente;
use App\CuentasEfectivo;
use App\DevolucionesCaja;
use App\Egreso;
use App\Empleado;
use App\HCalifPonderacion;
use App\HistoriaCliente;
use App\Inscripcion;
use App\Lead;
use App\Mueble;
use App\Observers\AdeudoObserver;
use App\Observers\AlumnoObserver;
use App\Observers\AsignacionTareaObserver;
use App\Observers\AsistenciaRObserver;
use App\Observers\AvisoObserver;
use App\Observers\CajaObserver;
use App\Observers\CalificacionPonderacionObserver;
use App\Observers\ClienteObserver;
use App\Observers\CuentasEfectivoObserver;
use App\Observers\DevolucionCajaObserver;
use App\Observers\EgresoObserver;
use App\Observers\EmpleadoObserver;
use App\Observers\HistoriaClienteObserver;
use App\Observers\InscripcionObserver;
use App\Observers\LeadObserver;
use App\Observers\MuebleObserver;
use App\Observers\PagoObserver;
use App\Observers\PeticionMultipagoObserver;
use App\Observers\ProspectoAsignacionTareaObserver;
use App\Observers\ProspectoAvisoObserver;
use App\Observers\ProspectoObserver;
use App\Observers\ProspectoSeguimientoObserver;
use App\Observers\SeguimientoObserver;
use App\Observers\TransferenceObserver;
use App\Pago;
use App\PeticionMultipago;
use App\Prospecto;
use App\ProspectoAsignacionTarea;
use App\ProspectoAviso;
use App\ProspectoSeguimiento;
use App\Seguimiento;
use App\Transference;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Studio\Totem\Totem;

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
        DevolucionesCaja::observe(DevolucionCajaObserver::class);
        Empleado::observe(EmpleadoObserver::class);
        Egreso::observe(EgresoObserver::class);
        HistoriaCliente::observe(HistoriaClienteObserver::class);
        Inscripcion::observe(InscripcionObserver::class);
        Pago::observe(PagoObserver::class);
        PeticionMultipago::observe(PeticionMultipagoObserver::class);
        Prospecto::observe(ProspectoObserver::class);
        Mueble::observe(MuebleObserver::class);
        Seguimiento::observe(SeguimientoObserver::class);
        Transference::observe(TransferenceObserver::class);
        ProspectoAsignacionTarea::observe(ProspectoAsignaciontareaObserver::class);
        ProspectoAviso::observe(ProspectoAvisoObserver::class);
        ProspectoSeguimiento::observe(ProspectoSeguimientoObserver::class);
        Lead::observe(LeadObserver::class);
        Totem::auth(function ($request) {
            // return true / false . For e.g.
            return Auth::check();
        });

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
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
