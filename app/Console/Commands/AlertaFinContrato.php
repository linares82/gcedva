<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Empleado;
use DB;
use App\Mail\AlertaFinContrato as alerta;
use Mail;
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
        $empleados=Empleado::select(DB::raw('distinct(r.mail), empleados.resp_alerta_id, r.mail_empresa, j.mail as j_mail,j.mail_empresa as j_mail_empresa,'
                                . 'empleados.dias_alerta, empleados.id, empleados.nombre, empleados.fin_contrato,'
                                . 'date_sub(empleados.fin_contrato, interval empleados.dias_alerta day) as fecha_alerta, '
                                . 'datediff(empleados.fin_contrato, curdate()) as dias_restantes'))
                                ->join('empleados as r', 'r.id', '=', 'empleados.resp_alerta_id')
                                ->leftJoin('empleados as j', 'j.id', '=', 'empleados.jefe_id')
                                ->where('empleados.alerta_bnd', '=', 1)
                                ->where('empleados.st_empleado_id','<>',2) 
                                ->whereDate('empleados.fin_contrato', '>=', date('Y/m/d'))
                                ->whereRaw('empleados.dias_alerta >= datediff(empleados.fin_contrato, curdate())')
                                ->get();

        //dd($empleados->toArray());
        foreach($empleados as $empleado){
            //$mail=$empleado->mail;
            //$jefe_mail=$e->j_mail_empresa;
            $responsable_mail=$empleado->mail_empresa;
        }
        //dd($responsable_mail);
        
            
            
        if(count($empleados)>0){
            //dd($alertas);
            
            $respuesta=Mail::send('emails.alertaFinContrato', 
				array('ps'=>$empleados), 
				function($message) use($responsable_mail) 
                {
                    $message->to($responsable_mail);
                    /*if(!is_null($jefe_mail)){
                        $message->cc($jefe_mail);	
                    }*/
                    $message->subject('Alerta Contratos Por Vencer');
                });
             
           
            /*
            $respuesta=Mailgun::send('emails.alertaFinContrato', 
                array('ps'=>$empleados),  
                function ($message) use($responsable_mail) {
                    $message->to($responsable_mail);
                    if(!is_null($jefe_mail)){
                        $message->cc($jefe_mail);	
                    }
                    if(!is_null($responsable_mail)){
                        $message->cc($responsable_mail);	
                    }
                    $message->subject('Alerta Contratos Por Vencer');
            });*/
        }
            	
        
        
    }
}
