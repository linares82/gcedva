<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $roles = Role::getAllData($request);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model=new Role;
        $permisos=Permission::pluck('name','id');
        
        return view('roles.create', compact('model','permisos'))
                        ->with('list', Role::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos=$request->all();
        
        $permisos=$request->only('permissions');
        
        
        $rol=Role::create($datos);

        if(count($permisos)>0){
            $rol->permisos()->sync($permisos['permissions']);
        }else{
            $rol->permisos()->detach();
        }

        return redirect()->route('rolesF.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model=Role::find($id);
        $permisos=Permission::pluck('name','id');
        //dd($model->toArray());
        return view('roles.edit', compact('model','permisos'))
                        ->with('list', Role::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datos=$request->all();
        $permisos=$request->only('permissions');
        
        $rol=Role::find($id);
        $rol->update($datos);

        if(count($permisos)>0){
            $rol->permisos()->sync($permisos['permissions']);
        }else{
            $rol->permisos()->detach();
        }
        

        return redirect()->route('rolesF.index')->with('message', 'Registro Creado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($rol->toArray());
        $rol=Role::where('id',$id)->first();
        
        //dd($rol);
        /*if($rol){
            Role::destroy($id);
        }*/
        $rol->delete();
        
        
        return redirect()->route('rolesF.index')->with('message', 'Registro Borrado.');
    }
}
