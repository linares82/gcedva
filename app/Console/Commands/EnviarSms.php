<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sms;
use App\Param;

class EnviarSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:EnviarSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia mensajes dado un telefono y un mensaje';

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
        $r=Param::where('llave','=', 'sms')->first();
        if($r->value=='activo'){
            dd($r);
            $message  = "Hello Phone de prueba!";
            $to       = "+527221569361";
            $from     = "+13093196909";
            $response = Sms::send($message,$to,$from);    
        }
        
    }
}
