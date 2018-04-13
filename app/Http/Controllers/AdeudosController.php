<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Adeudo;
use App\Cliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAdeudo;
use App\Http\Requests\createAdeudo;
use PDF;

class AdeudosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$adeudos = Adeudo::getAllData($request);

		return view('adeudos.index', compact('adeudos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('adeudos.create')
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAdeudo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Adeudo::create( $input );

		return redirect()->route('adeudos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.show', compact('adeudo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.edit', compact('adeudo'))
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		return view('adeudos.duplicate', compact('adeudo'))
			->with( 'list', Adeudo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Adeudo $adeudo, updateAdeudo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$adeudo=$adeudo->find($id);
		$adeudo->update( $input );

		return redirect()->route('adeudos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Adeudo $adeudo)
	{
		$adeudo=$adeudo->find($id);
		$adeudo->delete();

		return redirect()->route('adeudos.index')->with('message', 'Registro Borrado.');
	}
        
        public function imprimirInicial(Request $request){
            $data=$request->all();
            $cliente=Cliente::find($data['cliente']);
            if($cliente->cuenta_ticket_pago==0){
                foreach($cliente->planPago->Lineas as $adeudo){
                    $registro['cliente_id']=$cliente->id;
                    $registro['caja_concepto_id']=$adeudo->caja_concepto_id;
                    $registro['cuenta_contable_id']=$adeudo->cuenta_contable_id;
                    $registro['cuenta_recargo_id']=$adeudo->cuenta_recargo_id;
                    $registro['fecha_pago']=$adeudo->fecha_pago;
                    $registro['monto']=$adeudo->monto;
                    $registro['inicial_bnd']=$adeudo->inicial_bnd;
                    $registro['pagado_bnd']=0;
                    $registro['plan_pago_ln_id']=$adeudo->id;
                    $registro['usu_alta_id']=Auth::user()->id;
                    $registro['usu_mod_id']=Auth::user()->id;
                    //dd($registro);
                    Adeudo::create( $registro );
                }
            }
            $cliente->cuenta_ticket_pago=$cliente->cuenta_ticket_pago+1;
            $cliente->save();
            
            $adeudo=Adeudo::where('cliente_id', '=', $cliente->id)->get();
            return view('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente));
            /*PDF::setOptions(['defaultFont' => 'arial']);
            $pdf = PDF::loadView('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente))
                    ->setPaper('A8', 'portrait');
            return $pdf->download('reporte.pdf');*/
        }

}
