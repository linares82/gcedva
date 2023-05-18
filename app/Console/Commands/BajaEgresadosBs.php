<?php

namespace App\Console\Commands;

use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\valenceSdk\samples\BasicSample\UsoApi;

class BajaEgresadosBs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:BajaEgresadosBs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Baja de clientes egresados en BS, sin adeudo con ultima mensualidad caducada  ';

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


        //if ($fechaActual->day == 1 or $fechaActual->day == 2 or $fechaActual->day == 3) {
        $ruta = storage_path('app/public/atrazoPagos/');
        $archivo = date('dmY') . "_" . date('Hsi') . "_egresados.csv";
        $file = fopen($ruta . $archivo, 'w');
        $columns = array('plantel', 'id_cliente', 'estatus', 'total_adeudos');
        fputcsv($file, $columns);
        $egresados = Cliente::where('st_cliente_id', 20)->where('id', 70)->chunk(100, function ($egresados) use ($file) {
            $fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        
            foreach ($egresados as $egresado) {
                //dd($egresado->id);
                $adeudos = Adeudo::select(DB::raw('p.razon,adeudos.cliente_id, stc.id ,stc.name as estatus, count(adeudos.cliente_id) as adeudos_cantidad'))
                    ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
                    ->where('c.id', '>', 0)
                    ->where('cc.plantel_id', '>', 0)
                    ->where('cc.especialidad_id', '>', 0)
                    ->where('cc.nivel_id', '>', 0)
                    ->where('cc.grado_id', '>', 0)
                    ->where('cc.turno_id', '>', 0)
                    ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
                    ->where('caj_con.bnd_mensualidad', 1)
                    ->where('fecha_pago', '<', $fechaActual)
                    ->where('pagado_bnd', 0)
                    ->whereNotIn('c.plantel_id', array(54, 48, 26, 19))
                    ->whereNull('cc.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->where('c.id', $egresado->id)
                    ->groupBy('p.razon')
                    ->groupBy('adeudos.cliente_id')
                    ->groupBy('stc.id')
                    ->groupBy('stc.name')
                    ->having('adeudos_cantidad', 0)
                    ->get();
                //dd($adeudos);
                if (empty($adeudos->toArray())) {
                    $ultima_mensualidad = Adeudo::select('adeudos.*')
                        ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                        ->where('cc.bnd_mensualidad', 1)
                        ->where('cliente_id', $egresado->id)
                        ->orderBy('fecha_pago', 'desc')
                        ->first();
                    $fechaConcepto = Carbon::createFromFormat('Y-m-d', $ultima_mensualidad->fecha_pago);
                    $dias_diferencia=$fechaActual->diffInDays($fechaConcepto);
                    //dd($dias_diferencia);
                    if ($dias_diferencia > 30) {
                        $this->bajaBs($egresado->id);
                        fputcsv($file, array(
                            'plantel' => $egresado->plantel_id,
                            'id_cliente' => $egresado->id,
                            'estatus' => $egresado->st_cliente_id,
                            'adeudos_cantidad' => 0
                        ));
                    }
                }
            }
        });
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
