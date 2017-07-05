<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Plantilla;
use App\Cliente;
use App\Correo as Corre;
use App\Param;
use DB;
use App\Mail\Correo;

class EnviarCorreos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:EnviarCorreos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa tabla de plantillas y envia correos segun condiciones';

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
        $c=0;
        $cantidad_enviada=0;
        //$status_array=array();
        //$data = $request->all();
        /*$data['email']="linares82@gmail.com";
        $data['subject']='prb envio';
        $data['name']='linares82';

        \Mail::send('emails.1', array(), function($message) use ($data)
                 {
                     //remitente
                    //dd($cli);
                     //$message->from($cli->mail, $cli->nombre);
                     $message->from($data['email'], $data['name']);
           
                     //asunto
                     $message->subject("sin asunto");
           
                     //receptor
                     $message->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
           
                 });
        */
        $r=Param::where('llave','=', 'correo_electronico')->first();
        //dd($r->valor);
        if($r->valor=='activo'){
            
            $ps=Plantilla::select('id', 'st_cliente_id', 'dia', 'tpo_correo_id', 'para_nombre', 'asunto')
                ->where('tpo_correo_id', '<>', '1')
                ->orderBy('tpo_correo_id', 'asc')
                ->get();

            foreach($ps as $p){
              
                switch ($p->tpo_correo_id) {
                    case '2': //revisar definicion
                        //dd($status_array);
                        $dia=date("j");
                        if($dia==$p->dia){
                            //dd($dia);
                            $clis=DB::table('clientes')->whereIn('nivel_id', $p->nivel_id)->get();
                            //dd($clis);
                            
                            try{
                                $m=\Mail::to("blind@blind.com", 'nombre');    
                                foreach($clis as $cli){
                                    $m->bcc($cli->mail, $cli->nombre);
                                    $cantidad_enviada++;
                                }
                                $m->queue(new Correo($p));
                                dd('correo enviado');
                            }catch(\Exception $e){
                            dd($e);
                            }
                                                    
                        }
                        break;
                    case '3':
                        $status_array='';
                        $aux=0;
                        foreach($p->estatus as $st){
                            //dd($st->id);
                            if($aux==0){
                                $status_array=$status_array.$st->id;
                            }else{
                                $status_array=",".$status_array.$st->id;
                            }
                        }
                        
                        //dd($status_array);
                        $dia=date("j");
                        if($p->inicio<=$dia and $p->fin>=$dia){
                            //dd($dia);
                            $clis=DB::table('clientes')->whereIn('st_cliente_id', [$status_array])->get();
                            //dd($clis);
                            
                            try{
                                $m=\Mail::to("blind@blind.com", 'nombre');    
                                foreach($clis as $cli){
                                    $m->bcc($cli->mail, $cli->nombre);
                                    $cantidad_enviada++;
                                }
                                $m->queue(new Correo($p));
                                dd('correo enviado');
                            }catch(\Exception $e){
                            dd($e);
                            }
                                                    
                        }
                        break;
                    case '4':
                        $status_array='';
                        $aux=0;
                        foreach($p->estatus as $st){
                            //dd($st->id);
                            if($aux==0){
                                $status_array=$status_array.$st->id;
                            }else{
                                $status_array=",".$status_array.$st->id;
                            }
                        }
                        
                        //dd($status_array);
                        $dia=date("j");
                        if($dia==$p->dia){
                            //dd($dia);
                            $clis=DB::table('clientes')->whereIn('st_cliente_id', [$status_array])->get();
                            //dd($clis);
                            
                            try{
                                $m=\Mail::to("blind@blind.com", 'nombre');    
                                foreach($clis as $cli){
                                    $m->bcc($cli->mail, $cli->nombre);
                                    $cantidad_enviada++;
                                }
                                $m->queue(new Correo($p));
                                
                            }catch(\Exception $e){
                            dd($e);
                            }
                                                    
                        }
                        break;
                }
            }
            $input2['usu_envio_id']=1;
            $input2['cliente_id']=1;
            $input2['fecha_envio']=date("Y/m/d");
            $input2['cantidad']=$cantidad_enviada;
            $input2['usu_alta_id']=1;
            $input2['usu_mod_id']=1;
            Corre::create($input2);
        }
    }
}
