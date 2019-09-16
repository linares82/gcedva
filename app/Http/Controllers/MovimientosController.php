<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Existencium;
use App\Movimiento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMovimiento;
use App\Http\Requests\createMovimiento;

class MovimientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$movimientos = Movimiento::getAllData($request);

		return view('movimientos.index', compact('movimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('movimientos.create')
			->with( 'list', Movimiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMovimiento $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Movimiento::create( $input );
                
                $this->actualizarExistencia($input['plantel_id'],$input['articulo_id'],
                                           $input['cantidad'],$input['entrada_salida_id']);

		return redirect()->route('movimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Movimiento $movimiento)
	{
		$movimiento=$movimiento->find($id);
		return view('movimientos.show', compact('movimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Movimiento $movimiento)
	{
		$movimiento=$movimiento->find($id);
		return view('movimientos.edit', compact('movimiento'))
			->with( 'list', Movimiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Movimiento $movimiento)
	{
		$movimiento=$movimiento->find($id);
		return view('movimientos.duplicate', compact('movimiento'))
			->with( 'list', Movimiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Movimiento $movimiento, updateMovimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$movimiento=$movimiento->find($id);
		$movimiento->update( $input );

		return redirect()->route('movimientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Movimiento $movimiento)
	{
		$movimiento=$movimiento->find($id);
                
                $this->actualizarExistencia($movimiento->plantel_id, $movimiento->articulo_id,
                                           $movimiento->cantidad, 2);
                
		$movimiento->delete();

		return redirect()->route('movimientos.index')->with('message', 'Registro Borrado.');
	}

        public function actualizarExistencia($plantel, $articulo, $existencia, $es){
            $existencium=Existencium::where('plantel_id',$plantel)->where('articulo_id',$articulo)->first();
            if(count($existencium)>0){
                if($es==1){
                    $existencium->existencia=$existencium->existencia+$existencia;
                }else{
                    $existencium->existencia=$existencium->existencia-$existencia;
                }
                $existencium->save();
            }else{
                $e['plantel_id']=$plantel;
                $e['articulo_id']=$articulo;
                $e['existencia']=$existencia;
                $e['usu_mod_id']=Auth::user()->id;
                $e['usu_alta_id']=Auth::user()->id;
                Existencia::create($e);
            }
        }
}
