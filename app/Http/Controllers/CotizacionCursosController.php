<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CotizacionCurso;
use App\CotizacionLn;
use App\Empresa;
use App\FacturaCotizacion;
use App\Plantel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCotizacionCurso;
use App\Http\Requests\createCotizacionCurso;
use PDF;
class CotizacionCursosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cotizacionCursos = CotizacionCurso::getAllData($request);

		return view('cotizacionCursos.index', compact('cotizacionCursos'));
	}
        
        public function cotizacionesEmpresa(Request $request)
	{
		$cotizacionCursos = CotizacionCurso::where('empresa_id', $request->input('empresa'))->paginate(25);
                $empresa=$request->input('empresa');
                
		return view('cotizacionCursos.cotizacionesEmpresa', compact('cotizacionCursos', 'empresa'))
                            ->with( 'list', CotizacionLn::getListFromAllRelationApps() )
                            ->with( 'list2', FacturaCotizacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
                $datos=$request->all();                
                
                $empresa=Empresa::find($datos['empresa']);
                //dd($empresa);
		return view('cotizacionCursos.create', compact('empresa'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCotizacionCurso $request)
	{
            $empresa=Empresa::find($request->input('empresa_id'));
            //dd($empresa);
            $plantel=Plantel::find($empresa->plantel_id);
            $plantel->csc_cotizacion=$plantel->csc_cotizacion+1;
            $plantel->save();
            
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
                $input['no_coti']=$plantel->csc_cotizacion;
                $input['st_curso_empresa_id']=1;
                
		//create data
                //dd($request->all());
		$coti=CotizacionCurso::create( $input );

		return redirect()->route('cotizacionCursos.cotizacionesEmpresa', array('empresa'=>$empresa->id))->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CotizacionCurso $cotizacionCurso)
	{
		$cotizacionCurso=$cotizacionCurso->find($id);
		return view('cotizacionCursos.show', compact('cotizacionCurso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CotizacionCurso $cotizacionCurso)
	{
		$cotizacionCurso=$cotizacionCurso->find($id);
                $empresa=Empresa::find($cotizacionCurso->empresa_id);
		return view('cotizacionCursos.edit', compact('cotizacionCurso','empresa'));
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CotizacionCurso $cotizacionCurso)
	{
		$cotizacionCurso=$cotizacionCurso->find($id);
		return view('cotizacionCursos.duplicate', compact('cotizacionCurso'))
			->with( 'list', CotizacionCurso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CotizacionCurso $cotizacionCurso, updateCotizacionCurso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cotizacionCurso=$cotizacionCurso->find($id);
		$cotizacionCurso->update( $input );

		//return redirect()->route('cotizacionCursos.index')->with('message', 'Registro Actualizado.');
                return redirect()->route('cotizacionCursos.cotizacionesEmpresa', array('empresa'=>$cotizacionCurso->empresa_id))->with('message', 'Registro Creado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CotizacionCurso $cotizacionCurso)
	{
		$cotizacionCurso=$cotizacionCurso->find($id);
		$cotizacionCurso->delete();

		return redirect()->route('cotizacionCursos.index')->with('message', 'Registro Borrado.');
	}
        
        public function cancelar($id,CotizacionCurso $cotizacionCurso){
                $cotizacionCurso=$cotizacionCurso->find($id);
                $cotizacionCurso->st_curso_empresa_id=4;
                $cotizacionCurso->save();
                return redirect()->route('cotizacionCursos.cotizacionesEmpresa', array('empresa'=>$cotizacionCurso->empresa_id))->with('message', 'Registro Creado.');
        }

        public function verCotizacion(Request $request ){
            
            $datos=$request->all();
            //dd($datos);
            
            $cotizacion=CotizacionCurso::find($datos['cotizacion']);
            $plantel=$cotizacion->empresa->plantel;
            if($datos['vista']==1){
                return view('cotizacionCursos.reportes.cotizacion', array('cotizacion'=>$cotizacion,
                                                                          'plantel'=>$plantel));
            
            /*
            PDF::setOptions(['defaultFont' => 'arial']);
            $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                    ->setPaper('legal', 'landscape');
            return $pdf->download('reporte.pdf');
             * */
            }else{
                return view('cotizacionCursos.reportes.cotizacion2', array('cotizacion'=>$cotizacion,
                                                                          'plantel'=>$plantel));
            }
            
             
        }
        
        public function verCotizacionPdf(Request $request){
            $datos=$request->all();
            //dd($datos);
            
            $cotizacion=CotizacionCurso::find($datos['cotizacion']);
            $plantel=$cotizacion->empresa->plantel;
            
            
            if($datos['vista']==1){
                /*return view('cotizacionCursos.reportes.cotizacion', array('cotizacion'=>$cotizacion,
                                                                          'plantel'=>$plantel));
            */
                PDF::setOptions(['defaultFont' => 'arial']);
            $pdf = PDF::loadView('cotizacionCursos.reportes.cotizacion', array('cotizacion'=>$cotizacion,
                                                                          'plantel'=>$plantel))
                    ->setPaper('letter', 'portrait');
            return $pdf->download('reporte.pdf');
            }else{
                PDF::setOptions(['defaultFont' => 'arial']);
            $pdf = PDF::loadView('cotizacionCursos.reportes.cotizacion2', array('cotizacion'=>$cotizacion,
                                                                          'plantel'=>$plantel))
                    ->setPaper('letter', 'portrait');
            return $pdf->download('reporte.pdf');
            }
            
            
        }
        
        
}
