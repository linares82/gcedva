<?php

namespace App\Observers;

use App\Empleado;
use App\IncidencesCliente;
use App\DevolucionesCaja;
use Log;
use Mail;

class DevolucionesCajaObserver
{
    /*
    public function created(DevolucionesCaja $devolucionCaja)
    {
        //dd($devolucionCaja->stDevCaja);
        $empleado = Empleado::where('bnd_autorizar_dev', 1)->first();
        $mail_to = $empleado->mail;
        //dd($mail_to);
        Log::info('enviando mail');
        $respuesta = Mail::send(
            'emails.atencionDevolucion',
            array(
                'devolucion' => $devolucionCaja->id,
                'estatus' => $devolucionCaja->stDevCaja->name,
                'caja' => $devolucionCaja->caja->consecutivo,
                'cliente' => $devolucionCaja->cliente->nombre,
                'plantel' => $devolucionCaja->plantel->razon,
                'monto' => $devolucionCaja->monto,
                'motivo' => $devolucionCaja->motivosDevCaja->name,
                'vobo' => $devolucionCaja->vobo,
                'obs' => $devolucionCaja->obs
            ),
            function ($message) use ($mail_to) {
                $message->to($mail_to);
                $message->subject('Devolución Creada');
            }
        );
        Log::info('enviado mail');
    }

    public function updating(DevolucionesCaja $model)
    {
        $model->usu_mod_id = \Auth::user()->id;
    }
*/
    public function updated(DevolucionesCaja $model)
    {
        //dd($model);
        if ($model->st_dev_caja_id == 2) {
            $incidences_cliente = IncidencesCliente::where('devoluciones_caja_id', $model->id)
                ->whereNull('deleted_at')
                ->first();

            if (is_null($incidences_cliente)) {
                $input['cliente_id'] = $model->cliente_id;
                $input['incidence_cliente_id'] = 7;
                $input['detalle'] = "Devolucion: " . $model->id . ' - Caja: ' . $model->caja->consecutivo . ' - Monto: ' . $model->monto;
                $input['fecha'] = date('Y-m-d');
                $input['usu_alta_id'] = $model->usu_alta_id;
                $input['usu_mod_id'] = $model->usu_mod_id;
                $input['devoluciones_caja_id'] = $model->id;
                IncidencesCliente::create($input);
            }
        }
    }
}
