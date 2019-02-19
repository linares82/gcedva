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
use App\Paise;
use App\Lectivo;
use App\Plantilla;
use App\Plantel;
use App\StCliente;
use App\User;
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
use Carbon\Carbon;

//use App\Mail\CorreoBienvenida as Envia_mail;

class ClientesController extends Controller {

    private $meta_residuo = 0;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $users=User::pluck('name','id');
        $users->prepend('Seleccionar opción',0);
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
        $clientes = Seguimiento::getAllData($request, 20, session('filtro_clientes'));
        
        return view('clientes.index', compact('clientes','users'))
                        ->with('list', Seguimiento::getListFromAllRelationApps())
                        ->with('list1', Cliente::getListFromAllRelationApps());
    }

    public function index2(Request $request) {
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
    public function create() {

        //dd(Municipio::get());
        $p = Auth::user()->can('IfiltroEmpleadosXPlantel');
        if ($p) {
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                    ->where('plantel_id', '=', $e->plantel_id)
                    ->where('puesto_id', '=', 2)
                    ->pluck('name', 'id');
        } else {
            $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                    ->where('puesto_id', '=', 2)
                    ->pluck('name', 'id');
        }
        $empleados = $empleados->reverse();
        $empleados->put(0, 'Seleccionar Opción');
        $empleados = $empleados->reverse();
        //dd($empleados);
        $cuestionarios = Ccuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        return view('clientes.create', compact('empleados', 'cuestionarios'))
                        ->with('list', Cliente::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCliente $request) {
        $id = 0;
        $input = $request->all();
        //dd($input);
        //$empleado=Empleado::find($request->input('empleado_id'));
        //$input['plantelplantel_id']=$empleado->plantel->id;
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['especialidad_id'] = 0;
        $input['nivel_id'] = 0;
        $input['grado_id'] = 0;
        $input['turno_id'] = 0;
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
        $input['grado_id'] = 0;
        $input['turno_id'] = 0;
        $input['paise_id'] = 22;

        $input['turno_id'] = 0;
        if (is_null($input['ape_materno'])) {
            $input['ape_materno'] = " ";
        }
        if (is_null($input['nombre2'])) {
            $input['nombre2'] = " ";
        }
        if (is_null($input['matricula'])) {
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
        if (!isset($input['extranjero'])) {
            $input['extranjero'] = 0;
        } else {
            $input['extranjero'] = 1;
        }
        if (!isset($input['beca_bnd'])) {
            $input['beca_bnd'] = 0;
        } else {
            $input['beca_bnd'] = 1;
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
            $avisos=AvisosInicio::get();
            foreach($avisos as $a){
                $aviso=new Aviso;
                $aviso->seguimiento_id=$s->id;
                $aviso->asunto_id=$a->asunto_id;
                $aviso->detalle=$a->detalle;
                $aviso->fecha=date('Y-m-j', strtotime('+'.$a->dias_despues.' day', strtotime(date('Y-m-j'))));
                $aviso->activo=1;
                $aviso->usu_alta_id=Auth::user()->id;
                $aviso->usu_mod_id=Auth::user()->id;
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
    public function show($id, Cliente $cliente) {
        $cliente = $cliente->find($id);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Cliente $cliente) {
        $cliente = $cliente->with(['ccuestionario'])->find($id);
        //dd($cliente->ccuestionario->ccuestionarioPreguntas);
        $p = Auth::user()->can('IfiltroEmpleadosXPlantel');
        //dd($p);
        if ($p) {
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                    ->where('plantel_id', '=', $e->plantel_id)
                    ->where('puesto_id', '=', 2)
                    ->pluck('name', 'id');
        } else {
            $empleados = Empleado::select('id', DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name'))
                    ->where('puesto_id', '=', 2)
                    ->pluck('name', 'id');
        }
        $empleados = $empleados->reverse();
        $empleados->put(0, 'Seleccionar Opción');
        $empleados = $empleados->reverse();
        $cp = PreguntaCliente::where('cliente_id', '=', $id)->get();
        $preguntas = Preguntum::pluck('name', 'id');
        //dd($cp);
        //dd($preguntas);
        $doc_existentes = DB::table('pivot_doc_clientes as pde')->select('doc_alumno_id')
                        ->join('clientes as c', 'c.id', '=', 'pde.cliente_id')
                        ->where('c.id', '=', $id)
                        ->where('pde.deleted_at', '=', NULL)->get();

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

        //count($cliente->adeudos));
        return view('clientes.edit', compact('cliente', 'preguntas', 'cp', 'documentos_faltantes', 'empleados', 'cuestionarios'))
                        ->with('list', Cliente::getListFromAllRelationApps())
                        ->with('list1', PivotDocCliente::getListFromAllRelationApps())
                        ->with('list2', CombinacionCliente::getListFromAllRelationApps())
                        ->with('');
    }

    public function getReasignar() {
        return view('clientes.frm_reasignar')
                ->with('list', Cliente::getListFromAllRelationApps())
                ->with('list2', Seguimiento::getListFromAllRelationApps());
    }

    public function getCuenta(Request $request) {
        //dd($request->input('plantel_id'));
        $plantel = $request->input('plantel_id');
        $empleado = $request->input('empleado_id');
        $estatus = $request->input('st_seguimiento_id');
        $cuenta = Cliente::where('plantel_id', '=', $plantel)
                ->join('seguimientos as s','s.cliente_id','=','clientes.id')
                ->where('empleado_id', '=', $empleado)
                ->where('s.st_seguimiento_id', '=', $estatus)
                ->count();

        return $cuenta;
    }

    public function postReasignar(Request $request) {
        $input = $request->all();
        //dd($input);
        
        $clis=Cliente::select('clientes.id')
                ->join('seguimientos as s','s.cliente_id','=','clientes.id')
                ->where('clientes.plantel_id', '=', $input['plantel_id'])
                ->where('clientes.empleado_id', '=', $input['empleado_id'])
                ->where('s.st_seguimiento_id', '=', $input['st_seguimiento_id'])
                ->get();
        foreach($clis as $cli){
            $cliente=Cliente::find($cli->id);
            $cliente->empleado_id=$input['empleado_id2']    ;
            $cliente->save();
        }
        
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
    public function duplicate($id, Cliente $cliente) {
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
    public function update($id, Cliente $cliente, updateCliente $request) {
        //dd("fil");
        //$input = $request->all();


        $input = $request->except(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28',
            '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40']);
        //dd($input);
        $preguntas = $request->only(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15',
            '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28',
            '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40']);
        //dd($preguntas);
        $input['usu_mod_id'] = Auth::user()->id;
        //dd($input);
        if (is_null($input['ape_materno'])) {
            $input['ape_materno'] = " ";
        }
        if (is_null($input['nombre2'])) {
            $input['nombre2'] = " ";
        }
        if (is_null($input['matricula'])) {
            $input['matricula'] = " ";
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
        if (!isset($input['extranjero'])) {
            $input['extranjero'] = 0;
        } else {
            $input['extranjero'] = 1;
        }
        if (!isset($input['beca_bnd'])) {
            $input['beca_bnd'] = 0;
        } else {
            $input['beca_bnd'] = 1;
        }
        //dd($input);
        //update data
        $cliente = $cliente->find($id);
        $cantidad_preguntas = $cliente->ccuestionario->ccuestionarioPreguntas->count();
        //dd($input);
        $cliente->update($input);
        //dd($request->all());
        if ($request->has('doc_cliente_id') and $request->input('doc_cliente_id')!='0' and $request->has('archivo')) {
            $input2['doc_alumno_id'] = $request->get('doc_cliente_id');
            $input2['archivo'] = $request->get('archivo');
            $input2['cliente_id'] = $id;
            $input2['usu_alta_id'] = Auth::user()->id;
            $input2['usu_mod_id'] = Auth::user()->id;
            PivotDocCliente::create($input2);
        }

        foreach ($preguntas as $llave => $valor) {
            if ($llave <> '_token' and ! is_null($valor)) {
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
        if ($cantidad_preguntas <> $cantidad_respuestas) {
            return redirect()->route('clientes.edit', $id)->with('message', 'Cuestionario incompleto.');
        }

        return redirect()->route('clientes.edit', $id)->with('message', 'Registro Actualizado.');
    }

    public function confirmaCorreo($id, Cliente $cliente, Request $request) {
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
    public function destroy($id, Cliente $cliente, Seguimiento $s) {
        $cliente = $cliente->find($id);
        $cliente->delete();
        $s->where('cliente_id', '=', $id)->delete();

        return redirect()->route('clientes.index')->with('message', 'Registro Borrado.');
    }

    public function autocomplete(Request $request) {
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

    public function carga() {
        return view('clientes.carga')
                        ->with('list', Empleado::getListFromAllRelationApps());
    }

    public function cargaFile(Carga $request) {
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

    public function defineEmpleado($meta_individual) {
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

    public function enviaSms(Request $request) {
        //dd($_REQUEST);
        if ($request->ajax()) {
            try {
                $pais=Paise::find($request->input('pais_id'));
                //dd($pais);
                if($pais->marcado<>""){
                    $r = Param::where('llave', '=', 'sms')->first();
                    $no = Param::where('llave', '=', 'num_twilio')->first();

                    $codigo_marcado=$pais->marcado;
                    $to = $codigo_marcado . e($request->input('tel_cel'));
                    //dd($to);
                    $message = e($request->input('cve_cliente'));
                    $from = $no->valor;

                    //dd($r->valor);
                    if ($r->valor == 'activo') {
                        if (Sms::send($message, $to, $from)) {
                            $input['usu_envio_id'] = Auth::user()->id;
                            $input['cliente_id'] = e($request->input('id'));
                            $input['cantidad'] = 1;
                            $input['fecha_envio'] = date("Y/m/d");
                            $input['usu_alta_id'] = Auth::user()->id;
                            $input['usu_mod_id'] = Auth::user()->id;
                            Sm::create($input);
                            //dd("msj");
                            $c=Cliente::find($input['cliente_id']);
                            $c->contador_sms=$c->contador_sms+1;
                            $c->save();
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
    
    public function enviaSmsSeguimiento(Request $request) {
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

    public function enviaMail(Request $request) {
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
                    \Mail::send('emails.2', array('img1' => storage_path('app') . "/public/imagenes/plantillas_correos/" . $pla->img1, 'plantilla' => $pla->plantilla, 'id' => $cli->id), function($message) use ($request) {
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
                    
                    $c=Cliente::find($input2['cliente_id']);
                    $c->contador_mail=$c->contador_mail+1;
                    $c->save();
                }

                //return true;
            } catch (\Exception $e) {
                //dd($e);
                return $e;
            }
        }
    }

    public function cmbMClientes() {
        $c = Cliente::select('id', 'nombre', 'nombre2', 'ape_paterno', 'ape_materno', 'mail')->get();
        //return response()->json($c);
        echo json_encode($c);
    }

    public function indexLista() {
        return view('clientes.modal_search');
    }

    public function lista(Request $request) {
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

    public function getCmbAlumno(Request $request) {
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
            if (isset($cliente) and $cliente <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $cliente) {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'));
                    } else {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getNombreCliente(Request $request) {
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

    public function descargaClientes() {

        $clientes = Cliente::select('clientes.fec_registro as FechaRegistro', 'clientes.nombre as PrimerNombre', 'clientes.nombre2 as SegundoNombre', 'clientes.ape_paterno as ApellidoPaterno', 'clientes.ape_materno as ApellidoMaterno', 'clientes.tel_fijo as Telefono', 'clientes.tel_cel as Celular', 'clientes.mail as Email', 'clientes.escuela_procedencia as EscuelaProcedencia', 'm.name as medio as Medio', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as Asesor'))
                ->join('medios as m', 'm.id', '=', 'clientes.medio_id')
                ->join('empleados as e', 'e.id', '=', 'clientes.empleado_id')
                //->limit(20)
                ->get();
        //dd($clientes);
        /* $clientes_array=array();
          $encabezados=array('Fecha', 'P. Nombre', 'S. Nombre', 'A. Paterno', 'A. Materno', 'Teléfono',
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
        Excel::create('Clientes', function($excel) use ($clientes) {
            $excel->sheet('Clientes', function($sheet) use ($clientes) {
                $sheet->fromArray($clientes->toArray());
            });
        })->download('xlsx');
        dd("excel terminado");
    }

    public function indexReportes() {
        return view('clientes.reportes.indice');
    }

    public function reportesCcxep() {
        return view('clientes.reportes.ccxep')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesCcxepR(Request $request) {
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
            ;
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

    public function reportesEcap() {
        return view('clientes.reportes.ecap')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesEcapR(Request $request) {
        $filtros = $request->all();
        $f = date("Y-m-d");
        $l = Lectivo::find(0)->first();
        $tabla=array();
        $encabezado=array();
        $encabezado[0]='Empleado';
        if(!isset($filtros['plantel_f'])){
            $filtros['plantel_f']=Auth::user()->plantel_id;
        }
        $estatus = StSeguimiento::where('id','>',0)->get();
        $empleados = Empleado::where('plantel_id','=', $filtros['plantel_f'])
                             ->where('puesto_id', '=', 2)->get();
        
        //dd($empleados->toArray());
        $i=1;
        foreach($estatus as $st){
            if($st->id>0){
                $encabezado[$i]=$st->name;
                $i++;
            }
        }
        array_push($tabla, $encabezado);
        //dd($encabezado);
        foreach($empleados as $e){
            $linea=array();
            $i=0;
            $linea[$i]=$e->nombre." ".$e->ape_paterno." ".$e->ape_materno;
            foreach($estatus as $st){
               $i++;
                if($st->id==2){
                   $valor=Seguimiento::select(DB::raw('count(st.name) as total'))
                            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            ->where('st_seguimiento_id', '=', $st->id)
                            ->where('e.id', '=', $e->id)
                            ->where('c.plantel_id', '=', $filtros['plantel_f'])
                            ->where('seguimientos.created_at', '>=', $l->inicio)
                            ->where('seguimientos.created_at', '<=', $l->fin)
                            ->value('total');
               }elseif($st->id>0){
                   $valor=Seguimiento::select(DB::raw('count(st.name) as total'))
                            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            ->where('st_seguimiento_id', '<>', $st->id)
                            ->where('e.id', '=', $e->id)
                            ->where('c.plantel_id', '=', $filtros['plantel_f'])
                            ->value('total');
               } 
               $linea[$i]=$valor;
            }
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $p=Plantel::find($filtros['plantel_f']);
        $plantel=$p->razon;
        //dd($plantel);
        
        return view('clientes.reportes.ecap_r', compact('tabla', 'plantel'))
                ->with('datos_grafica', json_encode($tabla));
        
        
    }

    public function cuentaEstatusClientes() {
        $resultado=Cliente::select(DB::raw('count(st.name) as total, concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado, p.razon,st.name'))
                          ->join('seguimientos as s', 's.cliente_id','=','clientes.id')
                          ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                          ->join('plantels as p', 'p.id', '=', 'clientes.plantel_id')
                          ->join('empleados as e', 'e.id', '=','clientes.empleado_id')
                          ->orderBy('p.razon')
                          ->orderBy('empleado')
                          ->orderBy('st.name')
                          ->groupBy('p.razon')
                          ->groupBy('empleado')
                          ->groupBy('st.name')
                          ->get();
        //dd($resultado);
        //return view('clientes.reportes.cuentaEstatusClientes', compact('resultado'));
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('clientes.reportes.cuentaEstatusClientes', array('resultado' => $resultado))
                ->setPaper('letter', 'portrait');
        return $pdf->download('reporte.pdf');
    }
    
    public function reportesEppa() {
        return view('clientes.reportes.eppa')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function reportesEppaR(Request $request) {
        $filtros = $request->all();
        $f = date("Y-m-d");
        
        $tabla=array();
        $encabezado=array();
        $encabezado[0]='Empleado';
        if(!isset($filtros['plantel_f'])){
            $filtros['plantel_f']=Auth::user()->plantel_id;
        }
        $estatus = StSeguimiento::where('id','>',0)->get();
        $empleados = Empleado::where('plantel_id','=', $filtros['plantel_f'])
                             ->where('puesto_id', '=', 2)->get();
        
        //dd($empleados->toArray());
        $i=1;
        foreach($estatus as $st){
            if($st->id>0){
                $encabezado[$i]=$st->name;
                $i++;
            }
        }
        array_push($tabla, $encabezado);
        //dd($encabezado);
        foreach($empleados as $e){
            $linea=array();
            $i=0;
            $linea[$i]=$e->nombre." ".$e->ape_paterno." ".$e->ape_materno;
            foreach($estatus as $st){
               $i++;
                if($st->id==2){
                   $valor=Seguimiento::select(DB::raw('count(st.name) as total'))
                            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                           ->join('hactividades as h', 'h.cliente_id','=','c.id')
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
               }elseif($st->id>0){
                   $valor=Seguimiento::select(DB::raw('count(st.name) as total'))
                            ->join('st_seguimientos as st', 'st.id', '=', 'seguimientos.st_seguimiento_id')
                            ->join('clientes as c', 'c.id', '=', 'seguimientos.cliente_id')
                            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
                            ->where('st_seguimiento_id', '<>', $st->id)
                            ->where('e.id', '=', $e->id)
                            ->where('c.plantel_id', '=', $filtros['plantel_f'])
                            ->value('total');
               } 
               $linea[$i]=$valor;
            }
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $p=Plantel::find($filtros['plantel_f']);
        $plantel=$p->razon;
        //dd($plantel);
        
        return view('clientes.reportes.eppa_r', compact('tabla', 'plantel'))
                ->with('datos_grafica', json_encode($tabla));
        
        
    }
    
    public function rpt_sms_mail() {
        return view('clientes.reportes.sms_mail')->with('list', Cliente::getListFromAllRelationApps());
    }
    
    public function rpt_sms_mailr(Request $request) {
        $data=$request->all();
        //dd($data);
        $registros=Cliente::select('clientes.id','clientes.nombre','clientes.nombre2','clientes.ape_paterno','clientes.ape_materno',
                                   'p.razon as plantel', DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as empleado'),
                                   'clientes.tel_cel',
                                   DB::raw('if(clientes.celular_confirmado=1,"SI","NO") as celular_confirmado'),'clientes.mail',
                                   DB::raw('if(clientes.correo_confirmado=1,"SI","NO") as correo_confirmado'))
                          ->join('plantels as p','p.id','=','clientes.plantel_id')
                          ->join('empleados as e','e.id','=','clientes.empleado_id')
                          ->whereBetween('clientes.plantel_id',[$data['plantel_f'],$data['plantel_t']])
                          ->whereDate('clientes.created_at', '>',date_format(date_create($data['fecha_f']),'Y/m/d H:i:s'))
                          ->whereDate('clientes.created_at', '<',date_format(date_create($data['fecha_t']),'Y/m/d H:i:s'))
                          ->get();
        //dd($registros->toArray());
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($registros, ['id'=>'ID','nombre'=>'PRIMER NOMBRE',
                                                    'nombre2'=>'SEGUNDO NOMBRE',
                                                    'ape_paterno'=>'A. PATERNO',
                                                    'ape_materno'=>'A. MATERNO',
                                                    'plantel'=>'PLANTEL',
                                                    'empleado'=>'EMPLEADO',
                                                    'tel_cel'=>'CELULAR',
                                                    'celular_confirmado'=>'CELULAR CONFIRMADO',
                                                    'mail'=>'MAIL',
                                                    'correo_confirmado'=>'CORREO CONFIRMADO'])->download();
        
    }
    
    //Funciones para la API
    public function findBy(Request $request){
        $datos=$request->all();
        //dd($datos);
        $clientes=Cliente::where($datos['campo'], '=', $datos['valor'])->get();
        return response()->json($clientes);
    }
    
    public function altasXUsuario() {
        
        return view('clientes.reportes.altasXUsuario')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function altasXUsuarioR(Request $request) {
        $filtros = $request->all();
        
        $resultados=Cliente::select(DB::raw('p.razon, e.id, count(clientes.nombre) as total_usuario'))
                           ->join('users as u', 'u.id','=','clientes.usu_alta_id')
                           ->join('empleados as e','e.user_id','=','u.id')
                           ->join('plantels as p','p.id','=','clientes.plantel_id')
                           ->where('clientes.plantel_id','>=', $filtros['plantel_f'])
                           ->where('clientes.plantel_id','<=', $filtros['plantel_t'])
                           ->where('clientes.usu_alta_id','>=', $filtros['usuario_f'])
                           ->where('clientes.usu_alta_id','<=', $filtros['usuario_t'])
                           ->where('clientes.created_at','>=', $filtros['fecha_f']." 00:00:00")
                           ->where('clientes.created_at','<=', $filtros['fecha_t']." 23:00:00")
                           ->groupBy('p.razon','e.id')
                           ->get();
        //dd($resultados->toArray());
        
        return view('clientes.reportes.altasXUsuarioR', compact('resultados','filtros'));
        
        
    }
    
    public function Boleta(Request $request){
        
        $cliente=Cliente::find($request['id']);
        return view('clientes.reportes.boleta', compact('cliente'))
                        ->with('');
    }
}
