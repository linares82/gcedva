<?php

namespace App\Console\Commands;

use App\Grado;
use App\Param;
use App\Adeudo;
use App\Cliente;
use Carbon\Carbon;
use App\PlanPagoLn;
use App\UsuarioCliente;
use App\CombinacionCliente;
use App\ConsecutivoMatricula;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class IANMatricula extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:GenerarMatricula';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera matricula para clientes con pago en septiembre';

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
        $adeudos = Adeudo::select('adeudos.*')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('clientes as cli', 'cli.id', '=', 'adeudos.cliente_id')
            ->whereIn('cc.id', array(1, 22, 23, 24, 25))
            //->where('pagado_bnd', 1)->where('fecha_pago', '>=', '2020-09-01')
            ->whereIn('cli.id', array(
                
            ))
            ->whereNull('adeudos.deleted_at')
            //->where('cli.matricula', '')
            //->take(5)
            ->get();
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {
            if (is_null($adeudo->cliente->matricula) or $adeudo->cliente->matricula == " ") {
                //Genera la matricula para un cliente si no la tiene.
                //Datos para matricula
                $cajaLn = $adeudo->caja->cajaLns->first();
                //dd($cajaLn->toArray());
                $combinacion = CombinacionCliente::where('cliente_id', $adeudo->cliente_id)
                    ->where('plantel_id', '<>', 0)
                    ->where('especialidad_id', '<>', 0)
                    ->where('nivel_id', '<>', 0)
                    ->where('grado_id', '<>', 0)
                    ->where('turno_id', '<>', 0)
                    ->where('plan_pago_id', '<>', 0)
                    ->whereNull('deleted_at')
                    ->first();
                //dd($combinacion->toArray());
                $marcador = 0;
                if (is_null($combinacion)) {
                    Log::info('cliente:' . $adeudo->cliente_id . "Sin combinacion");
                    $marcador = 1;
                }
                //dd($combinacion);
                $planPagoLn = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->orderBy('fecha_pago', 'asc')->first();
                if (is_null($planPagoLn)) {
                    Log::info('cliente:' . $adeudo->cliente_id . "Sin plan de pago");
                    $marcador = 1;
                } else {
                    //$adeudos = Adeudo::where('combinacion_cliente_id', $combinacion->id)->where('caja_concepto_id', 1)->first();
                    //dd($adeudos);
                    //$inscripcionConcepto = $adeudos->where('caja_concepto_id', 1);
                    //$lectivo = Lectivo::find($combinacion->lectivo_id);
                    //dd($planPagoLn);
                    $param=Param::where('llave','prefijo_matricula_instalacion')->first();
                    $fecha = Carbon::createFromFormat('Y-m-d', $planPagoLn->fecha_pago);
                    $grado = Grado::find($combinacion->grado_id);
                    //Log::info("grado: " . $grado->id);
                    //dd($grado);
                    $relleno = "000000";
                    $rellenoPlantel = "00";
                    $rellenoConsecutivo = "000";

                    //dd($consecutivo);
                    $cliente = Cliente::where('id', $adeudo->cliente_id)->first();
                    //dd(($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " "));
                }

                if (($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " ") and $marcador == 0) {
                    //dd('entra');
                    $consecutivo = ConsecutivoMatricula::where('plantel_id', $combinacion->plantel_id)
                        ->where('anio', $fecha->year)
                        ->where('mes', $fecha->month)
                        ->where('seccion', $grado->seccion)
                        ->first();

                    if (is_null($consecutivo)) {
                        $consecutivo = ConsecutivoMatricula::create(array(
                            'plantel_id' => $combinacion->plantel_id,
                            'mes' => $fecha->month,
                            'anio' => $fecha->year,
                            'seccion' => $grado->seccion,
                            'consecutivo' => 1,
                            'usu_alta_id' => 1,
                            'usu_mod_id' => 1,
                        ));
                    } else {
                        $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                        $consecutivo->save();
                    }
                    $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
                    $anio = $fecha->year - 2000;
                    $plantel = substr($rellenoPlantel, 0, 2 - strlen($combinacion->plantel_id)) . $combinacion->plantel_id;
                    $seccion = $grado->seccion;
                    $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;

                    if($param<>0){
                        $entrada['matricula'] = $param->valor. $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    }else{
                        $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    }
                    
                    //$i->update($entrada);

                    //dd($entrada['matricula']);
                    $cliente->matricula = $entrada['matricula'];
                    $cliente->save();
                    Log::info('matricula cliente -' . $cliente->id . "-" . $cliente->matricula);

                    if (!is_null($cliente->matricula)) {
                        $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->first();
                        $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();
                        if (is_null($buscarMatricula) and is_null($buscarMail)) {
                            $usuario_cliente['name'] = $cliente->matricula;
                            if (is_null($cliente->mail) or $cliente->mail == "") {
                                $usuario_cliente['email'] = "Sin correo";
                            } else {
                                $usuario_cliente['email'] = $cliente->mail;
                            }
                            $usuario_cliente['password'] = Hash::make('123456');
                            UsuarioCliente::create($usuario_cliente);
                        }
                    }
                } else {
                    if (is_null($grado->seccion)) {
                        Log::info("seccion vacia:" . $grado->seccion . " del grado con id " . $grado->id);
                    }
                }
            }
        }
    }
}
