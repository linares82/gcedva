<?php

namespace App\Console\Commands;

use App\Prospecto;
use Carbon\Carbon;
use App\DiaNoHabil;
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
    protected $description = 'Verifica prospectos capturados y 24 horas transcurridas para asignarlos a asesores';

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

        $prospectos = Prospecto::where('st_prospecto_id', 1)->whereNull('fec_apartado')->get();

        //dd($prospectos->toArray());
        $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

        foreach ($prospectos as $prospecto) {
            $creacion = Carbon::createFromFormat('Y-m-d', $prospecto->fecha);
            $dias = 0;
            while ($hoy->greaterThan($creacion)) {
                $creacion->addDay();
                if (
                    $creacion->dayOfWeek == 1 or
                    $creacion->dayOfWeek == 2 or
                    $creacion->dayOfWeek == 3 or
                    $creacion->dayOfWeek == 4 or
                    $creacion->dayOfWeek == 5
                ) {

                    $dias_no_habiles = DiaNoHabil::where('fecha', $creacion->toDateString())->first();
                    if (is_null($dias_no_habiles)) {
                        $dias++;
                        //echo $prospecto->id."--".$dias."**";
                        if (
                            $dias >= 1
                            and $prospecto->tel_cel <> "" and !is_null($prospecto->tel_cel)
                            and $prospecto->mail <> "" and !is_null($prospecto->mail)
                        ) {
                            //Log::info($hoy->diffInDays($creacion));
                            //dd($hoy->diffInDays($creacion));
                            //dd($prospecto->toArray());
                            $prospecto->st_prospecto_id = 2;
                            $prospecto->save();
                        }
                    }
                }
            }


            //dd($creacion);

            //dd($hoy->diffInDays($creacion));

        }

        $prospectos_postpuestos = Prospecto::where('st_prospecto_id', 1)->whereNotNull('fec_apartado')->get();
        //dd($prospectos_postpuestos->toArray());
        foreach ($prospectos_postpuestos as $prospecto) {
            $fec_apartado = Carbon::createFromFormat('Y-m-d', $prospecto->fec_apartado);
            $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
            //dd($fec_apartado);
            //dd($hoy->greaterThanOrEqualTo($fec_apartado));

            if ($hoy->greaterThanOrEqualTo($fec_apartado)) {
                if (
                    $dias >= 2
                    and $prospecto->tel_cel <> "" and !is_null($prospecto->tel_cel)
                    and $prospecto->mail <> "" and !is_null($prospecto->mail)
                ) {
                    $prospecto->st_prospecto_id = 2;
                    $prospecto->save();
                }
            }



            //dd($creacion);

            //dd($hoy->diffInDays($creacion));

        }
    }
}
