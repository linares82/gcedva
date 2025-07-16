<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\WebhookOpenpay;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateWebhookOpenpay;
use App\Http\Requests\createWebhookOpenpay;

class WebhookOpenpaysController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$webhookOpenpays = WebhookOpenpay::getAllData($request);

		return view('webhookOpenpays.index', compact('webhookOpenpays'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('webhookOpenpays.create')
			->with( 'list', WebhookOpenpay::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createWebhookOpenpay $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		WebhookOpenpay::create( $input );

		return redirect()->route('webhookOpenpays.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, WebhookOpenpay $webhookOpenpay)
	{
		$webhookOpenpay=$webhookOpenpay->find($id);
		return view('webhookOpenpays.show', compact('webhookOpenpay'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, WebhookOpenpay $webhookOpenpay)
	{
		$webhookOpenpay=$webhookOpenpay->find($id);
		return view('webhookOpenpays.edit', compact('webhookOpenpay'))
			->with( 'list', WebhookOpenpay::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, WebhookOpenpay $webhookOpenpay)
	{
		$webhookOpenpay=$webhookOpenpay->find($id);
		return view('webhookOpenpays.duplicate', compact('webhookOpenpay'))
			->with( 'list', WebhookOpenpay::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, WebhookOpenpay $webhookOpenpay, updateWebhookOpenpay $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$webhookOpenpay=$webhookOpenpay->find($id);
		$webhookOpenpay->update( $input );

		return redirect()->route('webhookOpenpays.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,WebhookOpenpay $webhookOpenpay)
	{
		$webhookOpenpay=$webhookOpenpay->find($id);
		$webhookOpenpay->delete();

		return redirect()->route('webhookOpenpays.index')->with('message', 'Registro Borrado.');
	}

}
