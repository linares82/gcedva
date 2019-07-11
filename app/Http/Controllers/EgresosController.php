<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentasEfectivo;
use App\Egreso;
use App\IngresoEgreso;
use App\Plantel;
use App\Pago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEgreso;
use App\Http\Requests\createEgreso;
use File as Archi;

class EgresosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$egresos = Egreso::getAllData($request);

		return view('egresos.index', compact('egresos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('egresos.create')
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEgreso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		$r=$request->hasFile('comprobante_file');
		if($r){
			$comprobante_file = $request->file('comprobante_file');
			$input['archivo'] = $comprobante_file->getClientOriginalName();
		}
                
		//create data
		$e=Egreso::create( $input );
                if($e){
                    $ruta=public_path()."/imagenes/egresos/".$e->id."/";
			if(!file_exists($ruta)){
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if($request->file('comprobante_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('comprobante_file')->move($ruta, $input['archivo']);
			}
                }

		return redirect()->route('egresos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.show', compact('egreso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.edit', compact('egreso'))
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		return view('egresos.duplicate', compact('egreso'))
			->with( 'list', Egreso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Egreso $egreso, updateEgreso $request)
	{
		$input = $request->all();
                //dd($request->all());
		$input['usu_mod_id']=Auth::user()->id;
                
                $r=$request->hasFile('comprobante_file');
		if($r){
			$comprobante_file = $request->file('comprobante_file');
			$input['archivo'] = $comprobante_file->getClientOriginalName();
		}
                
		//update data
		$egreso=$egreso->find($id);
		$e=$egreso->update( $input );
                
                if($e){
                    $ruta=public_path()."/imagenes/egresos/".$egreso->id."/";
			if(!file_exists($ruta)){
				Archi::makedirectory($ruta, 0777, true, true);
			}
			if($request->file('comprobante_file')){
				//Storage::disk('img_plantels')->put($input['logo'],  File::get($logo_file));
				$request->file('comprobante_file')->move($ruta, $input['archivo']);
			}
                }

		return redirect()->route('egresos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Egreso $egreso)
	{
		$egreso=$egreso->find($id);
		$egreso->delete();

		return redirect()->route('egresos.index')->with('message', 'Registro Borrado.');
	}

        public function egresosIngresos(){
            $plantels=Plantel::pluck('razon','id');
            return view('egresos.reportes.ingresosEgresos', array('plantels'=>$plantels));
        }
        
        public function egresosIngresosR(Request $request){
            $datos=$request->all();
            
            $registros= IngresoEgreso::select('ce.id','ce.name as cuenta','ce.saldo_inicial','ce.fecha_saldo_inicial','ce.saldo_actualizado',
                                              'ingreso_egresos.consecutivo_caja','ingreso_egresos.egreso_id','ingreso_egresos.fecha',
                                              'p.razon','ingreso_egresos.monto','ingreso_egresos.concepto','ingreso_egresos.transference_id')
                                       ->join('cuentas_efectivos as ce','ce.id','=','ingreso_egresos.cuenta_efectivo_id')
                                       ->join('plantels as p','p.id','=','ingreso_egresos.plantel_id')
                                       ->whereIn('p.id',$datos['plantel_f'])
                                       //->where('p.id','<=',$datos['plantel_t'])
                                       ->where('ingreso_egresos.cuenta_efectivo_id','>',0)
                                       ->whereNull('ingreso_egresos.deleted_at')
                                       ->whereDate('ingreso_egresos.fecha','>=',$datos['fecha_f'])
                                       ->whereDate('ingreso_egresos.fecha','<=',$datos['fecha_t'])
                                       ->orderBy('ce.id')
                                       ->orderBy('p.id')
                                       ->orderBy('ingreso_egresos.fecha')
                                       ->get();
            
            //dd($registros->ToArray());
            
            return view('egresos.reportes.ingresosEgresosR', array('registros'=>$registros));
        }
        
        public function recibo(Request $request){
            $datos=$request->all();
            //dd($datos);
            $egreso=Egreso::find($datos['egreso']);
            /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
			->with( 'list', Inscripcion::getListFromAllRelationApps() );
                 * */
                
/*                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
  */              
                return view('egresos.reportes.recibo', array('egreso'=>$egreso));
        }
}
