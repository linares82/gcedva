<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aviso;
use App\AvisoGral;
use App\PivotAvisoGralEmpleado;
use App\Seguimiento;
use App\Empleado;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $e=Empleado::where('user_id', '=', Auth::user()->id)->first();
        $avisos=Aviso::select('avisos.id','a.name','avisos.detalle', 'avisos.fecha', 's.cliente_id')
					->join('asuntos as a', 'a.id', '=', 'avisos.asunto_id')
                    ->join('seguimientos as s', 's.id', '=', 'avisos.seguimiento_id')
                    ->join('clientes as c', 'c.id', '=', 's.cliente_id')
					->where('avisos.activo', '=', '1')
                    ->where('avisos.fecha', '=', Db::Raw('CURDATE()'))
                    ->where('c.empleado_id', '=', $e->id)
					->get();
        //dd($avisos);
        $mes=(int)date('m');
        //dd($mes);
        $a_1=Seguimiento::select(Db::raw('count(c.nombre) as total'))
                    ->where('st_seguimiento_id', '=', 1)
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where('mes', '=', $mes)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->where('c.empleado_id', '=', $e->id)
                    ->value('total');
        //dd($a_1);
        $a_2=Seguimiento::where('st_seguimiento_id', '=', 2)
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where('mes', '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->count();
        //dd($e->plantel->meta_venta);
        $avance=(($a_2*100)/$e->plantel->meta_venta);
        //dd($a_3."*100 / ".$e->plantel->meta_venta);
        $a_3=Seguimiento::where('st_seguimiento_id', '=', 3)
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where('mes', '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->count();
        
        $a_4=Seguimiento::where('st_seguimiento_id', '=', 4)
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where('mes', '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->count();
        $fecha=date('Y-m-d');
        $avisos_generales=PivotAvisoGralEmpleado::where('leido','=', 0)
                                    ->where('enviado','=', 1)
                                    ->where('empleado_id', '=', $e->id)
                                    ->get();
        //dd($avisos_generales);
        $encabezado = ['Estatus', 'Cantidad Total', 'Meta'];
        $datos=array();
        array_push($datos,$encabezado);
        $mes=(int)date('m');
        $grafica=Seguimiento::select('sts.name as estatus', DB::raw('count(sts.name) as valor'))
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('st_seguimientos as sts', 'sts.id','=','seguimientos.st_seguimiento_id')
                    ->where('mes', '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->groupBy('sts.name')
                    ->get();

        foreach($grafica as $g){
            if($g->estatus=="Concretado"){
                array_push($datos, array($g->estatus, $g->valor, $e->plantel->meta_venta));
            }else{
                array_push($datos, array($g->estatus, $g->valor, 0));
            }
            
        }
        //dd($datos);
        
        return view('home', compact('avisos', 'a_1', 'a_2', 'a_3', 'a_4', 'grafica', 'avisos_generales', 'avance'))
                    ->with('datos', json_encode($datos)) ;
    }

    public function grfEstatusXEmpleado(){
        $e=Empleado::where('user_id', '=', Auth::user()->id)->first();
        $mes=(int)date('m');
        return $grafica=Seguimiento::select('sts.name as Estatus', DB::raw('count(sts.name) as Valor'))
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('st_seguimientos as sts', 'sts.id','=','seguimientos.st_seguimiento_id')
                    ->where('mes', '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->where('c.plantel_id', '=', $e->plantel_id)
                    ->groupBy('sts.name')
                    ->get()->toJson();
    }
}
