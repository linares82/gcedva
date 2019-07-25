<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Adeudo;
use App\Cliente;
use App\HistoriaCliente;
use App\Seguimiento;
use DB;
use Carbon\Carbon;

class AtrazoPagos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:AtrazoPagos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa retrazo en pagos y cambia estatus de cliente y seguimiento';

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
        $fechaActual=Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        if($fechaActual->day>=10){
            $registros=Adeudo::select(DB::raw('cliente_id, count(cliente_id) as adeudos_cantidad'))
                            ->join('clientes as c','c.id','=','adeudos.cliente_id')
                            ->where('fecha_pago','<=',$fechaActual)
                            ->where('pagado_bnd',0)
                            ->where('c.st_cliente_id','<>',25)
                            ->where('c.st_cliente_id','<>',3)
                            ->groupBy('cliente_id')
                            ->having('adeudos_cantidad','>',0)
                            ->having('adeudos_cantidad','<',3)
                            ->get();
           //dd($registros->toArray());

           foreach($registros as $registro){
               $hoy=date('Y-m-d');
               $eventos=HistoriaCliente::where('cliente_id', $registro->cliente_id)
                                       ->where('evento_cliente_id',6)
                                       ->whereDate('fec_vigencia','>=',$hoy)
                                       ->whereNull('historia_clientes.deleted_at')
                                       ->get();
               //dd($eventos->toArray());
               if(count($eventos)==0){
                   if($registro->adeudos_cantidad==1){
                        $cliente=Cliente::find($registro->cliente_id);
                        $cliente->st_cliente_id=25;
                        $cliente->save();

                        $seguimiento=Seguimiento::where('cliente_id',$cliente->id)->first();
                        $seguimiento->st_seguimiento_id=2;
                        $seguimiento->save();
                    }elseif($registro->adeudos_cantidad==2){
                        $cliente=Cliente::find($registro->cliente_id);
                        $cliente->st_cliente_id=25;
                        $cliente->save();

                        $seguimiento=Seguimiento::where('cliente_id',$cliente->id)->first();
                        $seguimiento->st_seguimiento_id=2;
                        $seguimiento->save();
                    }
               }
            }
        }
    }
}
