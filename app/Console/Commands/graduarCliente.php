<?php

namespace App\Console\Commands;

use App\Adeudo;
use App\Cliente;
use App\Inscripcion;
use App\Plantel;
use App\Seguimiento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class graduarCliente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:GraduarCliente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambiar estatus de clientes sin adeudos';

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
        $planteles = Plantel::all();
        foreach ($planteles as $plantel) {
            $clientes_inscritos = Inscripcion::select('cliente_id')->where('plantel_id', $plantel->id)->get();
            //dd($clientes_inscritos->toArray());
            foreach ($clientes_inscritos as $cliente_inscrito) {
                $cliente = Cliente::find($cliente_inscrito->cliente_id);
                $seguimiento = Seguimiento::where('cliente_id', $cliente_inscrito->cliente_id)->first();
                $adeudos = Adeudo::where('cliente_id', $cliente_inscrito->cliente_id)->where('pagado_bnd', 0)->count();
                if ($adeudos == 0 and $cliente->st_cliente_id == 4 and $seguimiento->st_seguimiento_id == 2) {

                    $cliente->st_cliente_id = 20;
                    $cliente->save();

                    $seguimiento->st_seguimiento_id = 7;
                    $seguimiento->save();

                    Log::info('egresado:' . $cliente->id . ' - ' . $seguimiento->id);
                }
            }
        }
    }
}
