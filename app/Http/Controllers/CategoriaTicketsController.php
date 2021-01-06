<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CategoriaTicket;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCategoriaTicket;
use App\Http\Requests\createCategoriaTicket;

class CategoriaTicketsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$categoriaTickets = CategoriaTicket::getAllData($request);

		return view('categoriaTickets.index', compact('categoriaTickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('categoriaTickets.create')
			->with( 'list', CategoriaTicket::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCategoriaTicket $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CategoriaTicket::create( $input );

		return redirect()->route('categoriaTickets.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CategoriaTicket $categoriaTicket)
	{
		$categoriaTicket=$categoriaTicket->find($id);
		return view('categoriaTickets.show', compact('categoriaTicket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CategoriaTicket $categoriaTicket)
	{
		$categoriaTicket=$categoriaTicket->find($id);
		return view('categoriaTickets.edit', compact('categoriaTicket'))
			->with( 'list', CategoriaTicket::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CategoriaTicket $categoriaTicket)
	{
		$categoriaTicket=$categoriaTicket->find($id);
		return view('categoriaTickets.duplicate', compact('categoriaTicket'))
			->with( 'list', CategoriaTicket::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CategoriaTicket $categoriaTicket, updateCategoriaTicket $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$categoriaTicket=$categoriaTicket->find($id);
		$categoriaTicket->update( $input );

		return redirect()->route('categoriaTickets.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CategoriaTicket $categoriaTicket)
	{
		$categoriaTicket=$categoriaTicket->find($id);
		$categoriaTicket->delete();

		return redirect()->route('categoriaTickets.index')->with('message', 'Registro Borrado.');
	}

}
