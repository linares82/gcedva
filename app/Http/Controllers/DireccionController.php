<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use App\Cliente;
use App\CombinacionCliente;
use App\AvisosInicio;
use App\Aviso;
use App\Ccuestionario;
use App\CcuestionarioDato;
use App\Seguimiento;
use App\StSeguimiento;
use App\Sm;
use App\Correo;
use App\Empleado;
use App\PreguntaCliente;
use App\Estado;
use App\Municipio;
use App\PivotDocCliente;
use App\Preguntum;
use App\Param;
use App\Lectivo;
use App\Plantilla;
use App\Plantel;
use App\StCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCliente;
use App\Http\Requests\createCliente;
use App\Http\Requests\Carga;
use Sms;
use Session;
use Hash;
use DB;
use Excel;
use Log;
use Storage;
use PDF;

//use App\Mail\CorreoBienvenida as Envia_mail;

class DireccionController extends Controller {
    public function grfr(Request $request) {
        $input = $request->all();
        //dd($input);
        $fecha = date('d-m-Y');
        
        $lectivo=Lectivo::find($input['lectivo']);
        
        $seguimientos = Seguimiento::select('cve_plantel as Plantel', 'esp.name as Especialidad', 'n.name as Nivel', 'g.name as Grado', 
                'seguimientos.mes as Mes', 'm.name as medio','lec.name as lectivo', 
                DB::raw('concat(e.nombre," ", e.ape_paterno," ", e.ape_materno) as Empleado'), 
                'h.detalle as Estatus', 'st.id as st_contar', 'esp.meta as Meta', 'u.name as Usuario')
                ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                ->join('users as u', 'u.id', '=', 'e.user_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->join('especialidads as esp', 'esp.id', '=', 'c.especialidad_id')
                ->join('lectivos as lec', 'lec.id','=', 'esp.lectivo_id')
                ->join('nivels as n', 'n.id', '=', 'c.nivel_id')
                ->join('grados as g', 'g.id', '=', 'c.grado_id')
                ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                ->join('medios as m', 'm.id', '=', 'c.medio_id')
                ->join('hactividades as h','h.cliente_id','=','c.id')
                ->where('h.asunto','=','Cambio estatus ')
                ->where('h.detalle','=','Concretado')
                ->where('h.fecha','<=',$lectivo->inicio)
                ->where('h.fecha','<=',$lectivo->fin)
                ->where('esp.lectivo_id','=',$lectivo->id)
                ->orderBy('p.id')
                ->get();
        
        
        return view('direccion.grfr', array('fecha' => $fecha))
                        ->with('datos', json_encode($seguimientos));

        
    }
}