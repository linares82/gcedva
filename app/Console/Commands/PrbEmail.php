<?php

namespace App\Console\Commands;

use App\Empresa;
use App\Mail\MailingEmpresas;
use App\PlantillaEmpresa;
use App\PlantillaEmpresaCond;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Storage;

class PrbEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:prbEmail';

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
        $plantilla_empresas = PlantillaEmpresa::where('activo_bnd', 1)->where('mail_bnd', 1)->get();

        foreach ($plantilla_empresas as $plantilla_empresa) {
            $dia_hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->day;
            $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
            $inicio = Carbon::createFromFormat('Y-m-d', $plantilla_empresa->inicio);
            $fin = Carbon::createFromFormat('Y-m-d', $plantilla_empresa->fin);
            if ($plantilla_empresa->dia > 0 and $plantilla_empresa->dia == $dia_hoy) {
                $condiciones = PlantillaEmpresaCond::where('plantilla_empresa_id', $plantilla_empresa->id)->get();
                $resultado = Empresa::select('razon_social', 'nombre_contacto', 'correo1')->whereNotNull('empresas.correo1');
                foreach ($condiciones as $c) {
                    switch ($c->plantillaEmpresaCampo->campo) {
                        case 'Estatus':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                            }

                            break;
                        case 'Plantel':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                            break;
                        case 'Giro':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                            break;
                    }
                }
                $empresas = $resultado->get();

                /**SEgundo metodo con colas */
                foreach ($empresas as $empresa) {
                    $data = [
                        'nombre_contacto' => $empresa->nombre_contacto,
                        'razon_social' => $empresa->razon_social
                    ];
                    //dd($data);
                    $obj = new \stdClass();
                    $obj->plantilla = $plantilla_empresa->parsePlantilla($data);
                    $obj->asunto = $plantilla_empresa->asunto;
                    $obj->img1 = $plantilla_empresa->img1;

                    Mail::to($empresa->correo1)->send(new MailingEmpresas($obj));
                }
            } elseif ($plantilla_empresa->inicio <> "" and $plantilla_empresa->fin <> "") {
                $anio_hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->year;
                $anio_inicio = Carbon::createFromFormat('Y-m-d', $plantilla_empresa->inicio)->year;
                $anio_fin = Carbon::createFromFormat('Y-m-d', $plantilla_empresa->fin)->year;
                if ($anio_inicio > $anio_hoy and $anio_hoy > $anio_fin) {
                    $condiciones = PlantillaEmpresaCond::where('plantilla_empresa_id', $plantilla_empresa->id)->get();

                    $resultado = Empresa::select('razon_social', 'nombre_contacto', 'correo1')->whereNotNull('empresas.correo1');
                    foreach ($condiciones as $c) {
                        switch ($c->plantillaEmpresaCampo->campo) {
                            case 'Estatus':
                                if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                    $resultado->where('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                                } else {
                                    $resultado->orWhere('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                                }

                                break;
                            case 'Plantel':
                                if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                    $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                } else {
                                    $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                }
                                break;
                            case 'Giro':
                                if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                    $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                } else {
                                    $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                }
                                break;
                        }
                    }
                    $empresas = $resultado->get();

                    foreach ($empresas as $empresa) {
                        $data = [
                            'nombre_contacto' => $empresa->nombre_contacto,
                            'razon_social' => $empresa->razon_social
                        ];
                        //dd($data);
                        $obj = new \stdClass();
                        $obj->plantilla = $plantilla_empresa->parsePlantilla($data);
                        $obj->asunto = $plantilla_empresa->asunto;
                        $obj->img1 = $plantilla_empresa->img1;

                        Mail::to($empresa->correo1)->send(new MailingEmpresas($obj));
                    }
                }
            } elseif (($plantilla_empresa->dia <> 0 or $plantilla_empresa->dia <> "") and $plantilla_empresa->inicio<>"" and $plantilla_empresa->fin<>"") {
                $condiciones = PlantillaEmpresaCond::where('plantilla_empresa_id', $plantilla_empresa->id)->get();

                $resultado = Empresa::select('razon_social', 'nombre_contacto', 'correo1')->whereNotNull('empresas.correo1');
                foreach ($condiciones as $c) {
                    switch ($c->plantillaEmpresaCampo->campo) {
                        case 'Estatus':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.id', $c->signo_comparacion, $c->valor_condicion);
                            }

                            break;
                        case 'Plantel':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                            break;
                        case 'Giro':
                            if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera Condición") {
                                $resultado->where('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            } else {
                                $resultado->orWhere('empresas.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                            break;
                    }
                }
                $empresas = $resultado->get();
                /*Primer metodo de envio sin colas*/
                /*foreach($empresas as $empresa){
                Mail::send([], [], function ($message) use ($plantilla_empresa, $empresa) {
                    $data = [
                        'nombre' => $empresa->nombre_contacto
                    ];

                    //dd($plantilla_empresa->parsePlantilla($data));

                    $message->to($empresa->correo1, $empresa->razon_social)
                        ->subject($plantilla_empresa->asunto)
                        ->setBody($plantilla_empresa->parsePlantilla($data), 'text/html');
                });
            }*/

                /**SEgundo metodo con colas */
                foreach ($empresas as $empresa) {
                    $data = [
                        'nombre_contacto' => $empresa->nombre_contacto,
                        'razon_social' => $empresa->razon_social
                    ];
                    //dd($data);
                    $obj = new \stdClass();
                    $obj->plantilla = $plantilla_empresa->parsePlantilla($data);
                    $obj->asunto = $plantilla_empresa->asunto;
                    $obj->img1 = $plantilla_empresa->img1;

                    Mail::to($empresa->correo1)->send(new MailingEmpresas($obj));
                }
            }
        }
    }
}
