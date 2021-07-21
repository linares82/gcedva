<?php

namespace App\Console\Commands;

use App\Mese;
use App\Cliente;
use Carbon\Carbon;
use App\AlumnosActivo;
use Illuminate\Console\Command;
use App\CajaConcepto as CajaConcepto;

class alumnosActivos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:alumnosActivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seleccionar alumnos activos y los agrega a tabla';

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
        $fechaHoy=Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $fechaMesPasado=$fechaHoy->subMonth();
        $fechaMesPasadoStr=$fechaHoy->toDateString();
        
        $mes=Mese::where('id', $fechaMesPasado->month)->value('name');
        //dd($mes);
        $concepto=CajaConcepto::where('name','like',"%".$mes."%")->first();
        //dd($concepto->toArray());
        if($fechaHoy->day==1){
            //dd('fil');
            Cliente::select('p.razon', 'clientes.id', 'clientes.matricula', 'clientes.nombre', 'clientes.nombre2', 
            'clientes.ape_paterno', 'clientes.ape_materno', 'stc.name AS estatus_cliente','sts.name AS estatus_seguimiento', 
            'cc.name AS concepto','clientes.fec_nacimiento','esp.name as especialidad')
            ->join('especialidads as esp','esp.id','=','clientes.especialidad_id')
            ->join('adeudos AS a', 'a.cliente_id','=','clientes.id')
            ->join('seguimientos AS s','s.cliente_id','=','clientes.id')
            ->join('st_seguimientos AS sts','sts.id','=','s.st_seguimiento_id')
            ->join('st_clientes AS stc','stc.id','=','clientes.st_cliente_id')
            ->join('caja_conceptos AS cc','cc.id','=','a.caja_concepto_id')
            ->join('plantels as p','p.id','=','clientes.plantel_id')
            ->where('a.caja_concepto_id',$concepto->id)
            //->whereIn('clientes.plantel_id',$datos['plantel_f'])
            ->where('a.fecha_pago',$fechaMesPasadoStr)
            ->where('clientes.st_cliente_id','<>',3)
            ->where('clientes.st_cliente_id','<>',26)
            ->whereNotNull('clientes.matricula')
            //->where('pagado_bnd',1)
            ->whereNull('a.deleted_at')
            ->whereNull('clientes.deleted_at')
            ->distinct()
            ->chunk(100, function($registros){
                $fechaHoy=Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                foreach($registros as $r){
                    $input['razon']=$r->razon;
                    $input['cliente_id']=$r->id;
                    $input['matricula']=$r->matricula;
                    $input['nombre']=$r->nombre;
                    $input['nombre2']=$r->nombre2;
                    $input['ape_paterno']=$r->ape_paterno;
                    $input['ape_materno']=$r->ape_materno;
                    $input['estatus_cliente']=$r->estatus_cliente;
                    $input['concepto']=$r->concepto;
                    $input['fec_nacimiento']=$r->fec_nacimiento;
                    $input['fec_proceso']=$fechaHoy;
                    $input['especialidad']=$r->especialidad;
                    AlumnosActivo::create($input);
                }
            });
            
            
        }
        
        
    }
}
