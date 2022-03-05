<?php

namespace App\Http\Controllers;

use Auth;
use App\Turno;
use App\Adeudo;
use App\Cliente;
use App\Plantel;
use App\CombinacionCliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createCombinacionCliente;
use App\Http\Requests\updateCombinacionCliente;

class CombinacionClientesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $combinacionClientes = CombinacionCliente::getAllData($request);

        return view('combinacionClientes.index', compact('combinacionClientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('combinacionClientes.create')
            ->with('list', CombinacionCliente::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCombinacionCliente $request)
    {

        $input = $request->all();
        //dd($input);
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $turno = Turno::find($input['turno_id']);
        foreach ($turno->planes as $plan) {
            $input['plan_pago_id'] = $plan->id;
            break;
        }

        //create data
        $combinacion=CombinacionCliente::create($input);
        $cliente=Cliente::find($combinacion->cliente_id);
        $cliente->save();

        //return redirect()->route('combinacionClientes.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, CombinacionCliente $combinacionCliente)
    {
        $combinacionCliente = $combinacionCliente->find($id);
        return view('combinacionClientes.show', compact('combinacionCliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, CombinacionCliente $combinacionCliente)
    {
        $combinacionCliente = $combinacionCliente->find($id);
        return view('combinacionClientes.edit', compact('combinacionCliente'))
            ->with('list', CombinacionCliente::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, CombinacionCliente $combinacionCliente)
    {
        $combinacionCliente = $combinacionCliente->find($id);
        return view('combinacionClientes.duplicate', compact('combinacionCliente'))
            ->with('list', CombinacionCliente::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, CombinacionCliente $combinacionCliente, updateCombinacionCliente $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $combinacionCliente = $combinacionCliente->find($id);
        $turno = Turno::find($input['turno_id']);
        foreach ($turno->planes as $plan) {
            $input['plan_pago_id'] = $plan->id;
            break;
        }
        $combinacionCliente->update($input);

        //return redirect()->route('combinacionClientes.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, CombinacionCliente $combinacionCliente)
    {
        $combinacionCliente = $combinacionCliente->find($id);
        $adeudos = Adeudo::where('combinacion_cliente_id', $combinacionCliente->id)->get();

        $pagado = 0;
        if (count($adeudos) > 0) {
            foreach ($adeudos as $adeudo) {
                if ($adeudo->pagado_bnd == 1) {
                    $pagado = 1;
                } else {
                    $adeudo->delete();
                }
            }
        }
        $c = $combinacionCliente->cliente_id;
        if ($pagado == 0) {
            $combinacionCliente->delete();
        }

        return redirect()->route('clientes.edit', $c)->with('message', 'Registro Borrado.');
    }

    public function savePlanPago(Request $request)
    {
        //dd($request);
        if ($request->ajax()) {
            $data = $request->all();
            //dd($data);
            $combinacion = CombinacionCliente::find($data['combinacion']);
            $combinacion->plan_pago_id = $data['plan_pago'];
            $combinacion->save();
            echo json_encode($combinacion);
        }
    }

    public function saveBndBeca(Request $request)
    {
        //dd($request);
        if ($request->ajax()) {
            $data = $request->all();
            //dd($data);
            $combinacion = CombinacionCliente::find($data['combinacion']);
            $combinacion->bnd_beca = $data['bnd_beca'];
            $combinacion->save();
            echo json_encode($combinacion);
        }
    }

    public function cargas()
    {
        $plantels=Plantel::pluck('razon','id');
        //dd($plantels);
        return view('combinacionClientes.reportes.cargas',compact('plantels'));
    }
}
