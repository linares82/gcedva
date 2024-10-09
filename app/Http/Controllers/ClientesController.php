<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use File;
use Excel;
use App\Sm;
use Session;
use Storage;
use App\Caja;
use App\User;
use App\Aviso;
use App\Grado;
use App\Grupo;
use App\Medio;
use App\Nivel;
use App\Paise;
use App\Param;
use App\Adeudo;
use App\Correo;
use App\Estado;
use App\Cliente;
use App\Lectivo;
use App\Plantel;
use App\Empleado;
use App\Materium;
use App\DocAlumno;
use App\Municipio;
use App\Plantilla;
use App\Preguntum;
use App\StCliente;
use Carbon\Carbon;
use App\PlanPagoLn;
use App\TpoInforme;
use App\EstadoCivil;
use App\Inscripcion;
use App\Seguimiento;
use App\AvisosInicio;
use App\CajaConcepto;
use App\Especialidad;
use App\Rules\IsCurp;
use App\AlumnosActivo;
use App\Ccuestionario;
use App\StSeguimiento;
use App\UsuarioCliente;
use Twilio\Rest\Client;
use App\HistoriaCliente;
use App\PivotDocCliente;
use App\PreguntaCliente;
use App\IncidenceCliente;
use App\CcuestionarioDato;
use App\CombinacionCliente;
use App\Helpers\ValidaCurp;
use Illuminate\Support\Str;
use App\Http\Requests\Carga;
use Illuminate\Http\Request;
use App\ConsecutivoMatricula;
use App\ConsultaCalificacion;
use App\ImpresionComprobanteE;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCliente;
use App\Http\Requests\updateCliente;
use Illuminate\Support\Facades\Hash;

class ClientesController extends Controller
{

    private $meta_residuo = 0;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $lectivos_graficas = Lectivo::where('id', '<=', 2)->get();
        $hoy = Carbon::today();
        $fecha_superada = 0;
        foreach ($lectivos_graficas as $lg) {
            $fin = Carbon::createFromFormat('Y-m-d', $lg->fin);
            if ($fin < $hoy) {
                //$fecha_superada = 1;
            }
        }

        $users = User::pluck('name', 'id');
        $users->prepend('Seleccionar opción', 0);
        if (isset($_REQUEST["p"])) {
            if (session()->has('filtro_clientes')) {
                session(['filtro_clientes' => 1]);
            } else {
                session(['filtro_clientes' => 1]);
            }
        } else {
            if (session()->has('filtro_clientes')) {
                session(['filtro_clientes' => 0]);
            } else {
                session(['filtro_clientes' => 0]);
            }
        }

        //dd($request);
        $clientes = Seguimiento::getAllData($request, 10, session('filtro_clientes'));
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $medios= Medio::pluck('name','id');
        $stClientes= StCliente::pluck('name','id');
        $planteles= Plantel::pluck('razon','id');
        /*$especialidades= Especialidad::pluck('name','id');
        $niveles= Nivel::pluck('name','id');
        $grados= Grado::pluck('name','id');*/
        $empleados=Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name','id');
        $tpoInformes=TpoInforme::pluck('name','id');
        $usuarios=User::pluck('name','id');
        $usuarios->prepend('Seleccionar opción', 0);
        

        return view('clientes.index', compact('clientes', 'users', 'empleado', 'fecha_superada','medios','stClientes',
        'planteles','empleados','tpoInformes','usuarios'
        ))
            ->with('list', Seguimiento::getListFromAllRelationApps());
            //->with('list1', Cliente::getListFromAllRelationApps());
    }

    public function indexEventos(Request $request)
    {
        $users = User::pluck('name', 'id');
        $users->prepend('Seleccionar opción', 0);
        //dd($request);
        if (isset($_REQUEST["p"])) {
            if (session()->has('filtro_clientes')) {
                session(['filtro_clientes' => 1]);
            } else {
                session(['filtro_clientes' => 1]);
            }
        } else {
            if (session()->has('filtro_clientes')) {
                session(['filtro_clientes' => 0]);
            } else {
                session(['filtro_clientes' => 0]);
            }
        }

        //dd($request);
        $clientes = Seguimiento::getAllData($request, 10, session('filtro_clientes'));
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

        return view('clientes.indexEventos', compact('clientes', 'users', 'empleado'))
            ->with('list', Seguimiento::getListFromAllRelationApps())
            ->with('list1', Cliente::getListFromAllRelationApps());
    }

    public function busqueda(Request $request)
    {
        $data = $request->all();

        //dd($data);
        $r = Cliente::where('id', '<>', '0');
        if (isset($data['nombre'])) {
            $r->where('nombre', 'like', '%' . $data['nombre'] . '%');
            $nombre = "busqueda realizada";
        }
        if (isset($data['nombre'])) {
            $r->where('nombre', 'like', '%' . $data['nombre'] . '%');
        }
        if (isset($data['nombre2'])) {
            $r->where('nombre2', 'like', '%' . $data['nombre2'] . '%');
        }
        if (isset($data['ape_paterno'])) {
            $r->where('ape_paterno', 'like', '%' . $data['ape_paterno'] . '%');
        }
        if (isset($data['ape_materno'])) {
            $r->where('ape_materno', 'like', '%' . $data['ape_materno'] . '%');
        }
        if (isset($data['tel_fijo'])) {
            $r->where('tel_fijo', 'like', '%' . $data['tel_fijo'] . '%');
        }
        if (isset($data['mail'])) {
            $r->where('mail', 'like', '%' . $data['mail'] . '%');
        }
        if (isset($data['curp'])) {
            $r->where('curp', 'like', '%' . $data['curp'] . '%');
        }
        if (isset($data['calle'])) {
            $r->where('calle', 'like', '%' . $data['calle'] . '%');
        }

        if (
            isset($data['nombre']) or isset($data['nombre2']) or isset($data['ape_paterno']) or isset($data['ape_materno']) or
            isset($data['tel_fijo']) or isset($data['mail']) or isset($data['curp']) or isset($data['calle'])
        ) {
            $clientes = $r->paginate(10);
        } else {
            $clientes = null;
        }

        //dd($clientes);
        return view('clientes.busqueda', compact('clientes'));
    }

    public function index2(Request $request)
    {
        //dd($request);
        $clientes = Cliente::getAllData($request);
        //dd($clientes);
        return view('clientes.index2', compact('clientes'))
            ->with('list', Seguimiento::getListFromAllRelationApps())
            ->with('list1', Cliente::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        //dd(Municipio::get());
        //$p = Auth::user()->can('IfiltroEmpleadosXPlantel');
        //if ($p) {
        
        $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $planteles = array();
        foreach ($e->plantels as $p) {
            //dd($p->id);
            //if($p->st_plantel_id<>1){
            array_push($planteles, $p->id);
            //}
        }
        //dd($planteles);
        $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
            ->whereIn('plantel_id', $planteles)
            //->where('puesto_id', '=', 2)
            ->pluck('name', 'id');
        //dd($empleados);
        /*} else {
        $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
        //->where('puesto_id', '=', 2)
        ->pluck('name', 'id');
        }*/
        $empleados = $empleados->reverse();
        $empleados->put(0, 'Seleccionar Opción');
        $empleados = $empleados->reverse();
        //dd($empleados);
        $estado_civiles = EstadoCivil::pluck('name', 'id');
        $cuestionarios = Ccuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        $incidencias = IncidenceCliente::pluck('name', 'id');
        $plantels = Plantel::where('st_plantel_id', 1)->pluck('razon', 'id');
	$curp_token=Param::where('llave', 'token_curp')->first();
        $curp_url=Param::where('llave', 'url_curp')->first();
        $api_valida_curp=['token'=> $curp_token->valor,
        'url'=>$curp_url->valor];

        return view('clientes.create', compact('empleados', 'cuestionarios', 'estado_civiles', 'incidencias', 'plantels','api_valida_curp'))
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list3', Inscripcion::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCliente $request)
    {
        $id = 0;
        
        $input = $request->all();
        //dd($input);
        //$validaCurp=new ValidaCurp();
        //$validaCurp->validate_curp($input['curp']);
        //dd($validaCurp);
        //$empleado=Empleado::find($request->input('empleado_id'));
        //$input['plantelplantel_id']=$empleado->plantel->id;
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        //$input['especialidad_id'] = 0;
        //$input['nivel_id'] = 0;
        //$input['grado_id'] = 0;
        //$input['turno_id'] = 0;
        $input['st_cliente_id'] = 1;
        $input['especialidad2_id'] = 0;
        $input['diplomado_id'] = 0;
        $input['subdiplomado_id'] = 0;
        $input['turno2_id'] = 0;
        $input['especialidad3_id'] = 0;
        $input['curso_id'] = 0;
        $input['subcurso_id'] = 0;
        $input['turno3_id'] = 0;
        $input['especialidad4_id'] = 0;
        $input['otro_id'] = 0;
        $input['subotro_id'] = 0;
        $input['turno4_id'] = 0;
        //$input['grado_id'] = 0;
        $input['turno_id'] = 0;
        $input['paise_id'] = 22;

        $input['turno_id'] = 0;
        if (is_null($input['ape_materno'])) {
            $input['ape_materno'] = " ";
        }
        if (is_null($input['nombre2'])) {
            $input['nombre2'] = " ";
        }
        if (isset($input['matricula']) and is_null($input['matricula'])) {
            $input['matricula'] = " ";
        }
        $param = Param::where('llave', '=', 'msj_text')->first();
        if ($input['cve_cliente'] == "") {
            //$input['cve_cliente'] = 'Codigo: ' . substr(Hash::make(rand(0, 1000)), 2, 8) . $param->valor;
            $input['cve_cliente'] = $param->valor;
        }
        if (!isset($input['promociones'])) {
            $input['promociones'] = 0;
        } else {
            $input['promociones'] = 1;
        }
        if (!isset($input['promo_cel'])) {
            $input['promo_cel'] = 0;
        } else {
            $input['promo_cel'] = 1;
        }
        if (!isset($input['promo_correo'])) {
            $input['promo_correo'] = 0;
        } else {
            $input['promo_correo'] = 1;
        }
        if (!isset($input['celular_confirmado'])) {
            $input['celular_confirmado'] = 0;
        } else {
            $input['celular_confirmado'] = 1;
        }
        if (!isset($input['bnd_trabaja'])) {
            $input['bnd_trabaja'] = 0;
        } else {
            $input['bnd_trabaja'] = 1;
        }
        if (!isset($input['bnd_indigena'])) {
            $input['bnd_indigena'] = 0;
        } else {
            $input['bnd_indigena'] = 1;
        }
        if (!isset($input['extranjero'])) {
            $input['extranjero'] = 0;
        } else {
            $input['extranjero'] = 1;
        }
        if (!isset($input['bnd_beca'])) {
            $input['bnd_beca'] = 0;
        } else {
            $input['bnd_beca'] = 1;
        }
        if (!isset($input['bnd_regingreso'])) {
            $input['bnd_regingreso'] = 0;
        } else {
            $input['bnd_reingreso'] = 1;
        }
        if(!is_null($input['abreviatura_estado'])){
            $estado= Estado::where('abreviatura', $input['abreviatura_estado'])->first();
            $input['estado_nacimiento_id']=$estado->id;
        }
        //dd($input);
        //create data
        try {
            //dd($input);
            $c = Cliente::create($input);
            $id = $c->id;
            $input_seguimiento['cliente_id'] = $c->id;
            $input_seguimiento['st_seguimiento_id'] = 1;
            $input_seguimiento['mes'] = date('m');
            $input_seguimiento['usu_alta_id'] = Auth::user()->id;
            $input_seguimiento['usu_mod_id'] = Auth::user()->id;
            $s = Seguimiento::create($input_seguimiento);
            $avisos = AvisosInicio::get();
            foreach ($avisos as $a) {
                $aviso = new Aviso;
                $aviso->seguimiento_id = $s->id;
                $aviso->asunto_id = $a->asunto_id;
                $aviso->detalle = $a->detalle;
                $aviso->fecha = date('Y-m-j', strtotime('+' . $a->dias_despues . ' day', strtotime(date('Y-m-j'))));
                $aviso->activo = 1;
                $aviso->usu_alta_id = Auth::user()->id;
                $aviso->usu_mod_id = Auth::user()->id;
                $aviso->save();
            }
        } catch (\PDOException $e) {
            dd($e);
            if ($e->getCode() == 23000) {
                //dd($e);
                return redirect()->route('clientes.edit', $id)->with('message', 'Registro guardado');
            }
        }
        return redirect()->route('clientes.edit', $id)->with('message', 'Registro Creado.')->with('list', Cliente::getListFromAllRelationApps());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Cliente $cliente)
    {
        $cliente = $cliente->find($id);

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Cliente $cliente)
    {
        $cliente = $cliente->with(['ccuestionario'])->find($id);
        //dd($cliente->ccuestionario->ccuestionarioPreguntas);
        $p = Auth::user()->can('IfiltroEmpleadosXPlantel');
        //dd($p);

        if ($p) {
            //$e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            $planteles = array();
            foreach ($e->plantels as $p) {
                //dd($p);
                //if($p->st_plantel_id<>1){
                array_push($planteles, $p->id);
                //}
            }
            //dd($planteles);
            $empleados = Empleado::select('empleados.id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                ->join('puestos as pu', 'pu.id', 'empleados.puesto_id')
                //->where('plantel_id', '=', $e->plantel_id)
                ->whereIn('plantel_id', '=', $planteles)
                ->where('pu.bnd_permitido_clientes', 1)
                //->whereIn('puesto_id', array(1,2,3,4,5,7,8,10,18,19,22,23,31,33,35,46))
                ->pluck('name', 'id');
        } else {
            $empleados = Empleado::select('empleados.id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                ->join('puestos as pu', 'pu.id', 'empleados.puesto_id')
                //->whereIn('puesto_id', array(1,2,3,4,5,7,8,10,18,19,22,23,31,33,35,46))
                ->where('pu.bnd_permitido_clientes', 1)
                ->pluck('name', 'id');
        }
        $empleados = $empleados->reverse();
        $empleados->put(0, 'Seleccionar OpciÃƒÆ’Ã‚Â³n');
        $empleados = $empleados->reverse();
        //dd($empleados);
        $cp = PreguntaCliente::where('cliente_id', '=', $id)->get();
        $preguntas = Preguntum::pluck('name', 'id');
        //dd($cp);
        //dd($preguntas);
        $doc_existentes = DB::table('pivot_doc_clientes as pde')->select('doc_alumno_id')
            ->join('clientes as c', 'c.id', '=', 'pde.cliente_id')
            ->where('c.id', '=', $id)
            ->where('pde.deleted_at', '=', null)->get();

        $de_array = array();
        if ($doc_existentes->isNotEmpty()) {
            foreach ($doc_existentes as $de) {
                array_push($de_array, $de->doc_alumno_id);
            }
            //dd($de_array);
        }

        $documentos_faltantes = DB::table('doc_alumnos')
            ->select()
            ->whereNotIn('id', $de_array)
            ->get();
        //dd($cliente->toArray());
        $cuestionarios = Ccuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');

        //dd($cliente->matricula);
        if (isset($cliente->matricula)) {
            $historia = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")->get();
            //dd($historia);
        } else {
            $historia = collect();
        }

        //dd($historia->toArray());
        //count($cliente->adeudos));
        $estado_civiles = EstadoCivil::pluck('name', 'id');
        $incidencias = IncidenceCliente::pluck('name', 'id');
        $materias = Materium::where('materia.bnd_oficial', 0)
            ->where('plantel_id', $cliente->plantel_id)
            ->pluck('name', 'id');
        $plantels = Plantel::where('st_plantel_id', 1)->pluck('razon', 'id');

        $curp_token=Param::where('llave', 'token_curp')->first();
        $curp_url=Param::where('llave', 'url_curp')->first();
        $api_valida_curp=['token'=> $curp_token->valor,
        'url'=>$curp_url->valor,];

        return view('clientes.edit', compact('api_valida_curp',
            'cliente',
            'materias',
            'preguntas',
            'cp',
            'documentos_faltantes',
            'empleados',
            'cuestionarios',
            'historia',
            'estado_civiles',
            'incidencias',
            'plantels'
        ))
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', PivotDocCliente::getListFromAllRelationApps())
            ->with('list2', CombinacionCliente::getListFromAllRelationApps())
            ->with('list3', Inscripcion::getListFromAllRelationApps());
    }

    public function getReasignar()
    {
        return view('clientes.frm_reasignar')
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list2', Seguimiento::getListFromAllRelationApps());
    }

    public function getCuenta(Request $request)
    {
        //dd($request->input('plantel_id'));
        $plantel = $request->input('plantel_id');
        $empleado = $request->input('empleado_id');
        $estatus = $request->input('st_seguimiento_id');
        $cuenta = Cliente::where('plantel_id', '=', $plantel)
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->where('empleado_id', '=', $empleado)
            ->where('s.st_seguimiento_id', '=', $estatus)
            ->count();

        return $cuenta;
    }

    public function postReasignar(Request $request)
    {
        $input = $request->all();
        //dd($input);
        //do {
        $clis = Cliente::select('clientes.id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->where('clientes.plantel_id', '=', $input['plantel_id'])
            ->where('clientes.empleado_id', '=', $input['empleado_id'])
            ->where('s.st_seguimiento_id', '=', $input['st_seguimiento_id'])
            ->take(50)
            ->get();
        $cantidad = $input['cantidad_afectar'];
        $indicador = 1;
        foreach ($clis as $cli) {
            if ($indicador <= $cantidad) {
                $cliente = Cliente::find($cli->id);
                $cliente->empleado_id = $input['empleado_id2'];
                $cliente->save();
            }
            $indicador++;
        }
        //} while (count($clis) > 0);

        /*->update(['clientes.empleado_id' => $input['empleado_id2'],
        'clientes.updated_at'=>Carbon::now(),
        's.updated_at'=>Carbon::now()]);
         */
        return redirect()->route('clientes.index');
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Cliente $cliente)
    {
        $cliente = $cliente->find($id);
        $preguntas = Preguntum::pluck('name', 'id');
        $cp = PreguntaCliente::where('cliente_id', '=', $id)->get();
        return view('clientes.duplicate', compact('cliente', 'preguntas', 'cp'))
            ->with('list', Cliente::getListFromAllRelationApps())
            ->with('list1', Cliente::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Cliente $cliente, updateCliente $request)
    {
        //dd("fil");
        //$input = $request->all();

        $input = $request->except([
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28',
            '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40',
        ]);
        //dd($input);
        $preguntas = $request->only([
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28',
            '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40',
        ]);
        //dd($preguntas);
        $input['usu_mod_id'] = Auth::user()->id;
        //dd($input);
        if (is_null($input['ape_materno'])) {
            $input['ape_materno'] = " ";
        }
        if (is_null($input['nombre2'])) {
            $input['nombre2'] = " ";
        }

        //$empleado=Empleado::find($request->input('empleado_id'));
        //$input['plantel_id']=$empleado->plantel->id;
        /*
        $pc['cliente_id'] = $id;
        $pc['pregunta_id'] = $input['pregunta_id'];
        $pc['respuesta'] = $input['respuesta'];
        $pc['usu_alta_id'] = Auth::user()->id;
        $pc['usu_mod_id'] = Auth::user()->id;
         */
        //dd($pc);
        unset($input['pregunta_id']);
        unset($input['respuesta']);
        //dd($input);
        if (!isset($input['promociones'])) {
            $input['promociones'] = 0;
        } else {
            $input['promociones'] = 1;
        }
        if (!isset($input['promo_cel'])) {
            $input['promo_cel'] = 0;
        } else {
            $input['promo_cel'] = 1;
        }
        if (!isset($input['promo_correo'])) {
            $input['promo_correo'] = 0;
        } else {
            $input['promo_correo'] = 1;
        }
        if (!isset($input['celular_confirmado'])) {
            $input['celular_confirmado'] = 0;
        } else {
            $input['celular_confirmado'] = 1;
        }
        if (!isset($input['bnd_trabaja'])) {
            $input['bnd_trabaja'] = 0;
        } else {
            $input['bnd_trabaja'] = 1;
        }
        if (!isset($input['bnd_indigena'])) {
            $input['bnd_indigena'] = 0;
        } else {
            $input['bnd_indigena'] = 1;
        }
        if (!isset($input['extranjero'])) {
            $input['extranjero'] = 0;
        } else {
            $input['extranjero'] = 1;
        }
        

        if (!isset($input['bnd_beca'])) {
            $input['bnd_beca'] = 0;
        } else {
            $input['bnd_beca'] = 1;
        }

        if (!isset($input['bnd_regingreso'])) {
            $input['bnd_regingreso'] = 0;
        } else {
            $input['bnd_regingreso'] = 1;
        }

        if(!is_null($input['abreviatura_estado'])){
            $estado= Estado::where('abreviatura', $input['abreviatura_estado'])->first();
            $input['estado_nacimiento_id']=$estado->id;
        }


        //dd($input);
        //update data
        $cliente = $cliente->find($id);
        $cantidad_preguntas = 0;
        if ($cliente->ccuestionario_id > 0) {
            $cantidad_preguntas = $cliente->ccuestionario->ccuestionarioPreguntas->count();
        }

        //dd($input);
        $cliente->update($input);

        $usuarioCliente = UsuarioCliente::where('name', $cliente->matricula)->first();
        if (!is_null($usuarioCliente)) {
            $usuarioCliente->email = $cliente->mail;
            $usuarioCliente->save();
        }


        //dd($request->all());
        if ($request->has('doc_cliente_id') and $request->input('doc_cliente_id') != '0' and $request->has('archivo')) {
            $input2['doc_alumno_id'] = $request->get('doc_cliente_id');
            $input2['archivo'] = $request->get('archivo');
            $input2['cliente_id'] = $id;
            $input2['usu_alta_id'] = Auth::user()->id;
            $input2['usu_mod_id'] = Auth::user()->id;
            PivotDocCliente::create($input2);
        }

        foreach ($preguntas as $llave => $valor) {
            if ($llave != '_token' and !is_null($valor)) {
                //dd($preguntas);
                $dato = CcuestionarioDato::where('cliente_id', '=', $id)
                    ->where('ccuestionario_id', '=', $input['ccuestionario_id'])
                    ->where('ccuestionario_pregunta_id', '=', $llave)
                    ->first();
                //dd($dato);
                if (is_null($dato)) {
                    $r = new CcuestionarioDato;
                    $r->ccuestionario_id = $input['ccuestionario_id'];
                    $r->cliente_id = $id;
                    $r->ccuestionario_id = $input['ccuestionario_id'];
                    $r->ccuestionario_pregunta_id = $llave;
                    $r->ccuestionario_respuesta_id = $valor;
                    $r->name = "";
                    $r->clave = "";
                    $r->usu_alta_id = Auth::user()->id;
                    $r->usu_mod_id = Auth::user()->id;
                    //dd($r->toArray());
                    $r->save();
                } else {
                    $dato->ccuestionario_respuesta_id = $valor;
                    $dato->name = "";
                    $dato->usu_alta_id = Auth::user()->id;
                    $dato->usu_mod_id = Auth::user()->id;
                    //dd($dato);
                    $dato->save();
                }
            }
        }
        $cantidad_respuestas = CcuestionarioDato::where('cliente_id', '=', $id)
            ->where('ccuestionario_id', '=', $input['ccuestionario_id'])
            ->count();
        if ($cantidad_preguntas != $cantidad_respuestas) {
            return redirect()->route('clientes.edit', $id)->with('message', 'Cuestionario incompleto.');
        }

        return redirect()->route('clientes.edit', $id)->with('message', 'Registro Actualizado.');
    }

    public function confirmaCorreo($id, Cliente $cliente, Request $request)
    {
        $cliente = $cliente->find($id);
        $cliente->correo_confirmado = 1;
        $cliente->save();

        //dd('Agradecemos tu tiempo, tu correo fue confirmado.');
        return view('clientes.confirmaCorreo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Cliente $cliente, Seguimiento $s)
    {
        $cliente = $cliente->find($id);
        $cliente->delete();
        $s->where('cliente_id', '=', $id)->delete();

        return redirect()->route('clientes.index')->with('message', 'Registro Borrado.');
    }

    public function autocomplete(Request $request)
    {
        //dd($_REQUEST);
        $data = Cliente::select("expo as descripcion")
            ->where("expo", "LIKE", "%" . $request->input('term') . "%")
            ->get();
        //dd($data);
        $results = array();
        foreach ($data as $value) {
            //dd($value);
            $results[] = ['label' => $value->descripcion];
        }
        return response()->json($results);
    }

    public function carga()
    {
        return view('clientes.carga')
            ->with('list', Empleado::getListFromAllRelationApps());
    }

    public function cargaFile(Carga $request)
    {
        $procesados = 0;
        //Define datos de trabajo
        $p = $request->input('plantel_id');
        $r = $request->hasFile('archivo');
        $total_archivo = $request->input('no_registros');

        //
        $total_empleados = Empleado::where('st_empleado_id', '=', '1')->count();
        $total_asignado = Empleado::where('st_empleado_id', '=', '1')->sum('pendientes');

        $total_meta = $total_asignado + $total_archivo;
        $meta_individual = (($total_meta - ($total_meta % $total_empleados)) / $total_empleados);
        $this->meta_residuo = $total_meta % $total_empleados;

        //dd($r);
        //dd(getdate());

        if ($r) {
            //Carga Archivo
            $archivo = $request->file('archivo');
            $a = $archivo->getClientOriginalName();
            $ruta = public_path() . "/files/carga/" . $p . "/" . date("dmY_his") . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            $request->file('archivo')->move($ruta, $a);

            //Abre Archivo
            $fileD = fopen($ruta . $a, "r");
            $column = fgetcsv($fileD);
            while (!feof($fileD)) {
                $rowData[] = fgetcsv($fileD);
            }

            //dd($rowData);

            foreach ($rowData as $key => $value) {
                try {
                    $linea = explode(';', $value[0]);
                    //dd($linea);
                    $input['nombre'] = $linea[1];
                    $input['mail'] = $linea[2];
                    $input['tel_fijo'] = $linea[3];
                    $input['tel_cel'] = $linea[4];

                    //$empleado=Empleado::find($request->input('empleado_id'));
                    $input['plantel_id'] = $p;
                    $input['usu_alta_id'] = Auth::user()->id;
                    $input['usu_mod_id'] = Auth::user()->id;
                    $input['promociones'] = 0;
                    $input['promo_cel'] = 0;
                    $input['promo_correo'] = 0;
                    $input['municipio_id'] = 0;
                    $input['estado_id'] = 0;
                    $input['st_cliente_id'] = 1;
                    $input['ofertum_id'] = 0;
                    $input['medio_id'] = 0;
                    $input['empleado_id'] = $this->defineEmpleado($meta_individual);
                    $input['nivel_id'] = 0;
                    $input['grado_id'] = 0;
                    $input['curso_id'] = 0;
                    $input['subcurso_id'] = 0;
                    $input['diplomado_id'] = 0;
                    $input['subdiplomado_id'] = 0;
                    $input['otro_id'] = 0;
                    $input['subotro_id'] = 0;

                    if (Cliente::create($input)) {
                        $procesados++;
                    }
                } catch (\Exception $e) {
                }
            }
        }

        //unlink($ruta.$a);

        return view('clientes.carga', compact('procesados'))
            ->with('list', Empleado::getListFromAllRelationApps());
    }

    public function defineEmpleado($meta_individual)
    {
        $empleados = Empleado::select('id', 'pendientes')->where('st_empleado_id', '=', '1')->get();
        foreach ($empleados as $e) {
            $pendientes = Empleado::where('id', '=', $e->id)->value('pendientes');
            if ($pendientes < $meta_individual) {
                return $e->id;
            }
        }
        foreach ($empleados as $e) {
            if ($this->meta_residuo > 0) {
                $this->meta_residuo--;
                return $e->id;
            }
        }
    }

    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    private function sendMessage($message, $telefonos)
    {
        $account_sid = Param::where('llave', '=', 'TWILIO_AUTH_SID')->first();
        $auth_token = Param::where('llave', '=', 'TWILIO_AUTH_TOKEN')->first();
        $twilio_number = Param::where('llave', '=', 'TWILIO_FROM')->first();

        $client = new Client($account_sid->valor, $auth_token->valor);
        $client->messages->create(
            $telefonos,
            ['from' => $twilio_number->valor, 'body' => $message]
        );
    }

    public function enviaSms(Request $request)
    {
        //dd(getenv('DB_CONNECTION'));

        //dd($TWILIO_AUTH_SID->valor);
        if ($request->ajax()) {
            try {
                $pais = Paise::find($request->input('pais_id'));
                //dd($pais);
                if ($pais->marcado != "") {
                    $r = Param::where('llave', '=', 'sms')->first();
                    $no = Param::where('llave', '=', 'num_twilio')->first();

                    $codigo_marcado = $pais->marcado;
                    $to = $codigo_marcado . e($request->input('tel_cel'));
                    //dd($to);
                    $message = e($request->input('cve_cliente'));
                    $from = $no->valor;

                    //dd($r->valor);
                    if ($r->valor == 'activo') {
                        /*if (Sms::send($message, $to, $from)) {
                        $input['usu_envio_id'] = Auth::user()->id;
                        $input['cliente_id'] = e($request->input('id'));
                        $input['cantidad'] = 1;
                        $input['fecha_envio'] = date("Y/m/d");
                        $input['usu_alta_id'] = Auth::user()->id;
                        $input['usu_mod_id'] = Auth::user()->id;
                        Sm::create($input);
                        //dd("msj");
                        $c = Cliente::find($input['cliente_id']);
                        $c->contador_sms = $c->contador_sms + 1;
                        $c->save();
                        }*/

                        //$this->sendMessage($message, $to);
                        if ($this->sendMessage($message, $to)) {
                            $input['usu_envio_id'] = Auth::user()->id;
                            $input['cliente_id'] = e($request->input('id'));
                            $input['cantidad'] = 1;
                            $input['fecha_envio'] = date("Y/m/d");
                            $input['usu_alta_id'] = Auth::user()->id;
                            $input['usu_mod_id'] = Auth::user()->id;
                            Sm::create($input);
                        }
                    }
                }
                return json_encode(true);
            } catch (\Exception $e) {
                dd($e);
                return json_encode(false);
            }
        }
    }

    public function enviaSmsSeguimiento(Request $request)
    {
        //dd($_REQUEST);
        if ($request->ajax()) {
            try {
                $r = Param::where('llave', '=', 'sms')->first();
                $no = Param::where('llave', '=', 'num_twilio')->first();
                $to = '+52' . e($request->input('tel_cel'));
                //dd($to);
                $message = e($request->input('cve_cliente'));
                $from = $no->valor;

                //dd($r->valor);
                if ($r->valor == 'activo') {
                    Sms::send($message, $to, $from);
                }
            } catch (\Exception $e) {
                dd($e);
                //return false;
            }
        }
    }

    /* public function enviaMail(Request $request){
    //dd($_REQUEST);
    if($request->ajax()){
    try{
    $r=Param::where('llave','=', 'correo_electronico')->first();
    if($r->valor=='activo'){
    //dd($r->id);
    //$data=$r->toArray();
    //dd($data);
    \Mail::send('emails.2', array(), function($message) use ($request)
    {
    $message->to(e($request->mail), e($request->nombre)." ".e($request->ape_paterno)." ".e($request->ape_materno));
    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    $message->subject("Bienvenido");
    });

    $cli=Cliente::find(e($request->id));

    $nombre=e($request->nombre)." ".e($request->ape_paterno)." ".e($request->ape_materno);
    $mail=e($request->mail);
    $m=\Mail::to($mail, $nombre);
    $m->queue(new Envia_mail($cli));

    $input2['usu_envio_id']=Auth::user()->id;
    $input2['cliente_id']=e($request->input('id'));
    $input2['fecha_envio']=date("Y/m/d");
    $input2['cantidad']=1;
    $input2['usu_alta_id']=Auth::user()->id;
    $input2['usu_mod_id']=Auth::user()->id;
    //dd("f");
    Correo::create($input2);
    }

    return true;
    }catch(\Exception $e){
    dd($e);
    //return false;
    }

    }
    } */

    public function enviaMail(Request $request)
    {
        //dd($_REQUEST);
        $r = 0;
        $cli = Cliente::find(e($request->id));
        $pla = Plantilla::find(2);
        //dd($pla);
        $p = array();
        $p['img1'] = $pla->img1;
        $p['plantilla'] = $pla->plantilla;
        $p['id'] = $cli->id;
        //dd();

        if ($request->ajax()) {
            try {
                $r = Param::where('llave', '=', 'correo_electronico')->first();
                if ($r->valor == 'activo') {
                    \Mail::send('emails.2', array('img1' => storage_path('app') . "/public/imagenes/plantillas_correos/" . $pla->img1, 'plantilla' => $pla->plantilla, 'id' => $cli->id), function ($message) use ($request) {
                        $message->to(e($request->mail), e($request->nombre) . " " . e($request->ape_paterno) . " " . e($request->ape_materno));
                        $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                        $message->subject("Bienvenido");
                    });

                    $input2['usu_envio_id'] = Auth::user()->id;
                    $input2['cliente_id'] = e($request->input('id'));
                    $input2['fecha_envio'] = date("Y/m/d");
                    $input2['cantidad'] = 1;
                    $input2['usu_alta_id'] = Auth::user()->id;
                    $input2['usu_mod_id'] = Auth::user()->id;
                    Correo::create($input2);

                    $c = Cliente::find($input2['cliente_id']);
                    $c->contador_mail = $c->contador_mail + 1;
                    $c->save();
                }

                //return true;
            } catch (\Exception $e) {
                //dd($e);
                return $e;
            }
        }
    }

    public function cmbMClientes()
    {
        $c = Cliente::select('id', 'nombre', 'nombre2', 'ape_paterno', 'ape_materno', 'mail')->get();
        //return response()->json($c);
        echo json_encode($c);
    }

    public function indexLista()
    {
        return view('clientes.modal_search');
    }

    public function lista(Request $request)
    {
        //dd(Session::get('cliente_field'));
        Session::put('cliente_search', $request->has('ok') ? $request->input('search') : (Session::has('cliente_search') ? Session::get('cliente_search') : ''));
        Session::put('nombre2_search', $request->has('ok') ? $request->input('search2') : (Session::has('nombre2_search') ? Session::get('nombre2_search') : ''));
        Session::put('ape_paterno_search', $request->has('ok') ? $request->input('search3') : (Session::has('ape_paterno_search') ? Session::get('ape_paterno_search') : ''));
        Session::put('ape_materno_search', $request->has('ok') ? $request->input('search4') : (Session::has('ape_materno_search') ? Session::get('ape_materno_search') : ''));
        //Session::put('cliente_field', $request->has('field') ? $request->input('field') : (Session::has('cliente_field') ? Session::get('cliente_field') : 'nombre'));
        //Session::put('cliente_sort', $request->has('sort') ? $request->input('sort') : (Session::has('cliente_sort') ? Session::get('cliente_sort') : 'asc'));
        $clientes = Cliente::where('nombre', 'like', '%' . Session::get('cliente_search') . '%')
            ->where('nombre2', 'like', '%' . Session::get('nombre2_search') . '%')
            ->where('ape_paterno', 'like', '%' . Session::get('ape_paterno_search') . '%')
            ->where('ape_materno', 'like', '%' . Session::get('ape_materno_search') . '%')
            ->paginate(8);
        //->orderBy(Session::get('cliente_field'), Session::get('cliente_sort'))->paginate(8);

        return view('clientes.modal_list', ['clientes' => $clientes]);
    }

    public function getCmbAlumno(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grado = $request->get('grado_id');
            $grupo = $request->get('grupo_id');
            //dd($request->all());
            $cliente = $request->get('cliente_id');
            $final = array();
            $r = DB::table('inscripcions as i')
                ->select('c.id', DB::raw('concat(c.nombre," ",c.ape_paterno," ",c.ape_paterno) as name'))
                ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                ->where('i.plantel_id', '=', $plantel)
                ->where('i.especialidad_id', '=', $especialidad)
                ->where('i.nivel_id', '=', $nivel)
                ->where('i.grado_id', '=', $grado)
                ->where('i.grupo_id', '=', $grupo)
                ->where('i.id', '>', '0')
                ->get();
            //dd($r);
            if (isset($cliente) and $cliente != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $cliente) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getNombreCliente(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $cliente = $request->get('cliente_id');

            $r = DB::table('clientes as c')
                ->select('c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno')
                ->where('c.id', '=', $cliente)
                ->first();
            //dd($r);
            echo json_encode($r);
        }
    }

    public function descargaClientes()
    {

        $clientes = Cliente::select('clientes.fec_registro as FechaRegistro', 'clientes.nombre as PrimerNombre', 'clientes.nombre2 as SegundoNombre', 'clientes.ape_paterno as ApellidoPaterno', 'clientes.ape_materno as ApellidoMaterno', 'clientes.tel_fijo as Telefono', 'clientes.tel_cel as Celular', 'clientes.mail as Email', 'clientes.escuela_procedencia as EscuelaProcedencia', 'm.name as medio as Medio', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as Asesor'))
            ->join('medios as m', 'm.id', '=', 'clientes.medio_id')
            ->join('empleados as e', 'e.id', '=', 'clientes.empleado_id')
            //->limit(20)
            ->get();
        //dd($clientes);
        /* $clientes_array=array();
        $encabezados=array('Fecha', 'P. Nombre', 'S. Nombre', 'A. Paterno', 'A. Materno', 'TelÃƒÆ’Ã‚Â©fono',
        'Celular', 'Mail', 'Escuela Procedencia', 'Medio');
        array_push($clientes_array, $encabezados);
        //dd($clientes_array);

        foreach($clientes as $c){
        //$clientes_array=$c->toArray();
        array_push($clientes_array, $c);
        }
        dd($clientes_array);
         *
         */
        //dd("excel inicia");
        Excel::create('Clientes', function ($excel) use ($clientes) {
            $excel->sheet('Clientes', function ($sheet) use ($clientes) {
                $sheet->fromArray($clientes->toArray());
            });
        })->download('xlsx');
        dd("excel terminado");
    }

    public function indexReportes()
    {
        return view('clientes.reportes.indice');
    }

    public function reportesCcxep()
    {
        return view('clientes.reportes.ccxep')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesCcxepR(Request $request)
    {
        $filtros = $request->all();
        //$sts=StCliente::get();
        //foreach($sts as $st){
        if ($filtros['tipo'] == 1) {
            $clientes = Cliente::select('p.razon', 'clientes.nombre', 'm.name as municipio', 'st.name as estatus', DB::raw('YEAR(s.created_at) as anio'), 's.mes')
                ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                ->join('municipios as m', 'm.id', '=', 'clientes.municipio_id')
                ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                ->where('clientes.plantel_id', '=', $filtros['plantel_f'])
                //->where('clientes.plantel_id','<=', $filtros['plantel_t'])
                ->where('clientes.created_at', '>=', $filtros['fecha_f'])
                ->where('clientes.created_at', '<=', $filtros['fecha_t'])
                ->where('clientes.municipio_id', '>', 0)
                ->get();
            return view('clientes.reportes.ccxep_r')
                ->with('datos_grafica', json_encode($clientes->toArray()));
        } elseif ($filtros['tipo'] == 2) {
            $plantel = Plantel::find($filtros['plantel_f']);
            $p = $plantel->razon;
            $st = StSeguimiento::where('id', '>', 0)->get();
            $municipios = Municipio::select('municipios.id', 'municipios.name as municipio')
                ->join('clientes as c', 'c.municipio_id', '=', 'municipios.id')
                ->where('c.plantel_id', '=', $filtros['plantel_f'])
                ->where('c.created_at', '>=', $filtros['fecha_f'])
                ->where('c.created_at', '<=', $filtros['fecha_t'])
                ->where('c.municipio_id', '>', 0)
                ->distinct()
                ->get();
            //dd($municipios->toArray());
            $tabla = array();
            $e = array();
            array_push($e, "Municipio");
            foreach ($st as $s) {
                array_push($e, $s->name);
            }
            array_push($tabla, $e);
            foreach ($municipios as $m) {
                $ln = array();
                array_push($ln, $m->municipio);
                foreach ($st as $s) {
                    $clientes = Cliente::select(DB::raw('count(st.name) as total'))
                        ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                        ->join('municipios as m', 'm.id', '=', 'clientes.municipio_id')
                        ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                        ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                        ->where('clientes.plantel_id', '=', $filtros['plantel_f'])
                        ->where('clientes.created_at', '>=', $filtros['fecha_f'])
                        ->where('clientes.created_at', '<=', $filtros['fecha_t'])
                        ->where('s.st_seguimiento_id', '=', $s->id)
                        ->where('clientes.municipio_id', '=', $m->id)
                        //->groupBy('s.created_at')
                        //->groupBy('s.mes')
                        ->value('total');
                    array_push($ln, $clientes);
                }
                array_push($tabla, $ln);
            }

            //dd($tabla);
            //$graficas=$clientes->toArray();
            return view('clientes.reportes.ccxep_g', compact('tabla', 'p'))
                ->with('datos_grafica', json_encode($tabla));
        }
    }

    public function reportesEcap()
    {
        return view('clientes.reportes.ecap')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesEcapR(Request $request)
    {
        $filtros = $request->all();
        $f = date("Y-m-d");
        $l = Lectivo::find(0)->first();
        $tabla = array();
        $encabezado = array();
        $encabezado[0] = 'Empleado';
        if (!isset($filtros['plantel_f'])) {
            $filtros['plantel_f'] = Auth::user()->plantel_id;
        }
        $estatus = StSeguimiento::where('id', '>', 0)->get();
        $empleados = Empleado::where('plantel_id', '=', $filtros['plantel_f'])
            ->where('puesto_id', '=', 2)->get();

        //dd($empleados->toArray());
        $i = 1;
        foreach ($estatus as $st) {
            if ($st->id > 0) {
                $encabezado[$i] = $st->name;
                $i++;
            }
        }
        array_push($tabla, $encabezado);
        //dd($encabezado);
        foreach ($empleados as $e) {
            $linea = array();
            $i = 0;
            $linea[$i] = $e->nombre . " " . $e->ape_paterno . " " . $e->ape_materno;
            foreach ($estatus as $st) {
                $i++;
                if ($st->id == 2) {
                    $valor = Seguimiento::select(DB::raw('count(st.name) as total'))
                        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                        ->where('st_seguimiento_id', '=', $st->id)
                        ->where('e.id', '=', $e->id)
                        ->where('c.plantel_id', '=', $filtros['plantel_f'])
                        ->where('seguimientos.created_at', '>=', $l->inicio)
                        ->where('seguimientos.created_at', '<=', $l->fin)
                        ->value('total');
                } elseif ($st->id > 0) {
                    $valor = Seguimiento::select(DB::raw('count(st.name) as total'))
                        ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                        ->where('st_seguimiento_id', '<>', $st->id)
                        ->where('e.id', '=', $e->id)
                        ->where('c.plantel_id', '=', $filtros['plantel_f'])
                        ->value('total');
                }
                $linea[$i] = $valor;
            }
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $p = Plantel::find($filtros['plantel_f']);
        $plantel = $p->razon;
        //dd($plantel);

        return view('clientes.reportes.ecap_r', compact('tabla', 'plantel'))
            ->with('datos_grafica', json_encode($tabla));
    }

    public function cuentaEstatusClientes()
    {
        $resultado = Cliente::select(DB::raw('count(st.name) as total, concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado, p.razon,st.name'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('empleados as e', 'e.id', '=', 'clientes.empleado_id')
            ->orderBy('p.razon')
            ->orderBy('empleado')
            ->orderBy('st.name')
            ->groupBy('p.razon')
            ->groupBy('empleado')
            ->groupBy('st.name')
            ->get();
        //dd($resultado);
        return view('clientes.reportes.cuentaEstatusClientes', compact('resultado'));
        /*PDF::setOptions(['defaultFont' => 'arial']);
    $pdf = PDF::loadView('clientes.reportes.cuentaEstatusClientes', array('resultado' => $resultado))
    ->setPaper('letter', 'portrait');
    return $pdf->download('reporte.pdf');
     */
    }

    public function reportesEppa()
    {
        return view('clientes.reportes.eppa')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesEppaR(Request $request)
    {
        $filtros = $request->all();
        $f = date("Y-m-d");

        $tabla = array();
        $encabezado = array();
        $encabezado[0] = 'Empleado';
        if (!isset($filtros['plantel_f'])) {
            $filtros['plantel_f'] = Auth::user()->plantel_id;
        }
        $estatus = StSeguimiento::where('id', '>', 0)->get();
        $empleados = Empleado::where('plantel_id', '=', $filtros['plantel_f'])
            ->where('puesto_id', '=', 2)
            ->where('st_empleado_id', '<>', 3)
            ->get();

        //dd($empleados->toArray());
        $i = 1;
        $lectivosSt2 = Lectivo::where('grafica_bnd', '=', '1')->get();
        foreach ($estatus as $st) {
            if ($st->id == 2) {
                foreach ($lectivosSt2 as $lSt2) {
                    $encabezado[$i] = $lSt2->name;
                    $i++;
                }
            } elseif ($st->id > 0) {
                $encabezado[$i] = $st->name;
                $i++;
            }
        }
        array_push($tabla, $encabezado);
        //dd($encabezado);
        foreach ($empleados as $e) {
            $linea = array();
            $i = 0;
            $linea[$i] = $e->nombre . " " . $e->ape_paterno . " " . $e->ape_materno;
            //$i++;

            foreach ($estatus as $st) {
                $i++;

                if ($st->id == 2) {

                    $a_2 = array();
                    $avance = array();
                    //$i=0;
                    $j = 0;
                    foreach ($lectivosSt2 as $lSt2) {
                        $valor = Seguimiento::join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('hactividades as h', 'h.cliente_id', '=', 'c.id')
                            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
                            ->where('esp.lectivo_id', '=', $lSt2->id)
                            //->where('seguimientos.created_at', '>=', $l->inicio)
                            //->where('seguimientos.created_at', '<=', $l->fin)
                            ->where('c.empleado_id', '=', $e->id)
                            //->where('c.plantel_id', '=', $e->plantel_id)
                            ->where('h.fecha', '>=', $lSt2->inicio)
                            ->where('h.fecha', '<=', $lSt2->fin)
                            ->where('h.detalle', '=', 'Concretado')
                            ->where('h.asunto', '=', 'Cambio estatus ')
                            ->count();
                        //Log::info("st:".$st->id."-i-".$i."-".$valor);
                        $linea[$i] = $valor;
                        $j++;
                        if ($j < 2) {
                            $i++;
                        }

                        /*
                    array_push($a_2, array($a, $lSt2->name));
                    $avance[$i]=0;
                    if($a>0){
                    $avance[$i]=(($a*100)/$e->plantel->meta_total);
                    }
                    $i++;*/
                    }
                    /*$lectivosSt2=Lectivo::where('grafica_bnd','=','1')->get();
                $valor=Seguimiento::select(DB::raw('count(st.name) as total'))
                ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                ->join('combinacion_clientes as cc', 'cc.cliente_id','=','c.id')
                ->join('especialidads as esp', 'esp.id','=','cc.especialidad_id')
                ->join('hactividades as h', 'h.cliente_id','=','c.id')
                ->where('esp.lectivo_id', '=', $lSt2->id)
                ->where('st_seguimiento_id', '=', $st->id)
                ->where('e.id', '=', $e->id)
                ->where('c.plantel_id', '=', $filtros['plantel_f'])
                ->where('h.fecha', '>=', $filtros['fecha_f'])
                ->where('h.fecha', '<=', $filtros['fecha_t'])
                ->where('h.asunto','=','Cambio estatus ')
                ->where('h.detalle', '=','Concretado')
                //->where('seguimientos.created_at', '>=', $l->inicio)
                //->where('seguimientos.created_at', '<=', $l->fin)
                ->value('total');
                 *
                 */
                } elseif ($st->id > 0) {

                    $valor = Seguimiento::where('st_seguimiento_id', '=', $st->id)
                        ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                        //->where('mes', '=', $mes)
                        ->where('c.empleado_id', '=', $e->id)
                        //->where('c.plantel_id', '=', $e->plantel_id)
                        ->count();
                    //Log::info("st:".$st->id."-i-".$i."-".$valor);
                    /*Seguimiento::select(DB::raw('count(st.name) as total'))
                    ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                    ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                    ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                    ->where('st_seguimiento_id', '<>', $st->id)
                    ->where('e.id', '=', $e->id)
                    ->where('c.plantel_id', '=', $filtros['plantel_f'])
                    ->value('total');
                     *
                     */
                    $linea[$i] = $valor;
                }
            }
            //dd($linea);
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $p = Plantel::find($filtros['plantel_f']);
        $plantel = $p->razon;
        //dd($plantel);

        return view('clientes.reportes.eppa_r', compact('tabla', 'plantel'))
            ->with('datos_grafica', json_encode($tabla));
    }

    public function rpt_sms_mail()
    {
        return view('clientes.reportes.sms_mail')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function rpt_sms_mailr(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $registros = Cliente::select(
            'clientes.id',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'p.razon as plantel',
            DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'),
            'clientes.tel_cel',
            DB::raw('if(clientes.celular_confirmado=1,"SI","NO") as celular_confirmado'),
            'clientes.mail',
            DB::raw('if(clientes.correo_confirmado=1,"SI","NO") as correo_confirmado')
        )
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('empleados as e', 'e.id', '=', 'clientes.empleado_id')
            ->whereBetween('clientes.plantel_id', [$data['plantel_f'], $data['plantel_t']])
            ->whereDate('clientes.created_at', '>', date_format(date_create($data['fecha_f']), 'Y/m/d H:i:s'))
            ->whereDate('clientes.created_at', '<', date_format(date_create($data['fecha_t']), 'Y/m/d H:i:s'))
            ->get();
        //dd($registros->toArray());
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($registros, [
            'id' => 'ID', 'nombre' => 'PRIMER NOMBRE',
            'nombre2' => 'SEGUNDO NOMBRE',
            'ape_paterno' => 'A. PATERNO',
            'ape_materno' => 'A. MATERNO',
            'plantel' => 'PLANTEL',
            'empleado' => 'EMPLEADO',
            'tel_cel' => 'CELULAR',
            'celular_confirmado' => 'CELULAR CONFIRMADO',
            'mail' => 'MAIL',
            'correo_confirmado' => 'CORREO CONFIRMADO',
        ])->download();
    }

    //Funciones para la API
    public function findBy(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $clientes = Cliente::where($datos['campo'], '=', $datos['valor'])->get();
        return response()->json($clientes);
    }

    public function altasXUsuario()
    {

        return view('clientes.reportes.altasXUsuario')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function altasXUsuarioR(Request $request)
    {
        $filtros = $request->all();

        $resultados = Cliente::select(DB::raw('p.razon, e.id, count(clientes.nombre) as total_usuario'))
            ->join('users as u', 'u.id', '=', 'clientes.usu_alta_id')
            ->join('empleados as e', 'e.user_id', '=', 'u.id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->where('clientes.plantel_id', '>=', $filtros['plantel_f'])
            ->where('clientes.plantel_id', '<=', $filtros['plantel_t'])
            ->where('clientes.usu_alta_id', '>=', $filtros['usuario_f'])
            ->where('clientes.usu_alta_id', '<=', $filtros['usuario_t'])
            ->where('clientes.created_at', '>=', $filtros['fecha_f'] . " 00:00:00")
            ->where('clientes.created_at', '<=', $filtros['fecha_t'] . " 23:00:00")
            ->groupBy('p.razon', 'e.id')
            ->get();
        //dd($resultados->toArray());

        return view('clientes.reportes.altasXUsuarioR', compact('resultados', 'filtros'));
    }

    public function Boleta(Request $request)
    {

        $cliente = Cliente::find($request['id']);
        return view('clientes.reportes.boleta', compact('cliente'))
            ->with('');
    }

    public function cargarImg(Request $request)
    {

        $r = $request->hasFile('file');
        $datos = $request->all();
        //dd($request->all());
        if ($r) {
            $logo_file = $request->file('file');
            $input['file'] = $logo_file->getClientOriginalName();
            $ruta_web = asset("/imagenes/clientes/" . $datos['cliente']);
            //dd($ruta_web);
            $ruta = public_path() . "/imagenes/clientes/" . $datos['cliente'] . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            if ($request->file('file')->move($ruta, $input['file'])) {
                $documento = PivotDocCliente::find($datos['documento']);
                $documento->cliente_id = $datos['cliente'];
                $documento->doc_alumno_id = $datos['doc_cliente_id'];
                $documento->archivo = $ruta_web . "/" . $input['file'];
                //$documento->usu_alta_id = Auth::user()->id;
                $documento->usu_mod_id = Auth::user()->id;
                $documento->save();

                $this->docObligatoriosEntregados($documento->cliente_id);

                echo json_encode($ruta_web . "/" . $input['file']);
            } else {
                echo json_encode(0);
            }
        }
        //echo json_encode(0);
    }

    public function docObligatoriosEntregados($cliente_id)
    {
        $cliente = Cliente::find($cliente_id);
        $documentos = PivotDocCliente::join('doc_alumnos as da', 'da.id', 'pivot_doc_clientes.doc_alumno_id')
            ->where('cliente_id', $cliente_id)->where('doc_obligatorio', 1)->get();
        $total_doc_obligatorios = DocAlumno::select('doc_obligatorio')->where('doc_obligatorio', 1)->count();
        //dd($documentos);
        $documentos_total = 0;
        $documentos_entregados = 0;
        foreach ($documentos as $documento) {
            if (!is_null($documento->archivo)) {
                $documentos_entregados++;
            }
        }
        //dd($total_doc_obligatorios."-".$documentos_total);
        if ($total_doc_obligatorios == $documentos_total) {
            $cliente->bnd_doc_oblig_entregados = 1;
            $cliente->save();
        } else {
            $cliente->bnd_doc_oblig_entregados = 0;
            $cliente->save();
        }
    }

    public function credencialAnverso(Request $request)
    {
        $datos = $request->all();
        $cliente = Cliente::find($datos['id']);
        $combinacion = CombinacionCliente::where('cliente_id', $cliente->id)->first();
        $grado = $combinacion->grado;
        $plantel = Plantel::find($cliente->plantel_id);
        $inscripcion = Inscripcion::find($datos['inscripcion']);
        $id_foto_doc_alumnos = Param::where('llave', 'id_foto_doc_alumos')->first();
        if (!is_null($id_foto_doc_alumnos)) {
            $img = PivotDocCliente::where('cliente_id', $datos['id'])->where('doc_alumno_id', $id_foto_doc_alumnos->valor)->first();

            $cadena_img = "";
            if (is_null($img)) {
                dd('sin foto cargada');
            } else {
                $cadena_img = explode('/', $img->archivo);
            }
            //dd($cadena_img);
            //dd($cadena_img[count($cadena_img) - 1]);
            //dd(base_path() . '/vendor/cossou/jasperphp/examples/' . $cadena_img[count($cadena_img) - 1]);
            return view('clientes.reportes.credencial_anverso', compact('cliente', 'inscripcion', 'cadena_img', 'plantel', 'grado'));
        } else {
            dd("Sin id de foto identificado, informar al administrador");
        }


        /* PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('clientes.reportes.credencial_anverso', array('cliente' => $cliente,
        'inscripcion'=>$inscripcion,
        'img'=>$img))
        ->setPaper('letter', 'portrait');
        return $pdf->download('reporte.pdf');
         */
        /*
    // Crear el objeto JasperPHP
    $jasper = new JasperPHP;

    // Generar el Reporte
    $jasper->process(
    // Ruta y nombre de archivo de entrada del reporte
    base_path() . '/vendor/cossou/jasperphp/examples/credencial.jasper',
    false, // Ruta y nombre de archivo de salida del reporte (sin extensiÃƒÆ’Ã‚Â³n)
    array('pdf'), // Formatos de salida del reporte
    array('cliente' => $cliente->id,
    'inscripcion' => $inscripcion->id,
    'imagen' => base_path() . '/vendor/cossou/jasperphp/examples/'. $cadena_img[count($cadena_img) - 1]), // ParÃƒÆ’Ã‚Â¡metros del reporte
    array(
    'driver' => 'mysql',
    'username' => 'root',
    'host' => 'localhost',
    'database' => 'crmscool_jesadi',
    'port' => '3306')
    )->execute();
     */
    }

    public function credencialReverso(Request $request)
    {
        $datos = $request->all();
        $cliente = Cliente::find($datos['id']);
        $inscripcion = Inscripcion::find($datos['inscripcion']);
        return view('clientes.reportes.credencial_reverso', compact('cliente', 'inscripcion'))
            ->with('');
    }

    public function clientesEstatus()
    {

        return view('clientes.reportes.clientesEstatus')
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function clientesEstatusR(Request $request)
    {
        $datos = $request->all();

        //        $clientes=Cliente::select('clientes.id as cliente','clientes.nombre','clientes.nombre2','clientes.ape_paterno','clientes.ape_materno',
        //                                  'p.razon','stc.name as estatus')
        //                        ->join('plantes as p','p.id','=','clientes.plantel_id')
        //                        ->join('st_clientes as stc','stc.id','=','clientes.st_cliente_id')
        //                        ->where('stc.id','>=',$datos['estatus_f'])
        //                        ->where('stc.id','<=',$datos['estatus_t'])
        //                        ->get();
        $historia_clientes = HistoriaCliente::select(
            'c.id as cliente',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'historia_clientes.descripcion',
            'c.ape_materno',
            'p.razon',
            'stc.name as estatus',
            'historia_clientes.fecha',
            'c.tel_cel',
            'reactivado',
            'fec_reactivado',
            'g.name as grado'
        )
            ->join('clientes as c', 'c.id', '=', 'historia_clientes.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->whereDate('historia_clientes.fecha', '>=', $datos['fecha_f'])
            ->whereDate('historia_clientes.fecha', '<=', $datos['fecha_t'])
            ->where('evento_cliente_id', 2)
            ->whereIn('p.id', $datos['plantel_f'])
            ->whereNull('historia_clientes.deleted_at')
            ->whereNull('cc.deleted_at')
            //->where('p.id', '<=', $datos['plantel_t'])
            ->orderBy('p.id')
            ->orderBy('c.id')
            ->get();

        return view('clientes.reportes.clientesEstatusR', array(
            'registros' => $historia_clientes,
            'datos' => $datos,
        ))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function listaDocumentos()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        return view('clientes.reportes.listaDocumentos', compact('planteles'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function listaDocumentosR(Request $request)
    {
        $datos = $request->all();
        $documentos_obligatorios = DocAlumno::where('doc_obligatorio', 1)->get();
        $clientes = Cliente::select(
            'clientes.id',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'stc.name as estatus',
            'clientes.matricula',
            'clientes.bnd_doc_oblig_entregados'
        )
            ->where('clientes.plantel_id', $datos['plantel_f'])
            //->where('matricula', '0923CB06011')
            ->whereNotNull('clientes.matricula')
            ->where('clientes.matricula', '<>', " ")
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            //->where('st_cliente_id', $datos['estatus_f'])
            ->get();
        //dd($clientes->toArray());
        $documentos_faltantes = array();

        foreach ($clientes as $cliente) {
            $docsPorCliente = PivotDocCliente::where('cliente_id', $cliente->id)
                ->join('doc_alumnos as da', 'da.id', 'pivot_doc_clientes.doc_alumno_id')
                ->where('da.doc_obligatorio', 1)
                ->select('doc_alumno_id', 'da.name', 'doc_entregado', 'archivo')
                //->whereNull('archivo')
                //->where('doc_entregado', '<>', 1)
                ->get();
            //dd($docsPorCliente->toArray());
            if (!is_null($docsPorCliente)) {
                $array_docsPorCliente = array();
                $i = 0;
                foreach ($docsPorCliente as $do) {
                    //dd($do);
                    $array_docsPorCliente[$i] = $do->doc_alumno_id;
                    $i++;
                }
                //dd($array_docsPorCliente);
                if (substr($cliente->matricula, 0, 4) == $datos['inicio_matricula']) {
                    //dd($array_docsPorCliente);
                    foreach ($docsPorCliente as $do) {

                        //if (!in_array($do->id, $array_docsPorCliente)) {
                        //dd($do);
                        array_push($documentos_faltantes, array(
                            'cliente' => $cliente->id,
                            'nombre' => $cliente->nombre . ' ' . $cliente->nombre2 . ' ' . $cliente->ape_paterno . ' ' . $cliente->ape_materno,
                            'matricula' => $cliente->matricula,
                            'bnd_doc_oblig_entregados' => $cliente->bnd_doc_oblig_entregados,
                            'documento' => $do->name,
                            'estatus' => $cliente->estatus,
                            'obligatorio_entregado' => $do->doc_entregado == 1 ? "Si" : "No"
                        ));
                        //}
                    }
                }
            }
        }
        //dd($documentos_faltantes);
        //dd($documentos_faltantes);
        return view('clientes.reportes.listaDocumentosR', compact('documentos_faltantes'));
    }

    public function matrizDocumentos()
    {
        return view('clientes.reportes.matrizDocumentos')
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function matrizDocumentosR(Request $request)
    {
        $datos = $request->all();
        $documentos_obligatorios = DocAlumno::where('doc_obligatorio', 1)->get();
        $clientes = Cliente::select(
            'clientes.id',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'stc.name as estatus'
        )
            ->where('clientes.plantel_id', $datos['plantel_f'])
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->where('st_cliente_id', $datos['estatus_f'])
            ->get();
        $documentos_faltantes = array();
        $enc = array();

        array_push($enc, 'Cliente');
        array_push($enc, 'Nombre');
        array_push($enc, 'Estatus');

        foreach ($documentos_obligatorios as $do) {
            array_push($enc, $do->id);
        }

        //array_push($documentos_faltantes, $enc);

        foreach ($clientes as $cliente) {
            $registro['cliente'] = $cliente->id;
            $registro['nombre'] = $cliente->nombre . ' ' . $cliente->nombre2 . ' ' . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
            $registro['estatus'] = $cliente->estatus;
            foreach ($documentos_obligatorios as $do) {
                $doc = PivotDocCliente::where('cliente_id', $cliente->id)
                    ->where('doc_alumno_id', $do->id)
                    ->select('doc_alumno_id')->first();
                if (!is_null($doc)) {
                    $registro[$do->id + 100] = 'X';
                } else {
                    $registro[$do->id + 100] = '';
                }
            }
            array_push($documentos_faltantes, $registro);
        }

        return view('clientes.reportes.matrizDocumentosR', compact('documentos_faltantes', 'documentos_obligatorios'));
    }

    public function listaCredenciales()
    {
        $lectivos = Lectivo::pluck('name', 'id');
        return view('clientes.reportes.listaCredenciales', compact('lectivos'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function listaCredencialesR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Cliente::select(
            'i.matricula',
            'clientes.id as cliente',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_materno',
            'clientes.ape_paterno',
            'clientes.nombre_padre',
            'clientes.tel_padre',
            'clientes.cel_padre',
            'clientes.nombre_madre',
            'clientes.tel_madre',
            'clientes.cel_madre',
            'clientes.nombre_acudiente',
            'clientes.tel_acudiente',
            'clientes.cel_acudiente',
            'p.razon',
            'p.calle',
            'p.no_int',
            'p.colonia',
            'p.municipio',
            'p.estado',
            'p.cp',
            'p.id as plantel',
            'p.img_firma',
            'd.nombre as dnombre',
            'd.ape_materno as dape_materno',
            'd.ape_paterno as dape_paterno',
            'e.rvoe',
            'e.ccte',
            'e.fondo_credencial'
        )
            ->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
            ->join('plantels as p', 'p.id', '=', 'i.plantel_id')
            ->join('empleados as d', 'd.id', '=', 'p.director_id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->where('i.plantel_id', '=', $datos['plantel_f'])
            ->where('i.especialidad_id', '=', $datos['especialidad_id'])
            ->where('i.lectivo_id', '=', $datos['lectivo'])
            ->where('clientes.st_cliente_id', '=', $datos['estatus_f'])
            ->whereNull('i.deleted_at')
            ->get();
        //dd($registros->toArray());
        $especialidad = Especialidad::find($datos['especialidad_id']);

        //dd($cadena_img);
        //dd($cadena_img[count($cadena_img) - 1]);
        //dd(base_path() . '/vendor/cossou/jasperphp/examples/' . $cadena_img[count($cadena_img) - 1]);
        return view('clientes.reportes.listaCredencialesR', compact('registros', 'especialidad', 'datos'));
    }

    public function listaClientes()
    {
        $grupos = Grupo::pluck('name', 'id');
        $lectivos = Lectivo::pluck('name', 'id');
        return view('clientes.reportes.listaClientes', compact('grupos', 'lectivos'))->with('list', Cliente::getListFromAllRelationApps());
    }

    public function listaClientesR(Request $request)
    {
        $datos = $request->all();
        $registros = Cliente::select(
            'clientes.id',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'clientes.matricula',
            'clientes.genero',
            'clientes.fec_nacimiento',
            'clientes.mail',
            'clientes.tel_fijo',
            'clientes.tel_cel',
            'clientes.nombre_padre',
            'clientes.tel_padre',
            'clientes.dir_padre',
            'clientes.st_cliente_id',
            'clientes.curp',
            'clientes.mail_madre',
            'clientes.tel_madre',
            'clientes.dir_madre',
            'clientes.nombre_acudiente',
            'clientes.tel_acudiente',
            'clientes.dir_acudiente'
        )
            ->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
            ->where('clientes.plantel_id', $datos['plantel_f'])
            ->where('i.lectivo_id', $datos['lectivo_f'])
            ->where('i.grupo_id', $datos['grupo_f'])
            ->orderBy('i.lectivo_id')
            ->orderBy('i.grupo_id')
            ->get();
        //dd($registros);
        return view('clientes.reportes.listaClientesR', compact('registros'));
    }

    public function apiStore(Request $request)
    {
        //dd($request->all());
        $id = 0;
        $input = $request->all();
        //dd($input);
        $empleado = Empleado::where('mail_empresa', $input['mail_empleado_asignado'])->first();
        if (is_null($empleado)) {
            return response()->json(['msj' => $input['mail_empleado_asignado'] . ' No existe asignado a ningun empleado ']);
        }
        //dd($empleado);
        //$empleado=Empleado::find($request->input('empleado_id'));
        //$input['plantelplantel_id']=$empleado->plantel->id;
        $input['usu_alta_id'] = 1;
        $input['usu_mod_id'] = 1;
        $input['paise_id'] = 22;
        $input['st_cliente_id'] = 1;
        $input['ofertum_id'] = 0;
        $input['empleado_id'] = $empleado->id;
        //$input['especialidad_id'] = 0;
        //$input['nivel_id'] = 0;
        //$input['grado_id'] = 0;
        //$input['turno_id'] = 0;
        //$input['st_cliente_id']=1;
        $input['especialidad2_id'] = 0;
        $input['diplomado_id'] = 0;
        $input['subdiplomado_id'] = 0;
        $input['turno2_id'] = 0;
        $input['especialidad3_id'] = 0;
        $input['curso_id'] = 0;
        $input['subcurso_id'] = 0;
        $input['turno3_id'] = 0;
        $input['especialidad4_id'] = 0;
        $input['otro_id'] = 0;
        $input['subotro_id'] = 0;
        $input['turno4_id'] = 0;
        //$input['grado_id'] = 0;
        $input['turno_id'] = 0;
        $input['paise_id'] = 22;

        $input['turno_id'] = 0;
        //dd($input);
        if (is_null($input['ape_materno'])) {
            $input['ape_materno'] = " ";
        }
        if (is_null($input['nombre2'])) {
            $input['nombre2'] = " ";
        }

        if (!isset($input['matricula'])) {
            $input['matricula'] = " ";
        }

        $param = Param::where('llave', '=', 'msj_text')->first();
        if (!isset($input['cve_cliente'])) {
            //$input['cve_cliente'] = 'Codigo: ' . substr(Hash::make(rand(0, 1000)), 2, 8) . $param->valor;
            $input['cve_cliente'] = $param->valor;
        }

        if (!isset($input['promociones'])) {
            $input['promociones'] = 0;
        } else {
            $input['promociones'] = 1;
        }
        if (!isset($input['promo_cel'])) {
            $input['promo_cel'] = 0;
        } else {
            $input['promo_cel'] = 1;
        }
        if (!isset($input['promo_correo'])) {
            $input['promo_correo'] = 0;
        } else {
            $input['promo_correo'] = 1;
        }
        if (!isset($input['celular_confirmado'])) {
            $input['celular_confirmado'] = 0;
        } else {
            $input['celular_confirmado'] = 1;
        }
        if (!isset($input['extranjero'])) {
            $input['extranjero'] = 0;
        } else {
            $input['extranjero'] = 1;
        }
        if (!isset($input['bnd_beca'])) {
            $input['bnd_beca'] = 0;
        } else {
            $input['bnd_beca'] = 1;
        }
        if (!isset($input['bnd_regingreso'])) {
            $input['bnd_regingreso'] = 0;
        } else {
            $input['bnd_reingreso'] = 1;
        }
        if (!isset($input['pagador_id'])) {
            $input['pagador_id'] = 0;
        } else {
            $input['pagador_id'] = 1;
        }
        if (!isset($input['uso_factura_id'])) {
            $input['uso_factura_id'] = 21;
        } else {
            $input['uso_factura_id'] = 21;
        }

        //dd($input);
        //create data
        try {
            //dd($input);
            $c = Cliente::create($input);
            $id = $c->id;
            $input_seguimiento['cliente_id'] = $c->id;
            $input_seguimiento['st_seguimiento_id'] = 1;
            $input_seguimiento['mes'] = date('m');
            $input_seguimiento['usu_alta_id'] = 1;
            $input_seguimiento['usu_mod_id'] = 1;
            $s = Seguimiento::create($input_seguimiento);
            $avisos = AvisosInicio::get();
            foreach ($avisos as $a) {
                $aviso = new Aviso;
                $aviso->seguimiento_id = $s->id;
                $aviso->asunto_id = $a->asunto_id;
                $aviso->detalle = $a->detalle;
                $aviso->fecha = date('Y-m-j', strtotime('+' . $a->dias_despues . ' day', strtotime(date('Y-m-j'))));
                $aviso->activo = 1;
                $aviso->usu_alta_id = 1;
                $aviso->usu_mod_id = 1;
                $aviso->save();
            }
        } catch (\PDOException $e) {
            //dd($e);
            return response()->json(['msj' => 'Fallo, exception: ' . $e->getMessage()]);
        }
        //dd($c);
        return response()->json(['id_cliente' => $c->id]);
    }

    public function activos()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels()->pluck('razon', 'id');
        return view('clientes.reportes.activos', compact('planteles'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function activosR(Request $request)
    {
        $datos = $request->all();
        $registros = Cliente::select(
            'clientes.id',
            'clientes.matricula',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'e.name as especialidad',
            'pe.name as periodo_estudio',
            'cc.name as concepto',
            'a.monto'
        )
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('periodo_estudios as pe', 'pe.id', '=', 'i.periodo_estudio_id')
            ->where('a.fecha_pago', '>=', $datos['fecha_f'])
            ->where('a.fecha_pago', '<=', $datos['fecha_t'])
            ->where('clientes.plantel_id', $datos['plantel_f'])
            ->where('a.pagado_bnd', 0)
            ->whereNull('i.deleted_at')
            ->whereNull('a.deleted_at')
            //->whereNull('ln.deleted_at')
            ->orderBy('especialidad')
            ->orderBy('periodo_estudio')
            ->orderBy('clientes.ape_paterno')
            ->orderBy('clientes.ape_materno')
            ->orderBy('clientes.nombre')
            ->orderBy('clientes.nombre2')
            ->get();

        $plantel = Plantel::find($datos['plantel_f']);
        //dd($registros->toArray());
        return view('clientes.reportes.activosR', compact('registros', 'plantel', 'datos'));
    }

    public function formatoInscripcion(Request $request)
    {
        $datos = $request->all();
        $cliente = Cliente::find($datos['cliente_id']);
        $combinacion = CombinacionCliente::where('cliente_id', $cliente->id)->first();
        $lista_documentos = DocAlumno::get();
        $documentos_entregados = PivotDocCliente::where('cliente_id', $cliente->id)
            ->where('doc_entregado', 1)
            ->wherenull('deleted_at')->get();

        $lista_mostrar = array();
        //dd($documentos_entregados->toArray());
        foreach ($lista_documentos as $ld) {
            $item['documento'] = $ld->name;
            $item['obligatorio'] = ($ld->doc_obligatorio == 1 ? "SI" : "NO");
            foreach ($documentos_entregados as $de) {
                if ($de->doc_alumno_id == $ld->id) {
                    $item['archivo'] = $de->archivo;
                    $item['doc_entregado'] = $de->doc_entregado;
                }
            }
            array_push($lista_mostrar, $item);
            $item['archivo'] = null;
            $item['doc_entregado'] = 0;
        }

        //dd($lista_mostrar);

        return view('clientes.reportes.formatoInscripcion', compact('cliente', 'combinacion', 'lista_mostrar'));
    }

    public function alumnosConceptoPlaneado()
    {
        $conceptos = CajaConcepto::pluck('name', 'id');
        $e = Empleado::where('user_id', Auth::user()->id)->first();
        $plantels = array();
        foreach ($e->plantels as $p) {
            array_push($plantels, $p->id);
        }
        $planteles = Plantel::whereIn('id', $plantels)->pluck('razon', 'id');
        return view('clientes.reportes.alumnosConceptoPlaneado', compact('conceptos', 'planteles'));
    }

    public function alumnosConceptoPlaneadoR(Request $request)
    {
        $datos = $request->all();
        $registros = Cliente::select(
            'p.razon',
            'clientes.id',
            'clientes.matricula',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'stc.name AS estatus_cliente',
            'sts.name AS estatus_seguimiento',
            'cc.name AS concepto',
            'clientes.fec_nacimiento',
            'esp.name as especialidad',
            'clientes.curp',
            'clientes.genero',
            'muni.name as municipio'
        ) //curp, sexo
            ->join('municipios as muni', 'muni.id', 'clientes.municipio_id')
            ->join('especialidads as esp', 'esp.id', '=', 'clientes.especialidad_id')
            ->join('adeudos AS a', 'a.cliente_id', '=', 'clientes.id')
            ->join('seguimientos AS s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos AS sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('st_clientes AS stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('caja_conceptos AS cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->where('a.caja_concepto_id', $datos['concepto_f'])
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('a.fecha_pago', $datos['fecha_f'])
            ->where('clientes.st_cliente_id', '<>', 3)
            //->where('pagado_bnd',1)
            ->whereNull('a.deleted_at')
            ->whereNull('clientes.deleted_at')
            ->get();
        //dd($registros);
        return view('clientes.reportes.alumnosConceptoPlaneadoR', compact('registros'));
    }

    public function concretados()
    {
        $e = Empleado::where('user_id', Auth::user()->id)->first();
        $plantels = array();
        foreach ($e->plantels as $p) {
            array_push($plantels, $p->id);
        }
        $planteles = Plantel::whereIn('id', $plantels)->pluck('razon', 'id');
        return view('clientes.reportes.concretados', compact('planteles'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function concretadosR(Request $request)
    {
        $datos = $request->all();
        $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
        if ($param->valor <> 0) {
            $datos['inicio_matricula'] = $param->valor . $datos['inicio_matricula'];
        }
        $planteles = Plantel::select('plantels.id', 'plantels.meta_total')->whereIn('plantels.id', $datos['plantel_f'])->get();
        $totales = Cliente::select('p.razon', 'g.seccion', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            ->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();

        $totales2 = Cliente::select('p.razon', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->whereIn('a.caja_concepto_id', array(1, 22,23, 25))// se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            //->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();
        //dd($totales->toArray());

        $detalle = Cliente::select(
            'p.razon',
            'clientes.matricula',
            'clientes.id as cliente_id',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.bnd_reclasificado',
            'clientes.tel_fijo',
            'clientes.tel_cel',
            'stc.name as st_cliente',
            'sts.name as st_seguimiento',
            'g.seccion',
            DB::raw('concat(emp.nombre, " ",emp.ape_paterno, " ",emp.ape_materno) as empleado_nombre'),
            //'cc.name as concepto',
            //'a.caja_concepto_id',
            //'c.fecha as fecha_caja',
            'clientes.bnd_doc_oblig_entregados',
            'tu.name as turno'
        )
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            //->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            //->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('empleados as emp', 'emp.id', '=', 'clientes.empleado_id')
            //->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('turnos as tu', 'tu.id', 'ccli.turno_id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            //->where('a.pagado_bnd', 1)
            //->where('c.st_caja_id', 1)
            //->where('clientes.id', 88063)
            //->whereIn('a.caja_concepto_id', array(1,22,23, 25)) // se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            //->whereNull('a.deleted_at')
            //->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            //->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->orderBy('p.razon')
            ->orderBy('g.seccion')
            ->get();
        //dd($detalle->toArray());
        $registros = array();
        foreach ($detalle->toArray() as $d) {
            //dd($d['cliente_id']);
            $adeudos12325 = Adeudo::where('cliente_id', $d['cliente_id'])
                ->where('pagado_bnd', 1)
                ->whereIn('caja_concepto_id', array(1, 23, 25))->get();
            $d['12325'] = "";
            $d['fecha_caja_12325'] = "";
            foreach ($adeudos12325 as $adeudo) {
                $d['12325'] = $adeudo->cajaConcepto->name;
                $d['fecha_caja_12325'] = $adeudo->caja->fecha;
                break;
            }

            if ($d['bnd_doc_oblig_entregados'] == 1) {
                $d['bnd_doc_oblig_entregados'] = 'Si';
            } else {
                $d['bnd_doc_oblig_entregados'] = 'No';
            }
            $tramites = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cln.caja_concepto_id', 22)
                ->where('cliente_id', $d['cliente_id'])
                ->first();

            if (is_null($tramites)) {
                $d['tramites'] = "No";
                $d['tramites_fecha'] = "";
            } else {
                //dd($tramites->toArray());    
                $d['tramites'] = "Si";
                $d['tramites_fecha'] = $tramites->fecha_caja;
            }
            $primera_mensualidad = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->where('cliente_id', $d['cliente_id'])
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cc.bnd_mensualidad', 1)
                ->first();
            if (is_null($primera_mensualidad)) {
                $d['primera_mensualidad'] = "No";
                $d['primera_mensualidad_fecha'] = "";
                //dd($primera_mensualidad);
            } else {
                $d['primera_mensualidad'] = "Si";
                $d['primera_mensualidad_fecha'] = $primera_mensualidad->fecha_caja;
            }
            //dd($d);
            array_push($registros, $d);
        }
        //dd($registros);

        /*
        $totales=Cliente::select(DB::raw('p.id, p.razon, p.meta_total, count(clientes.matricula) as total_matriculas'))
        ->join('adeudos as a','a.cliente_id','=','clientes.id')
        ->join('caja_conceptos as cc','cc.id','=','a.caja_concepto_id')
        ->join('plantels as p','p.id','=','clientes.plantel_id')
        ->join('st_clientes as stc','stc.id','=','clientes.st_cliente_id')
        ->join('cajas as c','c.id','=','a.caja_id')
        ->where('a.pagado_bnd',1)
        ->where('c.st_caja_id',1)
        ->whereIn('a.caja_concepto_id',array(1, 25))
        ->where('clientes.st_cliente_id','<>',3)
        ->whereIn('clientes.plantel_id',$datos['plantel_f'])
        ->where('clientes.matricula','like',$datos['inicio_matricula']."%")
        ->whereNull('a.deleted_at')
        ->whereNull('c.deleted_at')
        ->orderBy('p.razon')
        ->groupBy('p.id')
        ->groupBy('p.razon')
        ->groupBy('p.meta_total')
        ->get();
        */
        //dd($totales->toArray());
        $totales_seccion = array();
        $seccion = "";
        $contador_seccion = 0;

        $plantel = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_estatus = 0;
        $totales_plantel_estatus = array();
        //dd();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            $contador_seccion++;
            $contador_plantel_estatus++;
            $plantel = $r['razon'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_estatus,
            array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
        );
        //dd($totales_plantel_estatus);


        $plantel = "";
        $seccion = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_seccion_estatus = 0;
        $totales_plantel_seccion_estatus = array();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($seccion != $r['seccion'] and $seccion != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            $contador_plantel_seccion_estatus++;
            $plantel = $r['razon'];
            $seccion = $r['seccion'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_seccion_estatus,
            array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
        );
        //dd($totales_plantel_seccion_estatus);
        return view('clientes.reportes.concretadosR', compact('registros', 'totales_plantel_estatus', 'totales_plantel_seccion_estatus'));
    }

    public function generarMatricula(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $adeudos = Adeudo::select('adeudos.*')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            //->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('clientes as cli', 'cli.id', '=', 'adeudos.cliente_id')
            //->whereIn('cc.id', array(1, 22, 23, 24, 25))
            //->where('pagado_bnd', 1)->where('fecha_pago', '>=', '2020-09-01')
            ->where('cli.id', $datos['cliente'])
            ->whereNull('adeudos.deleted_at')
            //->where('cli.matricula', '')
            //->take(5)
            ->get();
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {
            if (is_null($adeudo->cliente->matricula) or $adeudo->cliente->matricula == " " or $adeudo->cliente->matricula == "") {
                //Genera la matricula para un cliente si no la tiene.
                //Datos para matricula
                $cajaLn = $adeudo->caja->cajaLns->first();
                //dd($cajaLn->toArray());
                $combinacion = CombinacionCliente::where('cliente_id', $adeudo->cliente_id)
                    ->where('plantel_id', '<>', 0)
                    ->where('especialidad_id', '<>', 0)
                    ->where('nivel_id', '<>', 0)
                    ->where('grado_id', '<>', 0)
                    ->where('turno_id', '<>', 0)
                    ->where('plan_pago_id', '<>', 0)
                    ->whereNull('deleted_at')
                    ->first();
                //dd($combinacion->toArray());
                $marcador = 0;
                if (is_null($combinacion)) {
                    Log::info('cliente:' . $adeudo->cliente_id . "Sin combinacion");
                    $marcador = 1;
                }
                //dd($combinacion);
                $planPagoLn = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->orderBy('fecha_pago', 'asc')->first();
                if (is_null($planPagoLn)) {
                    Log::info('cliente:' . $adeudo->cliente_id . "Sin plan de pago");
                    $marcador = 1;
                } else {
                    //$adeudos = Adeudo::where('combinacion_cliente_id', $combinacion->id)->where('caja_concepto_id', 1)->first();
                    //dd($adeudos);
                    //$inscripcionConcepto = $adeudos->where('caja_concepto_id', 1);
                    //$lectivo = Lectivo::find($combinacion->lectivo_id);
                    //dd($planPagoLn);
                    $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();

                    $fecha = Carbon::createFromFormat('Y-m-d', $planPagoLn->fecha_pago);
                    $grado = Grado::find($combinacion->grado_id);
                    //Log::info("grado: " . $grado->id);
                    //dd($grado);
                    $relleno = "000000";
                    $rellenoPlantel = "00";
                    $rellenoConsecutivo = "000";

                    //dd($consecutivo);
                    $cliente = Cliente::where('id', $adeudo->cliente_id)->first();
                    //dd(($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " "));
                }

                if (($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " ") and $marcador == 0) {
                    //dd('entra');
                    $consecutivo = ConsecutivoMatricula::where('plantel_id', $combinacion->plantel_id)
                        ->where('anio', $fecha->year)
                        ->where('mes', $fecha->month)
                        ->where('seccion', $grado->seccion)
                        ->first();

                    if (is_null($consecutivo)) {
                        $consecutivo = ConsecutivoMatricula::create(array(
                            'plantel_id' => $combinacion->plantel_id,
                            'mes' => $fecha->month,
                            'anio' => $fecha->year,
                            'seccion' => $grado->seccion,
                            'consecutivo' => 1,
                            'usu_alta_id' => 1,
                            'usu_mod_id' => 1,
                        ));
                    } else {
                        $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                        $consecutivo->save();
                    }
                    $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
                    $anio = $fecha->year - 2000;
                    $plantel = substr($rellenoPlantel, 0, 2 - strlen($combinacion->plantel_id)) . $combinacion->plantel_id;
                    $seccion = $grado->seccion;
                    $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;


                    if ($param->valor <> "0") {
                        $entrada['matricula'] = $param->valor . $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    } else {
                        $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    }
                    //dd($entrada);
                    //$i->update($entrada);

                    //dd($entrada['matricula']);
                    $cliente->matricula = $entrada['matricula'];
                    $cliente->save();
                    Log::info('matricula cliente -' . $cliente->id . "-" . $cliente->matricula);

                    if (!is_null($cliente->matricula)) {
                        $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->first();
                        /*
                        $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();
                        if(!is_null($buscarMail)){
                            $buscarMail->delete();
                        }*/
                        if (is_null($buscarMatricula) /*and is_null($buscarMail)*/) {
                            $usuario_cliente['name'] = $cliente->matricula;
                            if (is_null($cliente->mail) or $cliente->mail == "") {
                                $usuario_cliente['email'] = "Sin correo";
                            } else {
                                $usuario_cliente['email'] = $cliente->mail;
                            }
                            $usuario_cliente['password'] = Hash::make('123456');
                            UsuarioCliente::create($usuario_cliente);
                        }
                    }
                } else {
                    if (is_null($grado->seccion)) {
                        Log::info("seccion vacia:" . $grado->seccion . " del grado con id " . $grado->id);
                    }
                }
            }
        }
        return redirect()->route('clientes.edit', $datos['cliente']);
    }

    public function generarUsuarioPortal(Request $request)
    {
        $datos = $request->all();
        $cliente = Cliente::find($datos['cliente']);
        if (!is_null($cliente->matricula)) {
            $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->first();
            /*
            $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();
            if(!is_null($buscarMail)){
                $buscarMail->delete();
            }*/
            if (is_null($buscarMatricula)/* and is_null($buscarMail)*/) {
                $usuario_cliente['name'] = $cliente->matricula;
                if (is_null($cliente->mail) or $cliente->mail == "") {
                    $usuario_cliente['email'] = "Sin correo";
                } else {
                    $usuario_cliente['email'] = $cliente->mail;
                }
                $usuario_cliente['password'] = Hash::make('123456');
                $usuario = UsuarioCliente::create($usuario_cliente);
            } else {
                return redirect()->route('usuarioClientes.edit', $buscarMatricula->id);
            }
        }
        return redirect()->route('usuarioClientes.edit', $usuario->id);
    }

    public function alumnosActivos()
    {
        return view('clientes.reportes.alumnosActivos');
    }

    public function alumnosActivosR(Request $request)
    {
        $data = $request->all();
        $registros = AlumnosActivo::select(DB::raw('fec_proceso, razon, count(cliente_id) as alumnos_activos'))
            ->where('fec_proceso', $data['fecha_f'])
            ->groupBy('fec_proceso')
            ->groupBy('razon')
            //->groupBy('estatus_cliente')
            ->get();
        //dd($registros->toArray());
        return view('clientes.reportes.alumnosActivosR', compact('registros'));
    }

    public function alumnosActivosD(Request $request)
    {
        $data = $request->all();
        $registros = AlumnosActivo::select('razon', 'cliente_id', 'nombre', 'nombre2', 'ape_paterno', 'ape_materno', 'estatus_cliente')
            ->where('fec_proceso', $data['fecha_f'])
            ->where('razon', $data['razon'])
            ->orderBy('ape_paterno')
            ->orderBy('ape_materno')
            ->orderBy('nombre')
            ->orderBy('nombre2')
            ->get();
        return view('clientes.reportes.alumnosActivosD', compact('registros'));
    }

    public function plantelXCliente(Request $request)
    {
        if ($request->ajax()) {
            $datos = $request->all();
            $cliente = Cliente::find($datos['cliente']);
            return json_encode(array('plantel' => $cliente->plantel_id));
        }
    }

    public function comprobanteEstudios()
    {
        return view('clientes.reportes.comprobateEstudios');
    }

    public function comprobanteEstudiosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $cliente = Cliente::find($datos['cliente']);
        $inscripcion = Inscripcion::where('cliente_id', $cliente->id)->whereNull('deleted_at')->first();
        $input['inscripcion_id'] = $inscripcion->id;
        $input['cliente_id'] = $inscripcion->cliente_id;
        $input['plantel_id'] = $inscripcion->plantel_id;
        $input['especialidad_id'] = $inscripcion->especialidad_id;
        $input['nivel_id'] = $inscripcion->nivel_id;
        $input['grado_id'] = $inscripcion->grado_id;
        $input['grupo_id'] = $inscripcion->grupo_id;
        $input['inscripcion_id'] = $inscripcion->id;
        $input['turno_id'] = $inscripcion->turno_id;
        $input['lectivo_id'] = $inscripcion->lectivo_id;
        $input['periodo_estudio_id'] = $inscripcion->periodo_estudio_id;
        $input['token'] = uniqid(base64_encode(Str::random(6)));
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $token = ImpresionComprobanteE::create($input);
        $foto_aux = $cliente->pivotDocCliente->where('doc_alumno_id', 11)->first();
        if (!is_null($foto_aux)) {
            $foto = end(explode('/', $foto_aux->archivo));
        } else {
            $foto = "Sin foto";
        }

        //dd($foto);

        return view('clientes.reportes.comprobateEstudiosR', compact('cliente', 'inscripcion', 'token', 'foto'));
    }

    public function recuperacion(Request $request)
    {
        $filtros = $request->all();
        //dd($filtros);
        $filtrado = Cliente::query();
        $filtrado->whereIn('st_cliente_id', array(3, 15, 26, 27, 28));
        if (isset($filtros['q'])) {
            if ($filtros['q']['clientes.id_lt'] <> null) {
                $filtrado->where('id', $filtros['q']['clientes.id_lt']);
            }
            if ($filtros['q']['clientes.nombre_cont'] <> null) {
                $filtrado->where('nombre', $filtros['q']['clientes.nombre_cont']);
            }
            if ($filtros['q']['clientes.nombre2_cont'] <> null) {
                $filtrado->where('nombre2', $filtros['q']['clientes.nombre2_cont']);
            }
            if ($filtros['q']['clientes.ape_paterno_cont'] <> null) {
                $filtrado->where('ape_paterno', $filtros['q']['clientes.ape_paterno_cont']);
            }
            if ($filtros['q']['clientes.ape_materno_cont'] <> null) {
                $filtrado->where('ape_materno', $filtros['q']['clientes.ape_materno_cont']);
            }
            if ($filtros['q']['clientes.st_cliente_id_lt'] <> 0) {
                $filtrado->where('st_cliente_id', $filtros['q']['clientes.st_cliente_id_lt']);
            }
            if ($filtros['q']['clientes.plantel_id_lt'] <> 0) {
                $filtrado->where('plantel_id', $filtros['q']['clientes.plantel_id_lt']);
            }
            if ($filtros['q']['clientes_updated_at_mayorq'] <> null) {
                $filtrado->where('updated_at', '>', $filtros['q']['clientes_updated_at_mayorq']);
            }
        }
        $clientes = $filtrado->orderBy('id', 'desc')->paginate(20);

        $users = User::pluck('name', 'id');
        $users->prepend('Seleccionar opciÃƒÂ³n', 0);

        //dd($request);
        //$clientes = Seguimiento::getAllData($request, 10, session('filtro_clientes'));
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();


        return view('clientes.recuperacion', compact('clientes', 'empleado', 'users'))
            ->with('list', Seguimiento::getListFromAllRelationApps())
            ->with('list1', Cliente::getListFromAllRelationApps());
    }

    public function documentosRecibidos()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        //$stClientes=StCliente::pluck('name','id');
        $stSeguimientos = StSeguimiento::pluck('name', 'id');
        return view('clientes.reportes.documentosRecibidos', compact('planteles', 'stSeguimientos'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function documentosRecibidosR(Request $request)
    {
        $datos = $request->all();

        //dd($datos);
        $documentos_recibidos = array();
        $documentos_obligatorios = DocAlumno::where('doc_obligatorio', 1)->get();
        $clientes = Cliente::select(
            'clientes.id',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'clientes.bnd_doc_oblig_entregados as doc_recibidos',
            'stc.name as estatus_cliente',
            'sts.name as estatus_seguimiento',
            'p.razon as plantel',
            'clientes.matricula'
        )
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('plantels as p', 'p.id', 'clientes.plantel_id')
            ->whereNotNull('clientes.matricula')
            ->where('clientes.matricula', '<>', " ")
            //->join('pivot_doc_clientes as pdc','pdc.cliente_id','c.id')
            //->join('doc_alumnos as da','da.id','pdc.doc_alumno_id')
            //->where('st_cliente_id', $datos['estatus_f'])
            //->where('st_seguimiento_id', $datos['estatus_seguimiento_f'])
            ->where('clientes.plantel_id', $datos['plantel_f'])
            //->whereRaw('clientes.matricula like "?%"', [$datos['inicio_matricula']])
            /*->when($datos['estatus_seguimiento_f']>0, function ($q, $estatus_seguimiento_f){
                $q->where('s.st_seguimiento_id', $estatus_seguimiento_f);
            })
            ->when($datos['estatus_f']>0, function ($q, $estatus_f){
                $q->where('cliente.st_cliente_id', $estatus_f);
            })
            /*->when($datos['inicio_matricula'], function($q, $inicio_matricula){
                $q->whereRaw('clientes.matricula like "?%"', [$inicio_matricula]);
            })*/
            //->where('da.doc_obligatorio',1)
            ->groupBy(
                'clientes.id',
                'clientes.nombre',
                'clientes.nombre2',
                'clientes.ape_paterno',
                'clientes.ape_materno',
                'estatus_cliente',
                'estatus_seguimiento'
            )
            ->get();
        //dd($clientes);

        //$filtrados=$clientes->where('matricula', 'like', $datos['inicio_matricula']."%" );
        //dd($filtrados);
        $total_documentos = array();

        foreach ($clientes as $cliente) {
            //dd(substr($cliente->matricula, 0, 4)."--".$datos['inicio_matricula']);
            if (substr($cliente->matricula, 0, 4) == $datos['inicio_matricula']) {
                $docsPorCliente = PivotDocCliente::select('da.*')
                    ->join('doc_alumnos as da', 'da.id', 'pivot_doc_clientes.doc_alumno_id')
                    ->where('cliente_id', $cliente->id)
                    ->whereNull('pivot_doc_clientes.deleted_at')
                    ->whereNotNull('pivot_doc_clientes.archivo')
                    ->where('doc_obligatorio', 1)
                    ->get();
                $totalDocsPorCliente = PivotDocCliente::select('doc_alumno_id')
                    ->join('doc_alumnos as da', 'da.id', 'pivot_doc_clientes.doc_alumno_id')
                    ->whereNull('pivot_doc_clientes.deleted_at')
                    ->whereNotNull('pivot_doc_clientes.archivo')
                    ->where('cliente_id', $cliente->id)
                    ->where('doc_obligatorio', 1)
                    ->count();
                if ($totalDocsPorCliente == 0) {
                    array_push($documentos_recibidos, array(
                        'cliente' => $cliente->id,
                        'matricula' => $cliente->matricula,
                        'nombre' => $cliente->nombre . ' ' . $cliente->nombre2 . ' ' . $cliente->ape_paterno . ' ' . $cliente->ape_materno,
                        'total_documentos' => 0,
                        'documentos' => array(),
                        'estatus_cliente' => $cliente->estatus_cliente,
                        'estatus_seguimiento' => $cliente->estatus_seguimiento,
                        'plantel' => $cliente->plantel,
                        'doc_recibidos' => $cliente->doc_recibidos
                    ));
                } else {
                    array_push($documentos_recibidos, array(
                        'cliente' => $cliente->id,
                        'matricula' => $cliente->matricula,
                        'nombre' => $cliente->nombre . ' ' . $cliente->nombre2 . ' ' . $cliente->ape_paterno . ' ' . $cliente->ape_materno,
                        'total_documentos' => $totalDocsPorCliente,
                        'documentos' => $docsPorCliente->toArray(),
                        'estatus_cliente' => $cliente->estatus_cliente,
                        'estatus_seguimiento' => $cliente->estatus_seguimiento,
                        'plantel' => $cliente->plantel,
                        'doc_recibidos' => $cliente->doc_recibidos
                    ));
                }
            }
        }
        //dd($documentos_recibidos);
        //dd($documentos_faltantes);
        //return view('clientes.reportes.listaDocumentosR', compact('documentos_faltantes'));
        return view('clientes.reportes.documentosRecibidosR', compact('documentos_recibidos'));
    }

    public function docRecibidosManual(Request $request)
    {
        $datos = $request->all();
        //dd($datos['clientes']);
        foreach ($datos['clientes'] as $cliente) {

            $clienteR = Cliente::find($cliente);
            //dd($clienteR);
            $clienteR->bnd_doc_oblig_entregados = 1;
            $clienteR->save();
        }
        return redirect()->route('clientes.documentosRecibidos');
    }

    public function validaEntregaDocs3Meses($cliente)
    {
        //Log::info($cliente);
        //return true;
        $cliente = Cliente::find($cliente);

        $dentro3Meses = false;

        if (!is_null($cliente->matricula) or $cliente->matricula <> "") {
            $diaActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->day;
            $mesActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->month;
            $anioActual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->year;

            $mesMatricula = intval(substr($cliente->matricula, 0, 2));
            $anioMatricula = intval("20" . substr($cliente->matricula, 2, 2));

            

            if (
                $anioActual == $anioMatricula and
                $mesActual <= $mesMatricula
            ) {

                $dentro3Meses = true;
            } elseif (
                $anioActual == $anioMatricula and
                $mesActual > $mesMatricula and
                ($mesActual - $mesMatricula) <= 6
            ) {

                $dentro3Meses = true;
            } elseif (
                $anioActual > $anioMatricula and
                $mesActual < $mesMatricula and $mesActual <= 6 and
                ($anioActual - $anioMatricula) == 1 and
                ($mesActual - $mesMatricula) * -1 >= 6
            ) {
                //dd("a_actual:".$anioActual."-a_matricula:".$anioMatricula."-m_actual:".$mesActual."-m_matricula".$mesMatricula);
                $dentro3Meses = true;
            } elseif (
                $anioActual > $anioMatricula and
                $mesActual > $mesMatricula and
                ($anioActual - $anioMatricula) == 1 and
                ($mesActual - $mesMatricula) >= 6
            ) {
                $dentro3Meses = true;
            }elseif (
                $anioActual > $anioMatricula and
                $mesActual > $mesMatricula and
                ($anioActual - $anioMatricula) == 1 and
                ($mesActual - $mesMatricula) == 7
            ) {
                if($diaActual>=1 and $diaActual<=11){
                    $dentro3Meses = true;
                }
            }elseif (
                $anioActual > $anioMatricula and
                $mesActual < $mesMatricula and $mesActual <= 7 and
                ($anioActual - $anioMatricula) == 1 and
                ($mesActual - $mesMatricula) * -1 <= 7
            ) {
                //dd("a_actual:".$anioActual."-a_matricula:".$anioMatricula."-m_actual:".$mesActual."-m_matricula".$mesMatricula);
                if($diaActual>=1 and $diaActual<=11){
                    $dentro3Meses = true;
                }
            }
        } else {
            $dentro3Meses = true;
        }
        /*if($cliente->id==66493){
            dd("a_actual:".$anioActual."-a_matricula:".$anioMatricula."-m_actual:".$mesActual."-m_matricula".$mesMatricula);
        }*/
        
        return $dentro3Meses;
    }

    public function historiaMatricula(Request $request){
        $datos=$request->all();
        $cliente=Cliente::find($datos['cliente']);
        //dd($cliente->revisionHistory->toArray());
        return view('clientes.reportes.historiaMatricula', compact('cliente'));
    }

    public function verificaMateriasAdeudosPendientes(Request $request){
        $datos=$request->all();
        $cliente=Cliente::find($datos['id']);
        $seguimiento=Seguimiento::where('cliente_id', $cliente->id)->first();
        if ($cliente->st_cliente_id == 31) {
            $cliente->st_cliente_id = 30;
            $cliente->save();
            $cliente->st_cliente_id = 20;
            $cliente->save();
            $seguimiento->st_seguimiento_id = 7;
            $seguimiento->save();
        }else{
            $cliente->st_cliente_id = 30;
            $cliente->save();
            //$seguimiento->st_seguimiento_id = 7;
            //$seguimiento->save();
            
        }
        return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Actualizado.');
    }

    public function nict()
    {
        $e = Empleado::where('user_id', Auth::user()->id)->first();
        $plantels = array();
        foreach ($e->plantels as $p) {
            array_push($plantels, $p->id);
        }
        $planteles = Plantel::whereIn('id', $plantels)->pluck('razon', 'id');
        return view('clientes.reportes.nict', compact('planteles'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function nictR(Request $request)
    {
        $datos = $request->all();
        $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
        if ($param->valor <> 0) {
            $datos['inicio_matricula'] = $param->valor . $datos['inicio_matricula'];
        }
        $planteles = Plantel::select('plantels.id', 'plantels.meta_total')->whereIn('plantels.id', $datos['plantel_f'])->get();
        $totales = Cliente::select('p.razon', 'g.seccion', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            ->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();

        $totales2 = Cliente::select('p.razon', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->whereIn('a.caja_concepto_id', array(1, 22,23, 25))// se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            //->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();
        //dd($totales->toArray());

        $detalle = Cliente::select(
            'p.razon',
            'clientes.matricula',
            'clientes.id as cliente_id',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.bnd_reclasificado',
            'clientes.tel_fijo',
            'clientes.tel_cel',
            'stc.name as st_cliente',
            'sts.name as st_seguimiento',
            'g.seccion',
            DB::raw('concat(emp.nombre, " ",emp.ape_paterno, " ",emp.ape_materno) as empleado_nombre'),
            //'cc.name as concepto',
            //'a.caja_concepto_id',
            //'c.fecha as fecha_caja',
            'clientes.bnd_doc_oblig_entregados',
            'tu.name as turno'
        )
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            //->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            //->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('empleados as emp', 'emp.id', '=', 'clientes.empleado_id')
            //->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('turnos as tu', 'tu.id', 'ccli.turno_id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            //->where('a.pagado_bnd', 1)
            //->where('c.st_caja_id', 1)
            //->where('clientes.id', 88063)
            //->whereIn('a.caja_concepto_id', array(1,22,23, 25)) // se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            //->whereNull('a.deleted_at')
            //->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            //->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->orderBy('p.razon')
            ->orderBy('g.seccion')
            ->get();
        //dd($detalle->toArray());
        $registros = array();
        foreach ($detalle->toArray() as $d) {
            //dd($d['cliente_id']);
            $adeudos12325 = Adeudo::where('cliente_id', $d['cliente_id'])
                ->where('pagado_bnd', 1)
                ->whereIn('caja_concepto_id', array(1, 23, 25))->get();
            $d['12325'] = "";
            $d['fecha_caja_12325'] = "";
            foreach ($adeudos12325 as $adeudo) {
                $d['12325'] = $adeudo->cajaConcepto->name;
                $d['fecha_caja_12325'] = $adeudo->caja->fecha;
                break;
            }

            if ($d['bnd_doc_oblig_entregados'] == 1) {
                $d['bnd_doc_oblig_entregados'] = 'Si';
            } else {
                $d['bnd_doc_oblig_entregados'] = 'No';
            }
            $tramites = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cln.caja_concepto_id', 22)
                ->where('cliente_id', $d['cliente_id'])
                ->first();

            if (is_null($tramites)) {
                $d['tramites'] = "No";
                $d['tramites_fecha'] = "";
            } else {
                //dd($tramites->toArray());    
                $d['tramites'] = "Si";
                $d['tramites_fecha'] = $tramites->fecha_caja;
            }
            $primera_mensualidad = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->where('cliente_id', $d['cliente_id'])
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cc.bnd_mensualidad', 1)
                ->first();
            if (is_null($primera_mensualidad)) {
                $d['primera_mensualidad'] = "No";
                $d['primera_mensualidad_fecha'] = "";
                //dd($primera_mensualidad);
            } else {
                $d['primera_mensualidad'] = "Si";
                $d['primera_mensualidad_fecha'] = $primera_mensualidad->fecha_caja;
            }
            //dd($d);
            array_push($registros, $d);
        }
        //dd($registros);

        $totales_seccion = array();
        $seccion = "";
        $contador_seccion = 0;

        $plantel = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_estatus = 0;
        $totales_plantel_estatus = array();
        //dd();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            $contador_seccion++;
            $contador_plantel_estatus++;
            $plantel = $r['razon'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_estatus,
            array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
        );
        //dd($totales_plantel_estatus);


        $plantel = "";
        $seccion = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_seccion_estatus = 0;
        $totales_plantel_seccion_estatus = array();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($seccion != $r['seccion'] and $seccion != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            $contador_plantel_seccion_estatus++;
            $plantel = $r['razon'];
            $seccion = $r['seccion'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_seccion_estatus,
            array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
        );
        //dd($totales_plantel_seccion_estatus);
        return view('clientes.reportes.nictR', compact('registros', 'totales_plantel_estatus', 'totales_plantel_seccion_estatus'));
    }

    public function concretadosComisiones()
    {
        $e = Empleado::where('user_id', Auth::user()->id)->first();
        $plantels = array();
        foreach ($e->plantels as $p) {
            array_push($plantels, $p->id);
        }
        $planteles = Plantel::whereIn('id', $plantels)->pluck('razon', 'id');
        return view('clientes.reportes.concretadosComisiones', compact('planteles'))
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function concretadosComisionesR(Request $request)
    {
        $datos = $request->all();
        $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
        if ($param->valor <> 0) {
            $datos['inicio_matricula'] = $param->valor . $datos['inicio_matricula'];
        }
        $planteles = Plantel::select('plantels.id', 'plantels.meta_total')->whereIn('plantels.id', $datos['plantel_f'])->get();
        $totales = Cliente::select('p.razon', 'g.seccion', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            ->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();

        $totales2 = Cliente::select('p.razon', 'sts.name as estatus', DB::raw('count(sts.name) as total_estatus'))
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            ->where('a.pagado_bnd', 1)
            ->where('c.st_caja_id', 1)
            //->whereIn('a.caja_concepto_id', array(1, 22,23, 25))// se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            ->whereNull('a.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            ->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->groupBy('p.razon')
            //->groupBy('g.seccion')
            ->groupBy('sts.name')
            ->get();
        //dd($totales->toArray());

        $secciones=explode(',',$datos['secciones']);
        
        $detalle = Cliente::select(
            'p.razon',
            'clientes.matricula',
            'clientes.id as cliente_id',
            'clientes.ape_paterno',
            'clientes.ape_materno',
            'clientes.nombre',
            'clientes.nombre2',
            'clientes.bnd_reclasificado',
            'clientes.tel_fijo',
            'clientes.tel_cel',
            'clientes.fec_docs_oblig_entregados',
            'stc.name as st_cliente',
            'sts.name as st_seguimiento',
            'g.seccion',
            DB::raw('concat(emp.nombre, " ",emp.ape_paterno, " ",emp.ape_materno) as empleado_nombre'),
            //'cc.name as concepto',
            //'a.caja_concepto_id',
            //'c.fecha as fecha_caja',
            'clientes.bnd_doc_oblig_entregados',
            'tu.name as turno',
            //'sec.name as seccion',
            //'csec.name as clasificacion_seccion',
            'stp.name as etapa_prospecto'
            //'gra.seccion'
        )
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            //->join('adeudos as a', 'a.cliente_id', '=', 'clientes.id')
            //->join('caja_conceptos as cc', 'cc.id', '=', 'a.caja_concepto_id')
            ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('empleados as emp', 'emp.id', '=', 'clientes.empleado_id')
            ->join('st_prospectos as stp','stp.id','emp.st_prospecto_id')
            //->join('cajas as c', 'c.id', '=', 'a.caja_id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'clientes.id')
            ->join('grados as gra','gra.id','ccli.grado_id')
            //->join('seccions as sec','sec.id','gra.seccion_id')
            //->join('clasificacion_seccions as csec','csec.id','sec.clasificacion_seccion_id')
            ->join('turnos as tu', 'tu.id', 'ccli.turno_id')
            ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
            //->where('a.pagado_bnd', 1)
            //->where('c.st_caja_id', 1)
            //->where('clientes.id', 88063)
            //->whereIn('a.caja_concepto_id', array(1,22,23, 25)) // se quito concepto 22 tramites adelante se hace especificamente este trabajo
            //->where('clientes.st_cliente_id', '<>', 3)
            ->whereIn('clientes.plantel_id', $datos['plantel_f'])
            //->whereIn('g.seccion', $secciones)
            ->where('clientes.matricula', 'like', $datos['inicio_matricula'] . "%")
            //->whereNull('a.deleted_at')
            //->whereNull('c.deleted_at')
            ->whereNull('ccli.deleted_at')
            ->where('ccli.plantel_id', '>', 0)
            ->where('ccli.especialidad_id', '>', 0)
            ->where('ccli.nivel_id', '>', 0)
            ->where('ccli.grado_id', '>', 0)
            ->where('ccli.turno_id', '>', 0)
            //->whereDate('clientes.fec_docs_oblig_entregados','<=',$datos['menor_igual_fecha'])
            //->whereRaw('(a.caja_concepto_id = 1 or a.caja_concepto_id = 22 or a.caja_concepto_id = 23 or a.caja_concepto_id = 25)')
            ->orderBy('p.razon')
            ->orderBy('g.seccion')
            ->get();
        //dd($detalle->toArray());
        $registros = array();
        foreach ($detalle->toArray() as $d) {
            //dd($d['cliente_id']);
            $adeudos12325 = Adeudo::where('cliente_id', $d['cliente_id'])
                ->where('pagado_bnd', 1)
                ->whereIn('caja_concepto_id', array(1, 23, 25))->get();
            $d['12325'] = "";
            $d['fecha_caja_12325'] = "";
            foreach ($adeudos12325 as $adeudo) {
                $d['12325'] = $adeudo->cajaConcepto->name;
                $d['fecha_caja_12325'] = $adeudo->caja->fecha;
                break;
            }

            if ($d['bnd_doc_oblig_entregados'] == 1) {
                $d['bnd_doc_oblig_entregados'] = 'Si';
            } else {
                $d['bnd_doc_oblig_entregados'] = 'No';
            }
            $tramites = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cln.caja_concepto_id', 22)
                ->where('cliente_id', $d['cliente_id'])
                ->first();

            if (is_null($tramites)) {
                $d['tramites'] = "No";
                $d['tramites_fecha'] = "";
            } else {
                //dd($tramites->toArray());    
                $d['tramites'] = "Si";
                $d['tramites_fecha'] = $tramites->fecha_caja;
            }
            $primera_mensualidad = Caja::select('cajas.fecha as fecha_caja', 'cc.name as concepto')
                ->where('cliente_id', $d['cliente_id'])
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
                //->whereDate('fecha','>=',$d['fecha_caja'])
                ->where('cajas.st_caja_id', 1)
                ->where('cc.bnd_mensualidad', 1)
                ->first();
            if (is_null($primera_mensualidad)) {
                $d['primera_mensualidad'] = "No";
                $d['primera_mensualidad_fecha'] = "";
                //dd($primera_mensualidad);
            } else {
                $d['primera_mensualidad'] = "Si";
                $d['primera_mensualidad_fecha'] = $primera_mensualidad->fecha_caja;
            }
            //dd($d);
            if(($d['fecha_caja_12325']<=$datos['menor_igual_fecha'] and $d['fecha_caja_12325']<>"") or 
            ($d['tramites_fecha']<=$datos['menor_igual_fecha'] and $d['tramites_fecha']<>'') or 
            ($d['primera_mensualidad_fecha']<=$datos['menor_igual_fecha'] and $d['primera_mensualidad_fecha']<>"")){
                //dd($secciones);
                if($secciones[0]==""){
                    array_push($registros, $d);
                }elseif(in_array($d['seccion'], $secciones)){
                    array_push($registros, $d);
                }
                
            }
        }
        //dd($registros);

        /*
        $totales=Cliente::select(DB::raw('p.id, p.razon, p.meta_total, count(clientes.matricula) as total_matriculas'))
        ->join('adeudos as a','a.cliente_id','=','clientes.id')
        ->join('caja_conceptos as cc','cc.id','=','a.caja_concepto_id')
        ->join('plantels as p','p.id','=','clientes.plantel_id')
        ->join('st_clientes as stc','stc.id','=','clientes.st_cliente_id')
        ->join('cajas as c','c.id','=','a.caja_id')
        ->where('a.pagado_bnd',1)
        ->where('c.st_caja_id',1)
        ->whereIn('a.caja_concepto_id',array(1, 25))
        ->where('clientes.st_cliente_id','<>',3)
        ->whereIn('clientes.plantel_id',$datos['plantel_f'])
        ->where('clientes.matricula','like',$datos['inicio_matricula']."%")
        ->whereNull('a.deleted_at')
        ->whereNull('c.deleted_at')
        ->orderBy('p.razon')
        ->groupBy('p.id')
        ->groupBy('p.razon')
        ->groupBy('p.meta_total')
        ->get();
        */
        //dd($totales->toArray());
        $totales_seccion = array();
        $seccion = "";
        $contador_seccion = 0;

        $plantel = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_estatus = 0;
        $totales_plantel_estatus = array();
        //dd();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_estatus,
                    array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
                );
                $contador_plantel_estatus = 0;
            }
            $contador_seccion++;
            $contador_plantel_estatus++;
            $plantel = $r['razon'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_estatus,
            array("razon" => $plantel, "estatus" => $estatus, "total" => $contador_plantel_estatus)
        );
        //dd($totales_plantel_estatus);


        $plantel = "";
        $seccion = "";
        $estatus = "";
        $matricula = "";
        $contador_plantel_seccion_estatus = 0;
        $totales_plantel_seccion_estatus = array();
        foreach ($registros as $r) {
            //dd($r);
            if ($matricula == $r['matricula']) {
                continue;
            }
            if ($plantel != $r['razon'] and $plantel != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($seccion != $r['seccion'] and $seccion != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            if ($estatus != $r['st_seguimiento'] and $estatus != "") {
                array_push(
                    $totales_plantel_seccion_estatus,
                    array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
                );
                $contador_plantel_seccion_estatus = 0;
            }
            $contador_plantel_seccion_estatus++;
            $plantel = $r['razon'];
            $seccion = $r['seccion'];
            $estatus = $r['st_seguimiento'];
            $matricula = $r['matricula'];
        }
        array_push(
            $totales_plantel_seccion_estatus,
            array("razon" => $plantel, "seccion" => $seccion, "estatus" => $estatus, "total" => $contador_plantel_seccion_estatus)
        );
        //dd($totales_plantel_seccion_estatus);
        return view('clientes.reportes.concretadosComisionesR', compact('registros', 'totales_plantel_estatus', 'totales_plantel_seccion_estatus'));
    }
}
