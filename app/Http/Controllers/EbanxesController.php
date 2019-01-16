<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ebanx;
use App\Cliente;
use App\Empleado;
use App\Param;
use App\Paise;
use App\Grado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEbanx;
use App\Http\Requests\createEbanx;
use Log;

class EbanxesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ebanxes = Ebanx::getAllData($request);

		return view('ebanxes.index', compact('ebanxes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ebanxes.create')
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEbanx $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Ebanx::create( $input );

		return redirect()->route('ebanxes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.show', compact('ebanx'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.edit', compact('ebanx'))
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		return view('ebanxes.duplicate', compact('ebanx'))
			->with( 'list', Ebanx::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Ebanx $ebanx, updateEbanx $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ebanx=$ebanx->find($id);
		$ebanx->update( $input );

		return redirect()->route('ebanxes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
		$ebanx->delete();

		return redirect()->route('ebanxes.index')->with('message', 'Registro Borrado.');
	}

        public function pagar($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
                $ebanx->bnd_pagado=1;
                $ebanx->fecha_pago=date('Y-m-d');
                $ebanx->save();
                
		return redirect()->route('ebanxes.index')->with('message', 'Registro Actualizado.');
	}
        
        public function procesar($id, Ebanx $ebanx)
	{
		$ebanx=$ebanx->find($id);
                //dd($ebanx);
                if($ebanx->bnd_pagado==1 and $ebanx->bnd_procesado==0){
                    
                    $cliente['nombre']=$ebanx->nombre;
                    $cliente['nombre2']=$ebanx->nombre2;
                    $cliente['ape_paterno']=$ebanx->ape_paterno;
                    $cliente['ape_materno']=$ebanx->ape_materno;
                    $cliente['tel_fijo']=$ebanx->tel_fijo;
                    $cliente['mail']=$ebanx->mail;
                    $cliente['plantel_id']=$ebanx->plantel_id;
                    $cliente['medio_id']=$ebanx->medio_id;
                    $cliente['empleado_id']=$ebanx->empleado_id;
                    $cliente['observaciones']=$ebanx->observaciones;
                    $cliente['estado_id']=$ebanx->estado_id;
                    $cliente['municipio_id']=$ebanx->municipio_id;
                    $cliente['st_cliente_id']=$ebanx->st_cliente_id;
                    $cliente['especialidad_id']=$ebanx->especialidad_id;
                    $cliente['especialidad2_id']=$ebanx->especialidad2_id;
                    $cliente['especialidad3_id']=$ebanx->especialidad3_id;
                    $cliente['especialidad4_id']=$ebanx->especialidad4_id;
                    $cliente['nivel_id']=$ebanx->nivel_id;
                    $cliente['diplomado_id']=$ebanx->diplomado_id;
                    $cliente['curso_id']=$ebanx->curso_id;
                    $cliente['otro_id']=$ebanx->otro_id;
                    $cliente['grado_id']=$ebanx->grado_id;
                    $cliente['subdiplomado_id']=$ebanx->subdiplomado_id;
                    $cliente['subcurso_id']=$ebanx->subcurso_id;
                    $cliente['subotro_id']=$ebanx->subotro_id;
                    $cliente['turno_id']=$ebanx->turno_id;
                    $cliente['turno2_id']=$ebanx->turno2_id;
                    $cliente['turno3_id']=$ebanx->turno3_id;
                    $cliente['turno4_id']=$ebanx->turno4_id;
                    $cliente['ofertum_id']=$ebanx->ofertum_id;
                    $cliente['matricula']=$ebanx->matricula;
                    $cliente['ciclo_id']=$ebanx->ciclo_id;
                    $cliente['empresa_id']=$ebanx->empresa_id;
                    $cliente['cve_cliente']=$ebanx->cve_cliente;
                    $cliente['tel_cel']=$ebanx->tel_cel;
                    $cliente['paise_id']=$ebanx->paise_id;
                    $cliente['usu_alta_id']=Auth::user()->id;
                    $cliente['usu_mod_id']=Auth::user()->id;
                    
                    $c=Cliente::create( $cliente );
                    
                    $ebanx->bnd_procesado=1;
                    $ebanx->cliente_id=$c->id;
                    $ebanx->fecha_procesado=date('Y-m-d');
                    $ebanx->save();
                }
                
		return redirect()->route('ebanxes.index')->with('message', 'Registro Actualizado.');
	}
        
    public function notificacion(){
        $hashes=$_REQUEST['hash_codes'];
        $es_arreglo=is_array($hashes);
        if($es_arreglo){
            foreach($hashes as $hash){
                $registro= Ebanx::where('hash',$hash)->firts();
                if($registro->count>1){
                    //https://api.ebanxpay.com/ws/query?integration_key=YOUR_KEY&hash=1998bff11bf7b3185e8f2af113ee3fb1fa4c9
                    //https://api.ebanxpay.com/ws/query
                }
            }
        }else{

        }
        http_response_code(200);
    }
    
    public function paisesWeb(){
        $paises=Paise::select('id', 'name as pais')->where('marcado',"<>","")->get();
        echo json_encode($paises, JSON_UNESCAPED_UNICODE);
    }
    
    public function ofertaEmm(){
        $plantel=14;
        $especialidad=69;
        $nivel=97;
        $oferta=Grado::select('grados.id','grados.name as oferta')
                     ->join('especialidads as e','e.id','=','grados.especialidad_id')
                     ->where('grados.plantel_id','=',$plantel)
                     ->where('e.id','=',$especialidad)
                     ->where('grados.nivel_id','=',$nivel)
                     ->where('grados.id','>',0)
                     ->get();
        echo json_encode($oferta,JSON_UNESCAPED_UNICODE);
    }
    
    public function ofertaCedva(){
        $plantel=14;
        $especialidad=70;
        $nivel=96;
        $oferta=Grado::select('grados.id','grados.name as oferta')
                     ->join('especialidads as e','e.id','=','grados.especialidad_id')
                     ->where('grados.plantel_id','=',$plantel)
                     ->where('e.id','=',$especialidad)
                     ->where('grados.nivel_id','=',$nivel)
                     ->where('grados.id','>',0)
                     ->get();
        echo json_encode($oferta,JSON_UNESCAPED_UNICODE);
    }
    
    public function cargaCliente(Request $request){
        $input=$request->all();
        //dd($input);
        try {
            $token_base=Param::where('llave','=','token_app_cel')->first();
            Log::info('flc');
            Log::info(array_key_exists('nombre', $input));
            
            if($request->input('token')<>$token_base->valor or
            !array_key_exists('nombre', $input) or
                   !array_key_exists('tel_cel', $input) or 
                   !array_key_exists('mail', $input) or 
                   !array_key_exists('grado_id', $input) or
                   !array_key_exists('paise_id', $input) or
                   !array_key_exists('fuente', $input)){
                app('debugbar')->disable();
                echo json_encode(array('msj'=>'Token no existe o falta un valor obligatorio'));
            }else{
                $fuente=$request->input('fuente');
                $plantel=0;
                $especialidad=0;
                $nivel=0;
                if($fuente=="emm"){
                    $plantel=14;
                    $especialidad=69;
                    $nivel=97;
                }elseif($fuente=="cedva"){
                    $plantel=14;
                    $especialidad=70;
                    $nivel=96;
                }

                $medio=7;
                $st_cliente=1;
                $cve='Codigo: ' . substr(md5(rand(0, 1000)), 2, 8) . ". Grupo JESADI, te da la bienvenida y te felicita por dar el primer paso hacia tu futuro. Revisa tu correo y conoce los beneficios.";
                $empleado=0;/*Empleado::where('plantel_id','=',$plantel)
                                  ->whereIn('st_empleado_id', ['1','9'])
                                  ->first();*/
                $nombre2="";
                $ape_paterno="";
                $ape_materno="";
                $tel_fijo="";
                $paise_id=0;
                if(isset($input->nombre2)){
                    $nombre2=$input->nombre2;
                }
                if(isset($input->ape_paterno)){
                    $ape_paterno=$request->input('ape_paterno');
                }
                if(isset($input->ape_materno)){
                    $ape_materno=$request->input('ape_materno');
                }
                if(isset($input->tel_fijo)){
                    $tel_fijo=$request->input('tel_fijo');
                }
                if(isset($input->paise_id)){
                    $paise_id=$request->input('paise_id');
                }
                
                $cliente['nombre']=$request->input('nombre');
                $cliente['nombre2']=$nombre2;
                $cliente['ape_paterno']=$ape_paterno;
                $cliente['ape_materno']=$ape_materno;
                $cliente['tel_fijo']=$tel_fijo;
                $cliente['tel_cel']=$request->input('tel_cel');
                $cliente['mail']=$request->input('mail');
                $cliente['plantel_id']=$plantel;
                $cliente['medio_id']=$medio;
                $cliente['empleado_id']=$empleado;
                $cliente['observaciones']='';
                $cliente['paise_id']=$paise_id;
                $cliente['estado_id']=0;
                $cliente['municipio_id']=0;
                $cliente['st_cliente_id']=$st_cliente;
                $cliente['especialidad_id']=$especialidad;
                $cliente['especialidad2_id']=0;
                $cliente['especialidad3_id']=0;
                $cliente['especialidad4_id']=0;
                $cliente['nivel_id']=$nivel;
                $cliente['diplomado_id']=0;
                $cliente['curso_id']=0;
                $cliente['otro_id']=0;
                $cliente['grado_id']=$request->input('grado_id');
                $cliente['subdiplomado_id']=0;
                $cliente['subcurso_id']=0;
                $cliente['subotro_id']=0;
                $cliente['turno_id']=0;
                $cliente['turno2_id']=0;
                $cliente['turno3_id']=0;
                $cliente['turno4_id']=0;
                $cliente['ofertum_id']=0;
                $cliente['matricula']="";
                $cliente['ciclo_id']=0;
                $cliente['empresa_id']=0;
                $cliente['cve_cliente']=$cve;
                $cliente['usu_alta_id']=1;
                $cliente['usu_mod_id']=1;

                $c=Cliente::create( $cliente );

                if(isset($c->id) and $c->id>0){
                    app('debugbar')->disable();
                    echo json_encode(array('id'=>$c->id));
                }
            }
            
        }catch (Exception $exception) {
            Log::info('android');
            Log::info($exception);
        }
        
    }
    
    public function cmbOfertaEmm(Request $request){
		$plantel=14;
                $especialidad=69;
                $nivel=97;
                //dd($nivel);
                //if($request->ajax()){
			//dd($request->get('plantel_id'));
                    $pais=$request->input('pais');
                    //dd($pais);
                    $r=Grado::select('grados.id','grados.name as oferta')
                        ->join('especialidads as e','e.id','=','grados.especialidad_id')
                        ->where('grados.plantel_id','=',$plantel)
                        ->where('e.id','=',$especialidad)
                        ->where('grados.nivel_id','=',$nivel)
                        ->where('grados.id','>',0);
                    if($pais==22){
                        $r->where('grados.mexico_bnd','=',1);
                    }else{
                        $r->where('grados.mexico_bnd','<>',1);
                    }
                    $r->get();
                    
                    $final = array();
			
                    foreach($r as $r1){
                        array_push($final, array('id'=>$r1->id, 'oferta'=>$r1->oferta));        
                    }
                    app('debugbar')->disable();
                    echo json_encode($final);

		//}
	}
        
        public function cmbOfertaCedva(Request $request){
		$plantel=14;
                $especialidad=70;
                $nivel=96;
                //dd($nivel);
                //if($request->ajax()){
			//dd($request->get('plantel_id'));
                    $pais=$request->input('pais');
                    //dd($pais);
                    $r=Grado::select('grados.id','grados.name as oferta')
                        ->join('especialidads as e','e.id','=','grados.especialidad_id')
                        ->where('grados.plantel_id','=',$plantel)
                        ->where('e.id','=',$especialidad)
                        ->where('grados.nivel_id','=',$nivel)
                        ->where('grados.id','>',0);
                    if($pais==22){
                        $r->where('grados.mexico_bnd','=',1);
                    }else{
                        $r->where('grados.mexico_bnd','<>',1);
                    }
                    $r->get();
                    
                    $final = array();
			
                    foreach($r as $r1){
                        array_push($final, array('id'=>$r1->id, 'oferta'=>$r1->oferta));        
                    }
                    app('debugbar')->disable();
                    echo json_encode($final);

		//}
	}
}
