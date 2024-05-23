<?php

namespace App\Console\Commands;

use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use App\StCliente;
use Carbon\Carbon;
use App\Seguimiento;
use App\HistoriaCliente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\valenceSdk\samples\BasicSample\UsoApi;

class bajasAutomaticas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:bajasAutomaticas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //dd(storage_path('app/public/atrazoPagos'));

        $fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $parametros = StCliente::where('bnd_automatizar_baja', 1)->orderBy('orden_ejecucion', 'asc')->get();
        //dd($parametros->toArray());

        $ruta = storage_path('app/public/atrazoPagos/');
        $archivo = date('dmY') . "_" . date('Hsi') . ".csv";
        $file = fopen($ruta . $archivo, 'w');
        $columns = array('plantel', 'id_cliente', 'estatus', 'total_adeudos');
        fputcsv($file, $columns);
        foreach ($parametros as $parametro) {
            //dd($parametro->toArray());
            $dias = explode(",", $parametro->dias_ejecucion);
            //dd($dias);
            $cantidad_adeudos = explode(",", $parametro->cantidad_adeudos);
            //dd($cantidad_adeudos);
            //dd(in_array($fechaActual->day, $dias));
            if (in_array($fechaActual->day, $dias)) {
                $bnd_mensualidad=$parametro->bnd_mensualidades==1 ? 1 : 0;
                //dd($bnd_mensualidad);
                $registros = Adeudo::select(DB::raw('p.razon,adeudos.cliente_id, stc.id as st_cliente_id, stc.name as estatus, count(adeudos.cliente_id) as adeudos_cantidad'))
                    ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
                    ->where('cc.plantel_id', '>', 0)
                    ->where('cc.especialidad_id', '>', 0)
                    ->where('cc.nivel_id', '>', 0)
                    ->where('cc.grado_id', '>', 0)
                    ->where('cc.turno_id', '>', 0)
                    //->whereIn('c.id', array(8111,12843,18284, 45432))
                    ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
                    ->when($bnd_mensualidad, function($q, $bnd_mensualidad){
                        return $q->where('caj_con.bnd_mensualidad', $bnd_mensualidad);
                    })
                    ->where('fecha_pago', '<', $fechaActual)
                    ->where('pagado_bnd', 0)
                    ->whereNotIn('c.plantel_id', array(54))
                    ->whereNull('cc.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->where('c.st_cliente_id', $parametro->id)
                    ->groupBy('p.razon')
                    ->groupBy('adeudos.cliente_id')
                    ->groupBy('st_cliente_id')
                    ->groupBy('stc.name')
                    ->havingRaw('adeudos_cantidad in ('.$parametro->cantidad_adeudos.')')
                    //->having('adeudos_cantidad', '>=', 1)
                    //->having('adeudos_cantidad', '<=', 3)
                    ->get();
                //dd($registros->toArray());
                foreach ($registros as $registro) {
                    $hoy = date('Y-m-d');
                    $eventos = HistoriaCliente::where('cliente_id', $registro->cliente_id)
                    ->where('evento_cliente_id', 5)
                    ->whereDate('fec_vigencia', '>=', $hoy)
                    ->whereNull('historia_clientes.deleted_at')
                    ->get();

                    if (count($eventos) == 0) {
                        if ($registro->st_cliente_id==$parametro->id) {
                            $this->bajaBs($registro->cliente_id);
                            fputcsv($file, array(
                                'plantel' => $registro->razon,
                                'id_cliente' => $registro->cliente_id,
                                'estatus' => $registro->estatus,
                                'adeudos_cantidad' => $registro->adeudos_cantidad
                            ));
    
                            $cliente = Cliente::find($registro->cliente_id);
                            
                            $cliente->st_cliente_id = $parametro->siguiente_cliente_id;
                            $cliente->save();
    
                            $seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
                            
                            $seguimiento->st_seguimiento_id = $parametro->siguiente_seguimiento_id;
                            $seguimiento->save();
                        } 
                    }
                }
            }
        }

        fclose($file);
    }

    public function bajaBs($cliente)
    {


        $bs_activo = $param = Param::where('llave', 'api_brightSpace_activa')->first();
        if ($bs_activo->valor == 1) {
            $apiBs = new UsoApi();

            //Se busca la version de uso de la API
            $param = Param::where('llave', 'apiVersion_bSpace')->first();

            //Lineas comentadas para ejecutar la url de Whoami
            //$resultado=$apiBs->doValence2('GET','/d2l/api/lp/' . $param->valor . '/users/whoami');
            //dd($resultado);



            try {
                $alumno = Cliente::find($cliente);


                //dd($registros)	
                //dd($alumno->matricula);

                if ($alumno->matricula <> "" and !is_null($alumno->matricula)) {
                    //Se invoca el metodo doValence con los parametros del verbo y la url igual que en el ejemplo del SDK
                    //$resultado=$apiBs->doValence('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$alumno->matricula);
                    $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $alumno->matricula);

                    //Muestra resultado
                    $r = $resultado[0];
                    //dd($r);

                    $datos = ['isActive' => False];
                    //dd($datos);
                    if (isset($r['UserId'])) {
                        $resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
                        sleep(3);
                        //dd($resultado2);
                        if (isset($resultado2['IsActive']) and !$resultado2['IsActive']) {
                            $input['cliente_id'] = $alumno->id;
                            $input['fecha_baja'] = Date('Y-m-d');
                            $input['bnd_baja'] = 1;
                            $input['usu_alta_id'] = 1;
                            $input['usu_mod_id'] = 1;
                            BsBaja::create($input);
                        } else {
                            $input['cliente_id'] = $alumno->id;
                            $input['fecha_baja'] = Date('Y-m-d');
                            $input['bnd_baja'] = 0;
                            $input['usu_alta_id'] = 1;
                            $input['usu_mod_id'] = 1;
                            BsBaja::create($input);
                        }
                    }
                    //dd($resultado2['IsActive']);
                }
            } catch (Exception $e) {
                Log::info("cliente no encontrado en Brigth Space u otro error: " . $alumno->matricula . " - " . $e->getMessage());
                //return false;
            }
        }
    }
}
