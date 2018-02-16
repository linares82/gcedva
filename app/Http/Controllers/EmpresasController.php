<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\Empresa;
use App\CuestionarioDato;
use App\Cuestionario;
use App\Cliente;
use App\ActividadEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEmpresa;
use App\Http\Requests\createEmpresa;
use DB;

class EmpresasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $empresas = Empresa::getAllData($request);

        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $p = Empleado::where('user_id', '=', Auth::user()->id)
                ->value('plantel_id');
        $pl=DB::table('plantels as p')
                            ->join('empleados as e', 'e.plantel_id','=', 'p.id')
                            ->where('e.user_id', Auth::user()->id)->value('p.id');
        $cuestionarios=Cuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        return view('empresas.create', compact('p', 'pl', 'cuestionarios'))
                        ->with('list', Empresa::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createEmpresa $request) {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Empresa::create($input);

        return redirect()->route('empresas.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        return view('empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        //dd($empresa->combinaciones->toArray());
        $p = Empleado::where('user_id', '=', Auth::user()->id)
                ->value('plantel_id');
        $pl=DB::table('plantels as p')
                            ->join('empleados as e', 'e.plantel_id','=', 'p.id')
                            ->where('e.user_id', Auth::user()->id)->value('p.id');
        $actividadesRelacionados=array();
        foreach($empresa->actividades as $ar){
            $actividadesRelacionados=array_add($actividadesRelacionados, $ar->id, $ar->name);
        }
        $actividadesList=ActividadEmpresa::where('plantel_id','=',$pl)->pluck('name', 'id');
        $cuestionarios=Cuestionario::where('st_cuestionario_id', '=', '1')->pluck('name', 'id');
        return view('empresas.edit', compact('empresa', 'p', 'actividadesList','actividadesRelacionados','pl', 'cuestionarios'))
                        ->with('list', Empresa::getListFromAllRelationApps())
                        ->with('list1', Cliente::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        return view('empresas.duplicate', compact('empresa'))
                        ->with('list', Empresa::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Empresa $empresa, updateEmpresa $request) {
        $input = $request->except(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',
                                   '16','17','18','19','20','21','22','23','24','25','26','27','28',
                                   '29','30','31','32','33','34','35','36','37','38','39','40',
                                   'nivel_id','grado_id','from','to','q']);
        $preguntas=$request->except(['razon_social','nombre_contacto','tel_fijo','tel_cel','correo1',
                                    'correo2','calle','no_int','no_ex','colonia','municipio_id',
                                    'estado_id','cp','giro_id','plantel_id','especialidad_id',
                                    'cuestionario_id','usu_alta_id','usu_mod_id','nivel_id','grado_id',
                                    'from','to','q']);
        //dd($preguntas);
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $empresa = $empresa->find($id);
        $cantidad_preguntas=$empresa->cuestionario->preguntas->count();
        //dd($cantidad_preguntas);
        $empresa->update($input);
        foreach($preguntas as $llave=>$valor){
            if($llave<>'_token'){
                //dd($preguntas);
                $dato=CuestionarioDato::where('empresa_id', '=', $id)
                                ->where('cuestionario_id','=', $input['cuestionario_id'])
                                ->where('cuestionario_pregunta_id','=', $llave)
                                ->first();
               //dd($dato);
               if(is_null($dato)){
                   $r=new CuestionarioDato;
                   $r->cuestionario_id=$input['cuestionario_id'];
                   $r->empresa_id=$id;
                   $r->cuestionario_id=$input['cuestionario_id'];
                   $r->cuestionario_pregunta_id=$llave;
                   $r->cuestionario_respuesta_id=$valor;
                   $r->name="";
                   $r->usu_alta_id= Auth::user()->id;
                   $r->usu_mod_id= Auth::user()->id;
                   //dd($r->toArray());
                   $r->save();
               }else{
                   $dato->cuestionario_respuesta_id=$valor;
                   $dato->name="";
                   $dato->usu_alta_id= Auth::user()->id;
                   $dato->usu_mod_id= Auth::user()->id;
                   //dd($dato);
                   $dato->save();
               }
            }
        }
        $cantidad_respuestas=CuestionarioDato::where('empresa_id', '=', $id)
                                ->where('cuestionario_id','=', $input['cuestionario_id'])
                                ->count();
        if($cantidad_preguntas<>$cantidad_respuestas){
            return redirect()->route('empresas.edit', $id)->with('message', 'Cuestionario incompleto.');
        }
        return redirect()->route('empresas.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Empresa $empresa) {
        $empresa = $empresa->find($id);
        $empresa->delete();

        return redirect()->route('empresas.index')->with('message', 'Registro Borrado.');
    }

    public function getEmpleadosXmail(Request $request) {
        if ($request->ajax()) {
            //dd($request->all());
            $mail = $request->get('correo');
            $nombre=$request->get('nombre');
            //dd($mail);
            
            $sr = DB::table('empresas as e')
                    ->join('clientes as c', 'c.empresa_id', '=', 'e.id')
                    ->select('c.id','c.mail', 'c.nombre')
                    ->where('e.correo1', '=', $mail)
                    ->whereNotNull('c.mail')
                    ->get();
            //dd($sr->toArray());
            $resultado=array();
            $lcorreos=$mail.",";
            $lnombres=$nombre.",";
            
                    
            foreach($sr as $r){
                $lcorreos=$lcorreos.$r->mail.",";
                $lnombres=$lnombres.$r->nombre.",";
            }
            $resultado=array(substr($lcorreos, 0, -1), substr($lnombres, 0, -2));
            return $resultado;
            //dd($r);
            
        }
    }

    public function addactividad(Request $request){
        if ($request->ajax()) {
            $actividad=$request->get('actividad');
            $empresa=$request->get('empresa');
            $empresa=Empresa::findOrFail($empresa);
            $empresa->actividades()->attach($actividad);
        }
    }
    
    public function lessActividad(Request $request){
        //dd($request);
        if ($request->ajax()) {
            $actividad=$request->get('actividad');
            $empresa=$request->get('empresa');
            $empresa=Empresa::findOrFail($empresa);
            $empresa->actividades()->detach($actividad);
        }
    }
}
