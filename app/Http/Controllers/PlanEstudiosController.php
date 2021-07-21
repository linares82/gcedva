<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlanEstudio;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests\updatePlanEstudio;
use App\Http\Requests\createPlanEstudio;

class PlanEstudiosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$planEstudios = PlanEstudio::getAllData($request);
		
		return view('planEstudios.index', compact('planEstudios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('planEstudios.create')
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlanEstudio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlanEstudio::create( $input );

		return redirect()->route('planEstudios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.show', compact('planEstudio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.edit', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		return view('planEstudios.duplicate', compact('planEstudio'))
			->with( 'list', PlanEstudio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlanEstudio $planEstudio, updatePlanEstudio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$planEstudio=$planEstudio->find($id);
		$planEstudio->update( $input );

		return redirect()->route('planEstudios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlanEstudio $planEstudio)
	{
		$planEstudio=$planEstudio->find($id);
		$planEstudio->delete();

		return redirect()->route('planEstudios.index')->with('message', 'Registro Borrado.');
	}

	public function cmbPlanEstudios(Request $request){
		if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel');
            $planEstudio = $request->get('planEstudio');
            
            $final = array();
            $r = DB::table('plan_estudios as pe')
                ->join('periodo_estudios as pes','pes.plan_estudio_id','=','pe.id')
                ->select('pe.id', 'pe.name')
                ->where('pes.plantel_id', '=', $plantel)
                ->where('pe.id', '>', '0')
                ->whereNull('pe.deleted_at')
                ->distinct()
                ->get();
            
            //dd($r);
            if (isset($planEstudio) and $planEstudio != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $planEstudio) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
	}

}
