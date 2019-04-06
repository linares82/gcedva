<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CotizacionCurso;
use App\CotizacionLn;
use App\CursosEmpresa;
use App\Param;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCotizacionLn;
use App\Http\Requests\createCotizacionLn;

class CotizacionLnsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cotizacionLns = CotizacionLn::getAllData($request);

		return view('cotizacionLns.index', compact('cotizacionLns'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cotizacionLns.create')
			->with( 'list', CotizacionLn::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCotizacionLn $request)
	{

		$input = $request->all();
                //dd($input);
                $cantidad_lineas=CotizacionLn::where('cotizacion_curso_id',$input['cotizacion_curso_id'])->count();
                $curso=CursosEmpresa::find($input['cursos_empresa_id']);
                $input['consecutivo']=$cantidad_lineas+1;
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                
                switch($input['tipo_precio_coti_id']){
                    case 1:
                        $input['precio']=$curso->precio_persona;
                        break;
                    case 2:
                        $input['precio']=$curso->precio_en_linea;
                        break;
                    case 3:
                        $input['precio']=$curso->precio_demo;
                        break;
                }
                $input['total']=($input['precio']*$input['cantidad']);
                    
		//create data
		CotizacionLn::create( $input );
                $this->calcularTotales($input['cotizacion_curso_id']);
		//return redirect()->route('cotizacionLns.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CotizacionLn $cotizacionLn)
	{
		$cotizacionLn=$cotizacionLn->find($id);
		return view('cotizacionLns.show', compact('cotizacionLn'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CotizacionLn $cotizacionLn)
	{
		$cotizacionLn=$cotizacionLn->find($id);
		return view('cotizacionLns.edit', compact('cotizacionLn'))
			->with( 'list', CotizacionLn::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CotizacionLn $cotizacionLn)
	{
		$cotizacionLn=$cotizacionLn->find($id);
		return view('cotizacionLns.duplicate', compact('cotizacionLn'))
			->with( 'list', CotizacionLn::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CotizacionLn $cotizacionLn, updateCotizacionLn $request)
	{
		$input = $request->all();
                //dd($input);
                
                
		$input['usu_mod_id']=Auth::user()->id;
                
		//update data
		$cotizacionLn=$cotizacionLn->find($id);
                $curso=CursosEmpresa::find($cotizacionLn->cursos_empresa_id);
                switch($input['tipo_precio_coti_id']){
                    case 1:
                        $input['precio']=$curso->precio_persona;
                        break;
                    case 2:
                        $input['precio']=$curso->precio_en_linea;
                        break;
                    case 3:
                        $input['precio']=$curso->precio_demo;
                        break;
                }
                
                $input['total']=($input['precio']*$input['cantidad']);
		$cotizacionLn->update( $input );
                $this->calcularTotales($cotizacionLn->cotizacion_curso_id);
		//return redirect()->route('cotizacionLns.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Request $request,CotizacionLn $cotizacionLn)
	{
            $datos=$request->all();
            //dd($datos);
		$cotizacionLn=$cotizacionLn->find($id);
		$cotizacionLn->delete();
                $this->calcularTotales($cotizacionLn->cotizacion_curso_id);
		return redirect()->route('cotizacionCursos.cotizacionesEmpresa',array('empresa'=>$cotizacionLn->cotizacionCurso->empresa_id))->with('message', 'Registro Borrado.');
	}

        public function getByCotizacionCursoId(Request $request){
            $datos=$request->all();
            $lineas=CotizacionLn::select('cotizacion_lns.id','cotizacion_lns.cotizacion_curso_id','consecutivo','st.name as estatus','cotizacion_lns.st_curso_empresa_id','ce.name as curso',
                                         'cotizacion_lns.cursos_empresa_id','tp.name as tipo_precio','tipo_precio_coti_id','cotizacion_lns.cantidad',
                                          'cotizacion_lns.precio','cotizacion_lns.total','cotizacion_lns.descuento')
                                 ->join('cursos_empresas as ce','ce.id','=','cotizacion_lns.cursos_empresa_id')
                                 ->join('st_curso_empresas as st','st.id','=','cotizacion_lns.st_curso_empresa_id')
                                 ->join('tipo_precio_cotis as tp','tp.id','=','cotizacion_lns.tipo_precio_coti_id')
                                 ->where('cotizacion_curso_id', $datos['cotizacion_curso'])->get();
            //dd($lineas->toArray());
            echo $lineas->toJson();
        }
        
        public function calcularTotales($cotizacion){
            $iva=Param::where('llave','iva')->first();
            $lineas=CotizacionLn::where('cotizacion_curso_id',$cotizacion)->where('st_curso_empresa_id',3)->get();
            $cotizacion= CotizacionCurso::find($cotizacion);
            
            $subtotal=0;
            $descuento=0;
            foreach($lineas as $linea){
                $subtotal=$subtotal+$linea->total;
                $descuento=$descuento+($linea->total*$linea->descuento);
            }
            $cotizacion->subtotal=$subtotal;
            $cotizacion->descuento=$descuento;
            $cotizacion->iva=($cotizacion->subtotal-$cotizacion->descuento)*$iva->valor;
            $cotizacion->total=$cotizacion->subtotal-$cotizacion->descuento+$cotizacion->iva;
            $cotizacion->save();
            
        }
}
