<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PrioridadTicket;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePrioridadTicket;
use App\Http\Requests\createPrioridadTicket;

class PrioridadTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prioridadTickets = PrioridadTicket::getAllData($request);

		return view('prioridadTickets.index', compact('prioridadTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prioridadTickets.create')
			->with( 'list', PrioridadTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPrioridadTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PrioridadTicket::create( $input );

		return redirect()->route('prioridadTickets.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PrioridadTicket $prioridadTicket)
	{
		$prioridadTicket=$prioridadTicket->find($id);
		return view('prioridadTickets.show', compact('prioridadTicket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PrioridadTicket $prioridadTicket)
	{
		$prioridadTicket=$prioridadTicket->find($id);
		return view('prioridadTickets.edit', compact('prioridadTicket'))
			->with( 'list', PrioridadTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PrioridadTicket $prioridadTicket)
	{
		$prioridadTicket=$prioridadTicket->find($id);
		return view('prioridadTickets.duplicate', compact('prioridadTicket'))
			->with( 'list', PrioridadTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PrioridadTicket $prioridadTicket, updatePrioridadTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prioridadTicket=$prioridadTicket->find($id);
		$prioridadTicket->update( $input );

		return redirect()->route('prioridadTickets.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PrioridadTicket $prioridadTicket)
	{
		$prioridadTicket=$prioridadTicket->find($id);
		$prioridadTicket->delete();

		return redirect()->route('prioridadTickets.index')->with('message', 'Registro Borrado.');
	}

}
