<?php

namespace App\Console\Commands;

use App\Caja;
use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\valenceSdk\samples\BasicSample\UsoApi;

class ActivarBs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:activarBs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repite peticion de activacion para brightspace';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $cajasHoy=Caja::where('fecha',$fechaActual->toDateString())->where('st_caja_id',1)->get();
        $clientes=array();
        foreach($cajasHoy as $caja){
            array_push($clientes, $caja->cliente_id);
        }

        $registros = Adeudo::select(DB::raw('p.razon,adeudos.cliente_id,stc.name as estatus, count(adeudos.cliente_id) as adeudos_cantidad'))
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->where('cc.plantel_id', '>', 0)
            ->where('cc.especialidad_id', '>', 0)
            ->where('cc.nivel_id', '>', 0)
            ->where('cc.grado_id', '>', 0)
            ->where('cc.turno_id', '>', 0)
            ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
            ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
            ->where('caj_con.bnd_mensualidad', 1)
            ->where('fecha_pago', '<', $fechaActual)
            ->where('pagado_bnd', 0)
            ->whereIn('c.id', $clientes)
            ->whereNotIn('c.plantel_id', array(54))
            ->whereNull('cc.deleted_at')
            ->whereNull('c.deleted_at')
            ->where('c.st_cliente_id', '=', 4)
            ->groupBy('adeudos.cliente_id')
            ->having('adeudos_cantidad', '<=', 1)
            ->get();
        //dd('fil');
        //dd($registros->toArray());

        foreach ($registros as $registro) {
            //$hoy = date('Y-m-d');
            //dd($registro->toArray());
            /*
            $cliente = Cliente::find($registro->cliente_id);
            $cliente->st_cliente_id = 4;
            $cliente->save();

            $seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
            $seguimiento->st_seguimiento_id = 2;
            $seguimiento->save();*/
            $this->repetirActivarBs($registro->cliente_id);
            
        }
    }

    public function repetirActivarBs($cliente)
    {

        $cliente = Cliente::find($cliente);
        //$caja = Caja::find($caja);
        //if ($cliente->st_cliente_id == 4) {
            $param = Param::where('llave', 'apiVersion_bSpace')->first();
            $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
            if ($bs_activo->valor == 1) {
                try {
                    $apiBs = new UsoApi();

                    //dd($datos);
                    //Log::info('matricula bs reactivar en caja:'.$cliente->matricula);
                    $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                    //Muestra resultado
                    //dd($resultado);
                    $r = $resultado[0];
                    $datos = ['isActive' => True];
                    if (isset($r['UserId'])) {
                        $resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
                        $bsBaja = BsBaja::where('cliente_id', $cliente->id)
                            ->where('bnd_baja', 1)
                            ->whereNull('bnd_reactivar')
                            ->first();
                        //dd($bsBaja->toArray());
                        if (!is_null($bsBaja)) {
                            if (isset($resultado2['IsActive']) and $resultado2['IsActive'] and !is_null($bsBaja)) {
                                $input['cliente_id'] = $cliente->id;
                                $input['fecha_reactivar'] = Date('Y-m-d');
                                $input['bnd_reactivar'] = 1;
                                $input['usu_mod_id'] = Auth::user()->id;
                                $bsBaja->update($input);
                            } else {
                                $input['cliente_id'] = $cliente->id;
                                $input['fecha_reactivar'] = Date('Y-m-d');
                                $input['bnd_reactivar'] = 0;
                                $input['usu_mod_id'] = Auth::user()->id;
                                $bsBaja->update($input);
                            }
                        }
                    }
                } catch (Exception $e) {
                    Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                    //return false;
                }
            }
        //}
    }
}
