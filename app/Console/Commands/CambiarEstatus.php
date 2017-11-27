<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

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
    protected $description = 'Estatus 4 (En proceso) cambia a estatus 1 (Pendiente) despues de 7 dias.';

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
        $rs=DB::table('seguimientos')->where('st_seguimiento_id', '=', '4')->get();
        //dd($rs->toArray());
        foreach($rs as $r){
            $ultimo=DB::table('hactividades')->where('seguimiento_id', '=', $r->id)->orderBy('id', 'desc')->first();
            if($ultimo){
                //dd($ultimo);
                $hoy = Carbon::now();
                $fecha = Carbon::parse($ultimo->fecha);
                $dif=$hoy->diffInDays($fecha);
                if($dif>7){
                    $registro=Seguimiento::find($r->id);
                    //dd($registro->toArray());
                    $registro->st_seguimiento_id=1;
                    $registro->save();
                }
            }
        }
    }
}
