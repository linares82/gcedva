<?php namespace App\Http\Controllers;

use Auth;
use App\Medio;

use App\Captacion;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCaptacion;
use App\Http\Requests\updateCaptacion;
use DB;
use File;

class CaptacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$captacions = Captacion::getAllData($request);

		return view('captacions.index', compact('captacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$medios=Medio::select(DB::raw('id, concat(id, " - ", name) as name'))->pluck('name','id');
		return view('captacions.create', compact('medios'))
			->with( 'list', Captacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCaptacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Captacion::create( $input );

		return redirect()->route('captacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Captacion $captacion)
	{
		$captacion=$captacion->find($id);
		return view('captacions.show', compact('captacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Captacion $captacion)
	{
		$captacion=$captacion->find($id);
		$medios=Medio::select(DB::raw('id, concat(id, " - ", name) as name'))->pluck('name','id');
		return view('captacions.edit', compact('captacion','medios'))
			->with( 'list', Captacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Captacion $captacion)
	{
		$captacion=$captacion->find($id);
		return view('captacions.duplicate', compact('captacion'))
			->with( 'list', Captacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Captacion $captacion, updateCaptacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$captacion=$captacion->find($id);
		$captacion->update( $input );

		return redirect()->route('captacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Captacion $captacion)
	{
		$captacion=$captacion->find($id);
		$captacion->delete();

		return redirect()->route('captacions.index')->with('message', 'Registro Borrado.');
	}

	public function carga()
    {
        return view('captacions.carga');
    }

	public function cargaFile(Request $request)
    {
        $procesados = 0;
        //Define datos de trabajo
        
        $r = $request->hasFile('archivo');
        
        if ($r) {
            //Carga Archivo
            $archivo = $request->file('archivo');
            $a = $archivo->getClientOriginalName();
            $ruta = public_path() . "/files/carga/captacion/" . date("dmY_his") . "/";
            if (!file_exists($ruta)) {
                File::makedirectory($ruta, 0777, true, true);
            }
            $request->file('archivo')->move($ruta, $a);

            //Abre Archivo
			
            $fileD = fopen($ruta . $a, "r");
            $valores=fgetcsv($fileD);
			$column = fgetcsv($fileD);
			
            while (!feof($fileD)) {
                $rowData[] = fgetcsv($fileD);
            }

            //dd($rowData);

			$lineas=0;
            foreach ($rowData as $linea) {
				//dd($linea);
                try {
                    //$linea = explode(';', $linea);
                    //dd($linea);
                    $input['plantel'] = $linea[0];
					$input['nombre'] = $linea[1];
					$input['nombre2'] = $linea[2];
					$input['ape_paterno'] = $linea[3];
					$input['ape_materno'] = $linea[4];
                    $input['mail'] = $linea[5];
                    $input['tel_fijo'] = $linea[6];
                    $input['tel_cel'] = $linea[7];
					$input['pais'] = $linea[8];
					$input['comen_obs'] = $linea[9];
					$input['medio_id'] = $linea[10];
                    //$empleado=Empleado::find($request->input('empleado_id'));
                    
                    $input['usu_alta_id'] = Auth::user()->id;
                    $input['usu_mod_id'] = Auth::user()->id;

					if (Captacion::create($input)) {
                        $procesados++;
                    }
                    
                } catch (\Exception $e) {
                }
			}
            
        }

        //unlink($ruta.$a);

        return view('captacions.carga', compact('procesados'));
    }

}
