<?php

namespace App\Console\Commands;

use App\Prospecto;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProspectoToAsesores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:prospecToAsesores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica prospectos capturados y 72 horas transcurridas para asignarlos a asesores';

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
        $prospectos=Prospecto::where('st_prospecto_id',1)->get();
        foreach($prospectos as $prospecto){
            $creacion=$prospecto->created_at;
            //dd($creacion);
            $hoy=Carbon::createFromFormat('Y-m-d',date('Y-m-d'));
            //dd($hoy->diffInDays($creacion));
            if($hoy->diffInDays($creacion)>=3){
                //Log::info($hoy->diffInDays($creacion));
                //dd($hoy->diffInDays($creacion));
                $prospecto->st_prospecto_id=2;
                $prospecto->save();
            }
        }
    }
}
