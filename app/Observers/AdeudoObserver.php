<?php

namespace App\Observers;

use App\Adeudo;
use App\Hadeudo;
use Auth;
use Log;

class AdeudoObserver
{
    public function updating(Adeudo $adeudo)
    {
        $adeudoAnterior = Adeudo::find($adeudo->id)->toArray();
        //dd($adeudoAnterior);
        foreach ($adeudoAnterior as $propiedad => $valor) {
            //Log::info($propiedad . "-" . $valor . "--" . $adeudo->$propiedad);
            //dd($propiedad . "-" . $valor . "--" . $adeudo->$propiedad);
            if ($valor <> $adeudo->$propiedad) {
                //dd($propiedad . "-" . $valor . "--" . $adeudo->$propiedad);
                $input['adeudo_id'] = $adeudo->id;
                $input['campo'] = $propiedad;
                $input['valor_anterior'] = is_null($valor) ? 'nulo' : $valor;
                $input['valor_nuevo'] = $adeudo->$propiedad;
                $input['usu_alta_id'] = Auth::user()->id;
                $input['usu_mod_id'] = Auth::user()->id;
                Hadeudo::create($input);
            }
        }
    }
}
