<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lectivo;
use App\DiaNoHabil;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateLectivo;
use App\Http\Requests\createLectivo;
use Carbon\Carbon;
class LectivosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$lectivos = Lectivo::getAllData($request);

		return view('lectivos.index', compact('lectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lectivos.create')
			->with( 'list', Lectivo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createLectivo $request)
	{
		//dd($request->all());
		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;
		if(!isset($input['activo'])){
			$input['activo']=0;
		}else{
			$input['activo']=1;
		}
                if(!isset($input['bachillerato_bnd'])){
			$input['bachillerato_bnd']=0;
		}else{
			$input['bachillerato_bnd']=1;
		}
                if(!isset($input['carrera_bnd'])){
			$input['carrera_bnd']=0;
		}else{
			$input['carrera_bnd']=1;
		}
		//create data
		if ($r=Lectivo::create( $input )){
                    $this->calculaAsistencias($r->id);
			return redirect()->route('lectivos.index')->with('message', 'Registro creado.');	
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Lectivo $lectivo)
	{
		$lectivo=$lectivo->find($id);
		return view('lectivos.show', compact('lectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Lectivo $lectivo)
	{
		$lectivo = $lectivo->find($id);
		//dd($lectivo);
		return view('lectivos.edit', compact('lectivo'))
			->with( 'list', Lectivo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate(Lectivo $lectivo)
	{
		return view('lectivos.duplicate', compact('lectivo'))
			->with( 'list', Lectivo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Lectivo $lectivo, updateLectivo $request)
	{
		
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//dd($input);
		if(!isset($input['activo'])){
			$input['activo']=0;
		}else{
			$input['activo']=1;
		}
                if(!isset($input['bachillerato_bnd'])){
			$input['bachillerato_bnd']=0;
		}else{
			$input['bachillerato_bnd']=1;
		}
                if(!isset($input['carrera_bnd'])){
			$input['carrera_bnd']=0;
		}else{
			$input['carrera_bnd']=1;
		}

		$lectivo=$lectivo->find($id);
		//update data
		$this->calculaAsistencias($id);
		if ($lectivo->update($input)){
			return redirect()->route('lectivos.index')->with('message', 'Registro creado.');	
		} 

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Lectivo $lectivo)
	{
		$lectivo=$lectivo->find($id);
		$lectivo->delete();

		return redirect()->route('lectivos.index')->with('message', 'Registro borrado.');
	}
        
        public function calculaAsistencias($id){
            $lectivo=Lectivo::find($id);
            $dia= date('Y-m-d', strtotime($lectivo->inicio));
            $componentes=explode("-",$dia);
            $fecarbon=Carbon::createFromDate($componentes[0],$componentes[1],$componentes[2]);
            $dia2= date('Y-m-d', strtotime($lectivo->fin));
            $compo=explode("-",$dia2);
            $fincarbon=Carbon::createFromDate($compo[0],$compo[1],$compo[2]);
            $total_lv=0;
            $total_s=0;
            while($fecarbon->lte($fincarbon)){    
                $noHabil= DiaNoHabil::where('lectivo_id', '=', $id)
                                    ->where('fecha', '=', $fecarbon->format('Y-m-d'))
                                    ->first();
                //dd($noHabil);
                if(is_null($noHabil)){             
                    switch ($fecarbon->dayOfWeek){
                        case Carbon::MONDAY:
                            $total_lv++;
                            break;
                        case Carbon::TUESDAY:
                            $total_lv++;
                            break;
                        case Carbon::WEDNESDAY:
                            $total_lv++;
                            break;
                        case Carbon::THURSDAY:
                            $total_lv++;
                            break;
                        case Carbon::FRIDAY:
                            $total_lv++;
                            break;
                        case Carbon::SATURDAY:
                            $total_s++;
                            break;
                    }
                }
                $fecarbon->addDay(1);                
                //echo $fecarbon."***";
            }
            $lectivo->total_asistencias_lv=$total_lv;
            $lectivo->total_asistencias_s=$total_s;
            $lectivo->save();
            //dd($total_lv."-".$total_s."**");
        }
        
        public function imprimirCalendario($id, Lectivo $lectivo){
            $lectivo = $lectivo->find($id);
            $fecha= date('Y-m-d', strtotime($lectivo->inicio));
            $componentes=explode("-",$fecha);
            $anio=$componentes[0];

            $noHabiles= DiaNoHabil::whereYear('fecha', $anio)
                                  ->get();
            //dd($noHabiles);
            return view('lectivos.imprimirCalendario', compact('anio','noHabiles'));
        }
}
