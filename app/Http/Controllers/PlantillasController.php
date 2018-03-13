<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Plantilla;
use App\Cliente;
use App\PlanCondicionFiltro;
use App\PlanCampoFiltro;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantilla;
use App\Http\Requests\createPlantilla;
use Storage;

class PlantillasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantillas = Plantilla::getAllData($request);

		return view('plantillas.index', compact('plantillas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillas.create')
			->with( 'list', Plantilla::getListFromAllRelationApps() )
                        ->with( 'list1', PlanCondicionFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantilla $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		$input['periodo_id']=2;
                /*if ($request->hasFile('file')) {
                    $containfile = true;
                    $file = $request->file('file');
                    $input['img1'] = $file->getClientOriginalName();
                }*/
		if($input['inicio']=="" or $input['inicio']=="0000-00-00"){$input['inicio']=date('Y-m-d');}
		if($input['fin']=="" or $input['fin']=="0000-00-00"){$input['fin']=date('Y-m-d');}
		if(!isset($input['activo_bnd'])){
			$input['activo_bnd']=0;
		}else{
			$input['activo_bnd']=1;
		}
		if(!isset($input['sms_bnd'])){
			$input['sms_bnd']=0;
		}else{
			$input['sms_bnd']=1;
		}
		if(!isset($input['mail_bnd'])){
			$input['mail_bnd']=0;
		}else{
			$input['mail_bnd']=1;
		}
                if(!isset($input['plantel_id'])){
			$input['plantel_id']=0;
		}
                if(!isset($input['especialidad_id'])){
			$input['especialidad_id']=0;
		}
                if(!isset($input['nivel_id'])){
			$input['nivel_id']=0;
		}
                if(!isset($input['asunto'])){
			$input['asunto']="";
		}
                if(!isset($input['tpo_correo_id'])){
			$input['tpo_correo_id']="";
		}
                
		$h=str_replace('http:/', 'http://', $input['plantilla']);
		$h=str_replace('&gt;', '>', $h);
		$input['plantilla']=$h;
		//dd($input);
		//create data
		$p=Plantilla::create( $input );
		/*$file = fopen(base_path('resources\views\emails\\'.$p->id.'.blade.php'), "w+");
		fwrite($file, $input['plantilla']);
		fclose($file);
                */
		return redirect()->route('plantillas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		return view('plantillas.show', compact('plantilla'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
                //dd($plantilla->condiciones->toArray());
		return view('plantillas.edit', compact('plantilla'))
			->with( 'list', Plantilla::getListFromAllRelationApps() )
                        ->with( 'list1', PlanCondicionFiltro::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		return view('plantillas.duplicate', compact('plantilla'))
			->with( 'list', Plantilla::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Plantilla $plantilla, updatePlantilla $request)
	{
		$input = $request->all();
                //dd($input);
		$input['usu_mod_id']=Auth::user()->id;
		$input['periodo_id']=2;
                $st="";
                if(isset($input['st_cliente'])){
                    $st=$input['st_cliente'];	
                    unset($input['st_cliente']);
                }
                unset($input['file']);
		//$esp=$input['especialidad_id'];
		//unset($input['especialidad_id']);
		$input['st_cliente_id']=0;
		/*if ($request->hasFile('file')) {
                    $containfile = true;
                    $file = $request->file('file');
                    $input['img1'] = $file->getClientOriginalName();
                }*/
                if(!isset($input['activo_bnd'])){
			$input['activo_bnd']=0;
		}else{
			$input['activo_bnd']=1;
		}
		if(!isset($input['sms_bnd'])){
			$input['sms_bnd']=0;
		}else{
			$input['sms_bnd']=1;
		}
		if(!isset($input['mail_bnd'])){
			$input['mail_bnd']=0;
		}else{
			$input['mail_bnd']=1;
		}
                if(!isset($input['asunto'])){
			$input['asunto']="";
		}
                if(!isset($input['tpo_correo_id'])){
			$input['tpo_correo_id']="";
		}
		$h=str_replace('http:/', 'http://', $input['plantilla']);
		$h=str_replace('&gt;', '>', $h);
		$input['plantilla']=$h;
		//dd($input);
		//update data
		if($input['inicio']=="" or $input['inicio']=="0000-00-00"){$input['inicio']=date('Y-m-d');}
		if($input['fin']=="" or $input['fin']=="0000-00-00"){$input['fin']=date('Y-m-d');}
		
		$plantilla=$plantilla->find($id);
                //dd($input);
		$plantilla->update( $input );

		//dd($input);
		if($st<>0){
			$plantilla->estatus()->attach($st);	
		}
		//dd($esp);
		/*if($esp<>0){
			$plantilla->especialidad()->attach($esp);	
		}*/
		
		//dd($input['plantilla']);
		/*$file = fopen(base_path('resources\views\emails\\'.$id.'.blade.php'), "w+");
		
		
		//dd($h);
		fwrite($file, $h);
		fclose($file);
*/
		return redirect()->route('plantillas.edit', $id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Plantilla $plantilla)
	{
		$plantilla=$plantilla->find($id);
		$plantilla->delete();

		return redirect()->route('plantillas.index')->with('message', 'Registro Borrado.');
	}


	public function eliminarEstatus(Request $request, Plantilla $p){
		$p=$p->find($_GET['plantilla']);
		//dd($p);
		$p->estatus()->detach($_GET['st']);
		return redirect()->route('plantillas.edit', $p->id)->with('message', 'Registro Actualizado.');
	}	
	public function eliminarEspecialidad(Request $request, Plantilla $p){
		$p=$p->find($_GET['plantilla']);
		//dd($p);
		$p->especialidad()->detach($_GET['esp']);
		return redirect()->route('plantillas.edit', $p->id)->with('message', 'Registro Actualizado.');
	}	
        
    public function cargaArchivoCorreo(Request $request) {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $r = Storage::disk('plantillas_correos')->put($nombre, \File::get($file));
        } else {

            return "no";
        }

        if ($r) {
            return $nombre;
        } else {
            return "Error vuelva a intentarlo";
        }
    }
    
    public function comprobarCantidad(Request $request){
        if($request->ajax()){
            $p=$request->all();
            $condiciones= PlanCondicionFiltro::where('plantilla_id', '=', $p['plantilla'])->get();
            $resultado=Cliente::join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
                               ->join('st_seguimientos as st', 'st.id', '=', 's.st_seguimiento_id')
                               ->join('combinacion_clientes as cc', 'cc.cliente_id', '=','clientes.id')
                               ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
                               ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
                               ->join('grados as g', 'e.id', '=', 'cc.grado_id');
            if($p['sms_bnd']==1){
                $resultado->where('clientes.celular_confirmado', "=", 1);
            }
            if($p['mail_bnd']==1){
                $resultado->where('clientes.correo_confirmado', "=", 1);
            }
            foreach($condiciones as $c){
                switch($c->campo->campo){
                    case 'Estatus':
                        if($c->operador_condicion=="and" or $c->operador_condicion=="Primera Condición"){
                            $resultado->where('st.id', $c->signo_comparacion, $c->valor_condicion);
                        }else{
                            $resultado->orWhere('st.id', $c->signo_comparacion, $c->valor_condicion);
                        }
                        
                        break;
                    case 'Plantel':
                        if($c->operador_condicion=="and" or $c->operador_condicion=="Primera Condición"){
                            $resultado->where('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                        }else{
                            $resultado->orWhere('cc.plantel_id', $c->signo_comparacion, $c->valor_condicion);
                        }
                        break;
                    case 'Especialidad':
                        if($c->operador_condicion=="and" or $c->operador_condicion=="Primera Condición"){
                            if($c->signo_comparacion=="like"){
                                $resultado->where('e.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->where('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }else{
                            if($c->signo_comparacion=="like"){
                                $resultado->orWhere('e.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->orWhere('cc.especialidad_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }
                                                
                        break;
                    case 'Nivel':
                        if($c->operador_condicion=="and" or $c->operador_condicion=="Primera Condición"){
                            if($c->signo_comparacion=="like"){
                                $resultado->where('n.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->where('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }else{
                            if($c->signo_comparacion=="like"){
                                $resultado->orWhere('n.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->orWhere('cc.nivel_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }
                        
                        break;
                    case 'Grado':
                        if($c->operador_condicion=="and" or $c->operador_condicion=="Primera Condición"){
                            if($c->signo_comparacion=="like"){
                                $resultado->where('g.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->where('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }else{
                            if($c->signo_comparacion=="like"){
                                $resultado->orWhere('g.name', $c->signo_comparacion, $c->interpretacion);
                            }else{
                                $resultado->orWhere('cc.grado_id', $c->signo_comparacion, $c->valor_condicion);
                            }
                        }
                        
                        break;
                } 
            }
            return $resultado->count();
            dd($resultado);
        }
        
    }
    
    public function crearCondicion(Request $request){
        if($request->ajax()){
            $p=$request->all();
            //dd($p);
            $condicion= new PlanCondicionFiltro();
            $condicion->plantilla_id=$p['plantilla'];
            $condicion->plan_campo_filtro_id=$p['campo'];
            $condicion->interpretacion=$p['interpretacion'];
            switch($p['operador_condicion']){
                case 0:
                    $condicion->operador_condicion='Primera Condición';
                    break;
                case 1:
                    $condicion->operador_condicion='and';
                    break;
                case 2:
                    $condicion->operador_condicion='or';
                    break;
            }
            switch($p['signo']){
                case 1:
                    $condicion->signo_comparacion='>=';
                    break;
                case 2:
                    $condicion->signo_comparacion='>';
                    break;
                case 3:
                    $condicion->signo_comparacion='=';
                    break;
                case 4:
                    $condicion->signo_comparacion='like';
                    break;
                case 5:
                    $condicion->signo_comparacion='<>';
                    break;
                case 6:
                    $condicion->signo_comparacion='<=';
                    break;
                case 7:
                    $condicion->signo_comparacion='<';
                    break;
            }
            $condicion->valor_condicion=$p['valor'];
            $condicion->usu_alta_id=1;
            $condicion->usu_mod_id=1;
            $condicion->save();
            $todas=0;
            if(isset($p['todas_condiciones'])){
                if($p['todas_condiciones']==1){
                    switch($p['campo']){
                        case 3:
                            $condicion2= new PlanCondicionFiltro();
                            $condicion2->plantilla_id=$p['plantilla'];
                            $condicion2->operador_condicion='and';
                            $condicion2->plan_campo_filtro_id=2;
                            $condicion2->interpretacion=$p['interpretacion_plantel'];
                            $condicion2->signo_comparacion='=';
                            $condicion2->valor_condicion=$p['valor_plantel'];
                            $condicion2->usu_alta_id=1;
                            $condicion2->usu_mod_id=1;
                            $condicion2->save();
                            break;
                        case 4:
                            $condicion2= new PlanCondicionFiltro();
                            $condicion2->plantilla_id=$p['plantilla'];
                            $condicion2->operador_condicion='and';
                            $condicion2->plan_campo_filtro_id=2;
                            $condicion2->interpretacion=$p['interpretacion_plantel'];
                            $condicion2->signo_comparacion='=';
                            $condicion2->valor_condicion=$p['valor_plantel'];
                            $condicion2->usu_alta_id=1;
                            $condicion2->usu_mod_id=1;
                            $condicion2->save();
                            $condicion3= new PlanCondicionFiltro();
                            $condicion3->plantilla_id=$p['plantilla'];
                            $condicion3->operador_condicion='and';
                            $condicion3->plan_campo_filtro_id=3;
                            $condicion3->interpretacion=$p['interpretacion_especialidad'];
                            $condicion3->signo_comparacion='=';
                            $condicion3->valor_condicion=$p['valor_especialidad'];
                            $condicion3->usu_alta_id=1;
                            $condicion3->usu_mod_id=1;
                            $condicion3->save();
                            break;
                        case 5:
                            $condicion2= new PlanCondicionFiltro();
                            $condicion2->plantilla_id=$p['plantilla'];
                            $condicion2->operador_condicion='and';
                            $condicion2->plan_campo_filtro_id=2;
                            $condicion2->interpretacion=$p['interpretacion_plantel'];
                            $condicion2->signo_comparacion='=';
                            $condicion2->valor_condicion=$p['valor_plantel'];
                            $condicion2->usu_alta_id=1;
                            $condicion2->usu_mod_id=1;
                            $condicion2->save();
                            $condicion3= new PlanCondicionFiltro();
                            $condicion3->plantilla_id=$p['plantilla'];
                            $condicion3->operador_condicion='and';
                            $condicion3->plan_campo_filtro_id=3;
                            $condicion3->interpretacion=$p['interpretacion_especialidad'];
                            $condicion3->signo_comparacion='=';
                            $condicion3->valor_condicion=$p['valor_especialidad'];
                            $condicion3->usu_alta_id=1;
                            $condicion3->usu_mod_id=1;
                            $condicion3->save();
                            $condicion4= new PlanCondicionFiltro();
                            $condicion4->operador_condicion='and';
                            $condicion4->plantilla_id=$p['plantilla'];
                            $condicion4->plan_campo_filtro_id=4;
                            $condicion4->interpretacion=$p['interpretacion_nivel'];
                            $condicion4->signo_comparacion='=';
                            $condicion4->valor_condicion=$p['valor_nivel'];
                            $condicion4->usu_alta_id=1;
                            $condicion4->usu_mod_id=1;
                            $condicion4->save();
                            break;

                    }
                }
            }
            
            
            
        }
    }
}
