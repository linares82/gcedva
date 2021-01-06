<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ImagenesTicket;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateImagenesTicket;
use App\Http\Requests\createImagenesTicket;

class ImagenesTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$imagenesTickets = ImagenesTicket::getAllData($request);

		return view('imagenesTickets.index', compact('imagenesTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('imagenesTickets.create')
			->with( 'list', ImagenesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createImagenesTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ImagenesTicket::create( $input );

		return redirect()->route('imagenesTickets.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ImagenesTicket $imagenesTicket)
	{
		$imagenesTicket=$imagenesTicket->find($id);
		return view('imagenesTickets.show', compact('imagenesTicket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ImagenesTicket $imagenesTicket)
	{
		$imagenesTicket=$imagenesTicket->find($id);
		return view('imagenesTickets.edit', compact('imagenesTicket'))
			->with( 'list', ImagenesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ImagenesTicket $imagenesTicket)
	{
		$imagenesTicket=$imagenesTicket->find($id);
		return view('imagenesTickets.duplicate', compact('imagenesTicket'))
			->with( 'list', ImagenesTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ImagenesTicket $imagenesTicket, updateImagenesTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$imagenesTicket=$imagenesTicket->find($id);
		$imagenesTicket->update( $input );

		return redirect()->route('imagenesTickets.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ImagenesTicket $imagenesTicket)
	{
		$imagenesTicket=$imagenesTicket->find($id);
		$imagenesTicket->delete();

		return redirect()->route('imagenesTickets.index')->with('message', 'Registro Borrado.');
	}

}
