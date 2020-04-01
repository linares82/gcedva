<?php

namespace App\Console\Commands;

use App\Cliente;
use App\Param;
use App\PlanCondicionFiltro;
use App\Plantilla;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Sms;

class EnvioSmsMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:EnvioSmsMail {plantilla=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de SMS y MAIL de acuerdo a condiciones fijadas en plantillas';

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
        $mail_bnd = Param::where('llave', '=', 'correo_electronico')->first();
        $sms_bnd = Param::where('llave', '=', 'sms')->first();
        $cel_from = Param::where('llave', '=', 'num_twilio')->first();
        $plantilla_ejecutar = $this->argument('plantilla');
        if ($mail_bnd = 'activo') {
            if ($plantilla_ejecutar == 0) {
                $plantillas = Plantilla::where('id', '>', 2)->where('activo_bnd', '=', 1)->where('mail_bnd', '=', 1)->get();
            } else {
                $plantillas = Plantilla::where('id', '>', 2)->where('activo_bnd', '=', 1)->where('mail_bnd', '=', 1)->where('id', '=', $plantilla_ejecutar)->get();
            }
            foreach ($plantillas as $p) {
                $dia = date("j");

                if ($p->dia > 0 and !$p->dia = "") {
                    //dd($p->toArray());
                    if ($dia == $p->dia) {
                        $condiciones = PlanCondicionFiltro::where('plantilla_id', '=', $p->id)->get();
                        $resultado = Cliente::select(DB::raw('concat(nombre," ",nombre2," ",ape_paterno," ",ape_materno) as nombre'),
                            'nombre')
                            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                            ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                            ->join('segmento_mercados as sm', 'sm.id', '=', 'clientes.segmento_mercado_id')
                            ->where('clientes.correo_confirmado', "=", 1)
                            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
                            ->join('grados as g', 'g.id', '=', 'cc.grado_id');
                        foreach ($condiciones as $c) {
                            switch ($c->campo->campo) {
                                case 'Estatus':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    }

                                    break;
                                case 'Plantel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    }
                                    break;
                                case 'Especialidad':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Nivel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Grado':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }
                                    break;
                                case 'Segmento Mercado':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('sm.id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('sm.id', $c->signo_comparacion, $c->valor_condicion);
                                    }

                                    break;
                            }
                        }
                        $resultado->get();
                        try {
                            foreach ($resultado as $cli) {
                                //$m=\Mail::to($cli->mail, $cli->nombre);
                                //$m->queue(new Correo($p));

                                \Mail::send('emails.4', array('img1' => storage_path('app') . "/public/imagenes/plantillas_correos/" . $p->img1, 'plantilla' => $p->plantilla, 'id' => $cli->id), function ($message) use ($request) {
                                    $message->to($cli->mail, $cli->nombre . " " . $cli->ape_paterno . " " . $cli->ape_materno);
                                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                    $message->subject($p->asunto);
                                });

                            }
                            //$m->queue(new Correo($p));
                            dd('correo enviado');
                        } catch (\Exception $e) {
                            dd($e);
                        }
                    }
                } else {
                    $hoy = date('Y-m-d');
                    $inicio = Carbon::createFromFormat('Y-m-d', $p->inicio)->toDateTimeString();
                    $fin = Carbon::createFromFormat('Y-m-d', $p->fin)->toDateTimeString();
//dd($inicio);
                    if ($p->inicio <= $hoy and $p->fin >= $hoy) {
//dd($p->toArray());
                        $condiciones = PlanCondicionFiltro::where('plantilla_id', '=', $p->id)->get();
                        $resultado = Cliente::join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                            ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                            ->where('clientes.correo_confirmado', "=", 1)
                            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
                            ->join('grados as g', 'g.id', '=', 'cc.grado_id');
//dd($condiciones->toArray());
                        foreach ($condiciones as $c) {
                            switch ($c->campo->campo) {
                                case 'Estatus':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    }

                                    break;
                                case 'Plantel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    }
                                    break;
                                case 'Especialidad':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Nivel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Grado':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                            }
                        }
                        $clientes = $resultado->get();
                        try {
                            //dd($clientes->toArray());
                            foreach ($clientes as $cli) {
                                //$m=\Mail::to($cli->mail, $cli->nombre);
                                //$m->queue(new Correo($p));
                                \Mail::send('emails.4', array('img1' => storage_path('app') . "/public/imagenes/plantillas_correos/" . $p->img1, 'plantilla' => $p->plantilla, 'id' => $cli->id), function ($message) use ($cli, $p) {
                                    $message->to($cli->mail, $cli->nombre . " " . $cli->ape_paterno . " " . $cli->ape_materno);
                                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                                    $message->subject($p->asunto);
                                });
                            }
                            //$m->queue(new Correo($p));
                            dd('correo enviado');
                        } catch (\Exception $e) {
                            dd($e);
                        }
                    }
                }

            }
        }
        if ($sms_bnd = 'activo') {
            if ($plantilla_ejecutar == 0) {
                $plantillas = Plantilla::where('id', '>', 2)->where('activo_bnd', '=', 1)->where('sms_bnd', '=', 1)->get();
            } else {
                $plantillas = Plantilla::where('id', '>', 2)->where('activo_bnd', '=', 1)->where('sms_bnd', '=', 1)->where('id', '=', $plantilla)->get();
            }

            foreach ($plantillas as $p) {
                $dia = date("j");
                if ($p->dia > 0 and !$p->dia = "") {
                    if ($dia == $p->dia) {
                        $condiciones = PlanCondicionFiltro::where('plantilla_id', '=', $p->id)->get();
                        $resultado = Cliente::select('tel_cel')
                            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                            ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                            ->where('clientes.celular_confirmado', "=", 1)
                            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
                            ->join('grados as g', 'g.id', '=', 'cc.grado_id');
                        foreach ($condiciones as $c) {
                            switch ($c->campo->campo) {
                                case 'Estatus':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    }

                                    break;
                                case 'Plantel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    }
                                    break;
                                case 'Especialidad':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Nivel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Grado':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                            }
                        }
                        $resultado->get();
                        try {
                            foreach ($clis as $cli) {
                                $to = '+52' . $cli->tel_cel;
                                $from = $cel_from;
                                $message = $p->sms;
                                $response = $this->sendMessage($message, $to); //Sms::send($message,$to,$from);
                            }
                            //$m->queue(new Correo($p));
                            dd('sms enviado');
                        } catch (\Exception $e) {
                            dd($e);
                        }
                    }
                } else {
                    $hoy = date('Y-m-d');
                    $inicio = Carbon::createFromFormat('Y-m-d', $p->inicio)->toDateTimeString();
                    $fin = Carbon::createFromFormat('Y-m-d', $p->fin)->toDateTimeString();
//dd($inicio);
                    if ($p->inicio <= $hoy and $p->fin >= $hoy) {
//dd($p->toArray());

                        $condiciones = PlanCondicionFiltro::where('plantilla_id', '=', $p->id)->get();
                        $resultado = Cliente::select('tel_cel')
                            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                            ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
                            ->where('clientes.celular_confirmado', "=", 1)
                            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
                            ->join('grados as g', 'g.id', '=', 'cc.grado_id');
                        foreach ($condiciones as $c) {
                            switch ($c->campo->campo) {
                                case 'Estatus':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('st.id', $c->signo_comparacion, $c->valor_condicion);
                                    }

                                    break;
                                case 'Plantel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        $resultado->where('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    } else {
                                        $resultado->orWhere('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                                    }
                                    break;
                                case 'Especialidad':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Nivel':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                                case 'Grado':
                                    if ($c->operador_condicion == "and" or $c->operador_condicion == "Primera CondiciÃ³n") {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    } else {
                                        if ($c->signo_comparacion == "like") {
                                            $resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
                                        } else {
                                            $resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                                        }
                                    }

                                    break;
                            }
                        }
                        $resultado->get();
                        try {
                            foreach ($clis as $cli) {
                                $to = '+52' . $cli->tel_cel;
                                $from = $cel_from;
                                $message = $p->sms;
                                $response = $this->sendMessage($message, $to); //Sms::send($message,$to,$from);
                            }
                            //$m->queue(new Correo($p));
                            dd('sms enviado');
                        } catch (\Exception $e) {
                            dd($e);
                        }
                    }
                }
            }
        }
    }

    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    private function sendMessage($message, $telefonos)
    {
        $account_sid = Param::where('llave', '=', 'TWILIO_AUTH_SID')->first();
        $auth_token = Param::where('llave', '=', 'TWILIO_AUTH_TOKEN')->first();
        $twilio_number = Param::where('llave', '=', 'TWILIO_FROM')->first();

        $client = new Client($account_sid->valor, $auth_token->valor);
        $client->messages->create($telefonos,
            ['from' => $twilio_number->valor, 'body' => $message]);
    }
}
