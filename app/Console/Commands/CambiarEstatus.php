<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Eloquent;
use DB;
use App\Hactividade;
use App\Seguimiento;
use Auth;
use Carbon\Carbon;
use Log;

class CambiarEstatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:CambiarEstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Estatus 4 (En proceso) cambia a estatus 1 (Pendiente) despues de 5 dias.';

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
        $rs=DB::table('seguimientos')->where('st_seguimiento_id', '=', '4')
        ->orderBy('cliente_id')
        //->where('cliente_id','<',100)
        ->whereNull('deleted_at')
        ->get();
        //dd($rs->toArray());
        Log::info('Id seguimiento con estatus cambiado despues de 5 dias de la ultima actividad');
        foreach($rs as $r){
            $ultima_actividad=DB::table('hactividades')
            ->where('seguimiento_id', '=', $r->id)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')->first();
            if(!is_null($ultima_actividad)){
                //dd($ultimo);
                $hoy = Carbon::now();
                $fecha = Carbon::parse($ultima_actividad->fecha);
                $dif=$hoy->diffInDays($fecha);
                if($dif>5){
                    //Log::info('seguimiento_id:'.$ultima_actividad->seguimiento_id);
                    Log::info('seguimiento_id:'.$ultima_actividad->seguimiento_id." - fecha: ".$ultima_actividad->fecha);
                    //dd($ultima_actividad);
                    $registro=Seguimiento::find($r->id);
                    //dd($registro->toArray());
                    $registro->st_seguimiento_id=1;
                    $registro->save();
                }
            }
        }
    }
}
