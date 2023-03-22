<?php

namespace App\Console\Commands;

use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use Carbon\Carbon;
use App\Seguimiento;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use App\HistoriaCliente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use App\valenceSdk\samples\BasicSample\UsoApi;

class prbBS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:bs';

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
        /*
        $url=Param::where('llave','url_bSpace')->first();
        $client = new Client(['base_uri' => $url->valor]);
        $version=Param::where('llave','apiVersion_bSpace')->first();
        $result = $client->request('GET', "/d2l/api/lp/".$version->valor."/users/whoami");
        $request = $result->getBody()->getContents();
        dd($request);
        return response()->Json($request);
        */
		/*$clientes=HistoriaCliente::select('cliente_id')->where('st_historia_cliente_id',2)
		->join('clientes as cli','cli.id','historia_clientes.cliente_id')
		->where('historia_clientes.evento_cliente_id',2)
		->where('historia_clientes.reactivado',0)
		->whereNull('historia_clientes.deleted_at')
		->whereNull('cli.deleted_at')
		->whereNotNull('cli.matricula')
		->get();*/
	//dd($clientes->toArray());
        $clientes=array(
			13231,19657);

        $bs_activo=$param=Param::where('llave','api_brightSpace_activa')->first();
        if($bs_activo->valor==1){
			$apiBs=new UsoApi();
			
			//Se busca la version de uso de la API
			$param=Param::where('llave','apiVersion_bSpace')->first();
			
			//Lineas comentadas para ejecutar la url de Whoami
			//$resultado=$apiBs->doValence2('GET','/d2l/api/lp/' . $param->valor . '/users/whoami');
			//dd($resultado);
			
			//Se recorren los clientes para obtener datos de brigthspace
			foreach($clientes as $c){
				$alumno=Cliente::find($c);

				try {
					

					//$fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
					/*$adeudos = Adeudo::select(DB::raw('adeudos.cliente_id, count(adeudos.cliente_id) as adeudos_cantidad'))
						->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
						->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
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
						->whereNotIn('c.plantel_id',array(54))
						->whereNull('cc.deleted_at')
						->whereNull('c.deleted_at')
						->where('c.id', $alumno->id)
						->where('c.st_cliente_id', '<>', 3)
						->groupBy('adeudos.cliente_id')
						->having('adeudos_cantidad', '>=', 2)
						->first();*/
					//dd($registros)	
					//dd($alumno->matricula);
				
					//if($alumno->matricula<>"" and !is_null($alumno->matricula)){
						//Se invoca el metodo doValence con los parametros del verbo y la url igual que en el ejemplo del SDK
						//$resultado=$apiBs->doValence('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$alumno->matricula);
						$resultado=$apiBs->doValence2('GET','/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId='.$alumno->matricula);
			
						//Muestra resultado
						$r=$resultado[0];
						
						//Log::info('cliente:'.$alumno->id.'matricula:'.$alumno->matricula);
						//echo "fil";
						//dd($r);
						//dd($r['UserId']);

						$datos=['isActive'=>True];
						//dd($datos);
						//dd($r);
						//if(isset($r['UserId'])){
							$resultado2=$apiBs->doValence2('PUT','/d2l/api/lp/' . $param->valor . '/users/'.$r['UserId'].'/activation',$datos);
							echo 'cliente:'.$alumno->id.'matricula:'.$alumno->matricula;	
							//sleep(4);
							//dd($resultado2);
							/*if(isset($resultado2['IsActive']) and !$resultado2['IsActive']){
								$input['cliente_id']=$alumno->id;
								$input['fecha_baja']=Date('Y-m-d');
								$input['bnd_baja']=1;
								$input['usu_alta_id']=Auth::user()->id;
								$input['usu_mod_id']=Auth::user()->id;
								BsBaja::create($input);
								if ($adeudos->adeudos_cantidad == 2) {
									//echo $registro->cliente_id . '-';
									//$cliente = Cliente::find($registro->cliente_id);
									//Log::info("cliente-" . $cliente->id . "-st" . $cliente->st_cliente_id);
									$alumno->st_cliente_id = 25;
									$alumno->save();

									$seguimiento = Seguimiento::where('cliente_id', $alumno->id)->first();
									//Log::info("seguimiento-" . $seguimiento->id . "-st" . $seguimiento->st_seguimiento_id);
									$seguimiento->st_seguimiento_id = 2;
									$seguimiento->save();
								} elseif ($alumno->adeudos_cantidad >= 3) {
									//$cliente = Cliente::find($registro->cliente_id);
									$alumno->st_cliente_id = 26;
									$alumno->save();

									$adeudos = Adeudo::where('cliente_id', $alumno->cliente_id)
										->where('caja_id', 0)
										->where('pagado_bnd', 0)
										->whereDate('adeudos.fecha_pago','>',Date('Y-m-d'))
										->get();
									//dd($adeudos->toArray());
									foreach ($adeudos as $adeudo) {
										$adeudo->delete();
									}

									$seguimiento = Seguimiento::where('cliente_id', $alumno->id)->first();
									$seguimiento->st_seguimiento_id = 6;
									$seguimiento->save();
								}
							*/	
							//}else{
								/*$input['cliente_id']=$alumno->id;
								$input['fecha_baja']=Date('Y-m-d');
								$input['bnd_baja']=0;
								$input['usu_alta_id']=Auth::user()->id;
								$input['usu_mod_id']=Auth::user()->id;
								BsBaja::create($input);
								
							}*/
						//}
						//dd($resultado2['IsActive']);
					//}
				} catch (Exception $e) {
					Log::info("cliente no encontrado en Brigth Space u otro error: ".$alumno->matricula." - ".$e->getMessage());
					//return false;
				}
			}
		}
    }
}
