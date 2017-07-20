<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aviso;
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
        $mes=date('m');
        //dd($mes);
        $a_1=Seguimiento::where('estatus_id', '=', '1')
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->count();
        $a_2=Seguimiento::where('estatus_id', '=', '2')
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->count();
        $a_3=Seguimiento::where('estatus_id', '=', '3')
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->count();
        $a_4=Seguimiento::where('estatus_id', '=', '4')
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->count();
        
        //dd($grafica);
        return view('home', compact('avisos', 'a_1', 'a_2', 'a_3', 'a_4', 'grafica'));
    }

    public function grfEstatusXEmpleado(){
        $e=Empleado::where('user_id', '=', Auth::user()->id)->first();
        $mes=date('m');
        return $grafica=Seguimiento::select('sts.name as Estatus', DB::raw('count(sts.name) as Valor'))
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('st_seguimientos as sts', 'sts.id','=','seguimientos.estatus_id')
                    ->where(Db::raw('MONTH(seguimientos.created_at)'), '=', $mes)
                    ->where('c.empleado_id', '=', $e->id)
                    ->groupBy('sts.name')
                    ->get()->toJson();
    }
}
