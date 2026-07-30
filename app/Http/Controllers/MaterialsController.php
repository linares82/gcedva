<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\createMaterial;
use App\Http\Requests\updateMaterial;
use App\Material;
use App\Services\UploadService;
use Auth;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$materials = Material::getAllData($request);

		return view('materials.index', compact('materials'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('materials.create')
			->with('list', Material::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createMaterial $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$material = Material::create($input);

		return redirect()->route('materials.edit', $material->id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Material $material)
	{
		$material = $material->find($id);
		return view('materials.show', compact('material'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Material $material)
	{
		$material = $material->find($id);
		return view('materials.edit', compact('material'))
			->with('list', Material::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Material $material)
	{
		$material = $material->find($id);
		return view('materials.duplicate', compact('material'))
			->with('list', Material::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Material $material, updateMaterial $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$material = $material->find($id);
		$material->update($input);

		return redirect()->route('materials.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Material $material)
	{
		$material = $material->find($id);
		$material->delete();

		return redirect()->route('materials.index')->with('message', 'Registro Borrado.');
	}

	public function cargarImgSpace(Request $request)
	{

		$r = $request->hasFile('file');
		$datos = $request->all();
		//dd($datos);

		$material = Material::find($datos['material_id']);
		//dd($documento);
		//Se borra el anterior archivo si existe
		//dd(!is_null($documento->archivo));
		if (!is_null($material->archivo)) {
			UploadService::delete($material->id . "/" . $material->archivo, "do_materials");
		}

		//Secuarda el nuevo archivo
		$image = UploadService::upload(data_get($datos, 'file'), $material->id . "/", 'do_materials');
		//dd($image);
		//Se actuaizan datos

		$material->archivo = $image;
		//$documento->usu_alta_id = Auth::user()->id;
		$material->usu_mod_id = 1;
		$material->save();

		return $material;
	}
}
