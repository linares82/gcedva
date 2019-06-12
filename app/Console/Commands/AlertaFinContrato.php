<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Empleado;
use DB;
use App\Mail\AlertaFinContrato as alerta;
use Mailgun;
use Log;
use Carbon\Carbon;

class AlertaFinContrato extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:FinContratos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa fechas de fin de contrato y envia alertas si esta activa la misma';

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
        $empleados=Empleado::select(DB::raw('distinct(r.mail)'),'empleados.resp_alerta_id', 'r.mail_empresa', 
                                    'j.mail as j_mail', 'j.mail_empresa as j_mail_empresa', 'empleados.dias_alerta','empleados.id',
                                    'empleados.fin_contrato')
                                ->join('empleados as r', 'r.id', '=', 'empleados.resp_alerta_id')
                                ->leftJoin('empleados as j', 'j.id', '=', 'empleados.jefe_id')
                                ->where('empleados.alerta_bnd', '=', 1)
                                ->whereDate('empleados.fin_contrato', '>=', date('Y/m/d'))
                                ->get();

        //dd($empleados->toArray());
        foreach($empleados as $e){
            //$fecha_valida=Carbon->now()->addDays($e->dias_alerta);
            //dd($e->fin_contrato);
            $hoy=Carbon::now();
            $dias_restantes=0;
            if (!is_null($e->fin_contrato)){
                $fin_contrato=Carbon::createFromFormat('Y-m-d', $e->fin_contrato)->toDateTimeString();
                $dias_restantes=$hoy->diffInDays($fin_contrato);
                //dd("dias - ".$dias_restantes);
                //Log::info("fin contrato - ".$fin_contrato);
            //echo Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString(); // 1975-05-21 22:00:00
                //dd("fil".$e->id);
            }
            
            
            $alertas=Empleado::select(DB::raw("concat(empleados.nombre,' ',empleados.ape_paterno, ' ',empleados.ape_materno) as nombre"), 
                                'empleados.dias_alerta', 'empleados.fin_contrato','empleados.id')
                    ->join('empleados as r', 'r.id', '=', 'empleados.resp_alerta_id')
                    ->leftJoin('empleados as j', 'j.id', '=', 'empleados.jefe_id')
                    ->where('empleados.alerta_bnd', '=', 1)
                    ->whereBetween('empleados.dias_alerta', ['0',$dias_restantes])
                    ->whereDate('empleados.fin_contrato','>',$hoy)
                    ->where('empleados.resp_alerta_id', '=', $e->resp_alerta_id)
                    ->get();
            //Log::info($alertas);
            //dd($alertas);
            $mail=$e->mail;
            $jefe_mail=$e->j_mail;
            
            //dd($alertas);
            
            /*\Mail::send('emails.alertaFinContrato', 
				array('ps'=>$alertas), 
				function($message) use($mail, $jefe_mail) 
                {
                    $message->to($mail);
                    if(!is_null($jefe_mail)){
                        $message->cc($jefe_mail);	
                    }
                    $message->subject('Alerta Contratos Por Vencer');
                });
                */
            if(count($alertas)>0){
                $respuesta=Mailgun::send('emails.alertaFinContrato', 
                    array('ps'=>$alertas),  
                    function ($message) use($mail, $jefe_mail) {
                        $message->to($mail);
                        if(!is_null($jefe_mail)){
                            $message->cc($jefe_mail);	
                        }
                        $message->subject('Alerta Contratos Por Vencer');
                });
            }
            	
            //dd($respuesta);
        }
    }
}
