<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StTicket;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStTicket;
use App\Http\Requests\createStTicket;

class StTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stTickets = StTicket::getAllData($request);

		return view('stTickets.index', compact('stTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stTickets.create')
			->with( 'list', StTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StTicket::create( $input );

		return redirect()->route('stTickets.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StTicket $stTicket)
	{
		$stTicket=$stTicket->find($id);
		return view('stTickets.show', compact('stTicket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StTicket $stTicket)
	{
		$stTicket=$stTicket->find($id);
		return view('stTickets.edit', compact('stTicket'))
			->with( 'list', StTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StTicket $stTicket)
	{
		$stTicket=$stTicket->find($id);
		return view('stTickets.duplicate', compact('stTicket'))
			->with( 'list', StTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StTicket $stTicket, updateStTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stTicket=$stTicket->find($id);
		$stTicket->update( $input );

		return redirect()->route('stTickets.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StTicket $stTicket)
	{
		$stTicket=$stTicket->find($id);
		$stTicket->delete();

		return redirect()->route('stTickets.index')->with('message', 'Registro Borrado.');
	}

}
