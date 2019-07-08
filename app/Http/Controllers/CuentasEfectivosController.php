<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentasEfectivo;
use App\Plantel;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentasEfectivo;
use App\Http\Requests\createCuentasEfectivo;
use DB;

class CuentasEfectivosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentasEfectivos = CuentasEfectivo::getAllData($request);
                
		return view('cuentasEfectivos.index', compact('cuentasEfectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $plantels=Plantel::pluck('razon','id');
                $plantels_selected=array();
		return view('cuentasEfectivos.create', compact('plantels','plantels_selected'))
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentasEfectivo $request)
	{

		$input = $request->except('plantel_id');
                $plantels=$request->only('plantel_id');
               
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$cuentasEfectivo=CuentasEfectivo::create( $input );
                
                $cuentasEfectivo->plantels()->sync($plantels['plantel_id']);

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
                
		return view('cuentasEfectivos.show', compact('cuentasEfectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
                //dd($cuentasEfectivo->plantels->toArray());
                $plantels=Plantel::pluck('razon','id');
                //dd($plantels);
                $selected=$cuentasEfectivo->plantels;
                $plantels_selected=collect();
                foreach($selected as $ps){
                    $plantels_selected->prepend($ps->id);
                }
                //  dd(optional($plantels_selected)->search(4));
		return view('cuentasEfectivos.edit', compact('cuentasEfectivo','plantels','plantels_selected'))
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		return view('cuentasEfectivos.duplicate', compact('cuentasEfectivo'))
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentasEfectivo $cuentasEfectivo, updateCuentasEfectivo $request)
	{
		$input = $request->except('plantel_id');
		$input['usu_mod_id']=Auth::user()->id;
                $plantels=$request->only('plantel_id');
                
                
		//update data
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		$cuentasEfectivo->update( $input );
                //dd($plantels['plantel_id']);
                $cuentasEfectivo->plantels()->sync($plantels['plantel_id']);

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		$cuentasEfectivo->delete();

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Borrado.');
	}

        public function getCuentasPlantel(Request $request)
        {
            if($request->ajax()){
                $data=$request->all();
                $plantel=$data['plantel'];
                
                $final = array();
                $r = DB::table('cuentas_efectivos as ce')
                                ->select('ce.id', 'ce.name')
                                ->join('cuentas_efectivo_plantels as cep','cep.cuentas_efectivo_id','=','ce.id')
                                ->where('cep.plantel_id', '=', $plantel)
                                ->where('ce.id', '>', '0')
                                ->get();
                
                return $r;
                
            }
        }
        
        public function getSaldo(Request $request){
            if($request->ajax()){
                $data=$request->all();
                //dd($data);
                $saldo= CuentasEfectivo::find($data['cuenta']);
                return $saldo->saldo_actualizado;
            }
        }
}
