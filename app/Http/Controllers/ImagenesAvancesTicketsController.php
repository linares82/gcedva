<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ImagenesAvancesTicket;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateImagenesAvancesTicket;
use App\Http\Requests\createImagenesAvancesTicket;

class ImagenesAvancesTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$imagenesAvancesTickets = ImagenesAvancesTicket::getAllData($request);

		return view('imagenesAvancesTickets.index', compact('imagenesAvancesTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('imagenesAvancesTickets.create')
			->with( 'list', ImagenesAvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createImagenesAvancesTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ImagenesAvancesTicket::create( $input );

		return redirect()->route('imagenesAvancesTickets.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ImagenesAvancesTicket $imagenesAvancesTicket)
	{
		$imagenesAvancesTicket=$imagenesAvancesTicket->find($id);
		return view('imagenesAvancesTickets.show', compact('imagenesAvancesTicket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ImagenesAvancesTicket $imagenesAvancesTicket)
	{
		$imagenesAvancesTicket=$imagenesAvancesTicket->find($id);
		return view('imagenesAvancesTickets.edit', compact('imagenesAvancesTicket'))
			->with( 'list', ImagenesAvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ImagenesAvancesTicket $imagenesAvancesTicket)
	{
		$imagenesAvancesTicket=$imagenesAvancesTicket->find($id);
		return view('imagenesAvancesTickets.duplicate', compact('imagenesAvancesTicket'))
			->with( 'list', ImagenesAvancesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ImagenesAvancesTicket $imagenesAvancesTicket, updateImagenesAvancesTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$imagenesAvancesTicket=$imagenesAvancesTicket->find($id);
		$imagenesAvancesTicket->update( $input );

		return redirect()->route('imagenesAvancesTickets.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ImagenesAvancesTicket $imagenesAvancesTicket)
	{
		$imagenesAvancesTicket=$imagenesAvancesTicket->find($id);
		$imagenesAvancesTicket->delete();

		return redirect()->route('imagenesAvancesTickets.index')->with('message', 'Registro Borrado.');
	}

}
