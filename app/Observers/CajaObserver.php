<?php

namespace App\Observers;

use App\Adeudo;
use App\Caja;
use App\Cliente;
use App\Seguimiento;
use Log;
use App\Inscripcion;

class CajaObserver
{
    /**
     * Listen to the Caja created event.
     *
     * @param  User  $user
     * @return void
     */
    public $cajas;
    public $caja;


    /**
     * Listen to the Caja updated event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(Caja $caja)
    {
        $this->caja = $caja;
        $cliente = Cliente::find($this->caja->cliente_id);
        $seguimiento = Seguimiento::where('cliente_id', $this->caja->cliente_id)->first();

        //$cajas=Caja::where('cliente_id',$this->caja->cliente_id)->where('id','<>',$this->caja->id)->get();
        //dd($this->caja);
        if ($this->caja->st_caja_id == 1 or $this->caja->st_caja_id == 3) {
            $seguimiento->st_seguimiento_id = 2;
            $seguimiento->save();

            $inscripcions = Inscripcion::where('cliente_id', $cliente->id)->whereNull('inscripcions.deleted_at')->get();
            if ($inscripcions->isEmpty()) {
                $cliente->st_cliente_id = 22;
                $cliente->save();
            }elseif ($this->caja->cliente->st_cliente_id <> 3) {
                $cliente->st_cliente_id = 4;
                $cliente->save();
            }
        }
        if ($this->caja->st_caja_id == 1) {
            $adeudos = Adeudo::where('cliente_id', $this->caja->cliente_id)->where('pagado_bnd', 0)
                ->whereNull('deleted_at')
                ->count();
            //->get();
            //dd($adeudos->toArray());
            //Log::info('Adeudos:' . $adeudos);
            if ($adeudos == 0) {
                if($cliente->st_cliente_id<>3){
                    $cliente->st_cliente_id = 20;
                    $cliente->save();
                    $seguimiento->st_seguimiento_id = 7;
                    $seguimiento->save();
                }
            }
        }
    }
}
