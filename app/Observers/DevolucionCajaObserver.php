<?php

namespace App\Observers;

use App\Empleado;
use Mail;
use Log;

class DevolucionCajaObserver
{
    public function created($devolucionCaja)
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

    public function updating($model)
    {
        $model->usu_mod_id = \Auth::user()->id;
    }
}
