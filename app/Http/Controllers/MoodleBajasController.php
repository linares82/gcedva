<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MoodleBaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMoodleBaja;
use App\Http\Requests\createMoodleBaja;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class MoodleBajasController extends Controller
{
	protected $dominio = "https://www.cedvavirtual.com";
	protected $SALT = 'SbSkhl0XvctpPUscgLNg';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$moodleBajas = MoodleBaja::getAllData($request);

		return view('moodleBajas.index', compact('moodleBajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('moodleBajas.create')
			->with('list', MoodleBaja::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMoodleBaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		MoodleBaja::create($input);

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja = $moodleBaja->find($id);
		return view('moodleBajas.show', compact('moodleBaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja = $moodleBaja->find($id);
		return view('moodleBajas.edit', compact('moodleBaja'))
			->with('list', MoodleBaja::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja = $moodleBaja->find($id);
		return view('moodleBajas.duplicate', compact('moodleBaja'))
			->with('list', MoodleBaja::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, MoodleBaja $moodleBaja, updateMoodleBaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$moodleBaja = $moodleBaja->find($id);
		$moodleBaja->update($input);

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, MoodleBaja $moodleBaja)
	{
		$moodleBaja = $moodleBaja->find($id);
		$moodleBaja->delete();

		return redirect()->route('moodleBajas.index')->with('message', 'Registro Borrado.');
	}

	public function procesarTodo(Request $request)
	{

		$datos = $request->all();
		foreach ($datos['clientes'] as $cliente) {
			$this->procesar($cliente);
		}
	}

	public function procesarUno(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		if ($this->verificaDisponibilidad()) {
			try {
				$key = $datos['key'];
				//dd($datos);
				$metodo = $datos['method'];
				$username = $datos['username'];
				$active = $datos['active'];
				$client = new Client(['base_uri' => $this->dominio]); //GuzzleHttp\Client
				//dd("/wsrpc/rpc.controller.php?method=" . $metodo . "&key=" . $key . '&username=' . $username . '&active=' . $active);
				$result = $client->request('GET', "/wsrpc/rpc.controller.php?method=" . $metodo . "&key=" . $key . '&username=' . $username . '&active=' . $active);
				//dd($result->getBody()->getContents());
				$request = $result->getBody()->getContents();
				//dd($request);
				return response()->Json($request);
				/*if ($result->getStatusCode() == 200) {
					$this->procesar($datos['cliente']);
				}*/
			} catch (\PDOException $e) {
				return redirect()->route('adeudos.adeudosXplantel')->with('message', $e->getMessage());
			}
			return redirect()->route('adeudos.adeudosXplantel')->with('message', $result->getStatusCode() . ": ");
		} else {
			return redirect()->route('adeudos.adeudosXplantel')->with('message', 'Servicio en Moodle no disponible.');
		}
	}

	public function procesarUnoAlta(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$this->procesarAlta($datos['id']);
		return redirect()->route('adeudos.adeudosXplantel');
	}

	protected function procesar($cliente)
	{
		//dd($cliente);
		MoodleBaja::create(
			array(
				'cliente_id' => $cliente,
				'bnd_baja' => 1,
				'fecha_baja' => Date('Y-m-d'),
				'bnd_alta' => 0,
				'usu_alta_id' => Auth::user()->id,
				'usu_mod_id' => Auth::user()->id,
			)
		);
		return true;
	}

	protected function procesarAlta($id)
	{
		//dd($cliente);
		$registro = MoodleBaja::find($id);
		$registro->update(
			array(
				'fecha_alta' => Date('Y-m-d'),
				'bnd_alta' => 1,
			)
		);
		return true;
	}

	protected function verificaDisponibilidad()
	{
		$client = new Client(); //GuzzleHttp\Client
		$result = $client->get($this->dominio . "/wsrpc/rpc.controller.php");
		//dd($result->getReasonPhrase());
		if ($result->getReasonPhrase() == 'OK') {
			return true;
		} else {
			return false;
		}
	}
}
