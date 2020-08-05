<?php

namespace App\Console\Commands;

use App\Adeudo;
use App\Cliente;
use App\CombinacionCliente;
use App\ConsecutivoMatricula;
use App\Grado;
use App\PlanPagoLn;
use App\UsuarioCliente;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('clientes as cli', 'cli.id', '=', 'adeudos.cliente_id')
            ->where('pagado_bnd', 1)->where('fecha_pago', '>=', '2020-09-01')
            ->where('cli.matricula', '')
            //->take(5)
            ->get();
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {
            //Genera la matricula para un cliente si no la tiene.
            //Datos para matricula
            $cajaLn = $adeudo->caja->cajaLns->first();

            $combinacion = CombinacionCliente::find($cajaLn->adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $planPagoLn = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->orderBy('fecha_pago', 'asc')->first();
            //$adeudos = Adeudo::where('combinacion_cliente_id', $combinacion->id)->where('caja_concepto_id', 1)->first();
            //dd($adeudos);
            //$inscripcionConcepto = $adeudos->where('caja_concepto_id', 1);
            //$lectivo = Lectivo::find($combinacion->lectivo_id);
            //dd($planPagoLn);
            $fecha = Carbon::createFromFormat('Y-m-d', $planPagoLn->fecha_pago);
            $grado = Grado::find($combinacion->grado_id);
            //Log::info("grado: " . $grado->id);
            //dd($grado);
            $relleno = "00000";
            $rellenoPlantel = "00";
            $rellenoConsecutivo = "000";


            //dd($consecutivo);
            $cliente = Cliente::where('id', $combinacion->cliente_id)->first();
            //dd(($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " "));
            if (($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " ")) {
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
                        'usu_mod_id' => 1
                    ));
                } else {
                    $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                    $consecutivo->save();
                }
                $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
                $anio = $fecha->year - 2000;
                $plantel = substr($rellenoPlantel, 0, 2 - strlen($combinacion->plantel_id)) . $combinacion->plantel_id;
                $seccion = substr($relleno, 0, 5 - strlen($grado->seccion)) . $grado->seccion;
                $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;

                $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                //$i->update($entrada);

                //dd($entrada['matricula']);
                $cliente->matricula = $entrada['matricula'];
                $cliente->save();
                Log::info($cliente->id . " - " . $cliente->matricula);

                if (!is_null($cliente->matricula)) {
                    $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->first();
                    $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();
                    if (is_null($buscarMatricula) and is_null($buscarMail)) {
                        $usuario_cliente['name'] = $cliente->matricula;
                        $usuario_cliente['email'] = $cliente->mail;
                        $usuario_cliente['password'] = Hash::make('123456');
                        UsuarioCliente::create($usuario_cliente);
                    }
                }
            }
        }
    }
}
