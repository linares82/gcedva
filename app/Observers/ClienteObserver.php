<?php

namespace App\Observers;

use App\Empleado;
use App\Cliente;
use App\HEstatus;
use App\StCliente;
use Auth;

class ClienteObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(Cliente $cliente)
    {
        $cliente->st_cliente_id = 1;
        $cliente->save();
        /*$empleado=Empleado::find($cliente->empleado_id);
        $empleado->pendientes=$empleado->pendientes+1;
        $empleado->save();
        */
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    protected $cliente;

    public function updating(Cliente $cliente)
    {
        $this->cliente = $cliente;
        $vcliente = Cliente::find($cliente->id);
        //historico de estatus
        //dd($this->cliente);
        if ($vcliente->st_cliente_id <> $this->cliente->st_cliente_id) {
            $st_cliente = StCliente::find($this->cliente->st_cliente_id);
            $input['tabla'] = 'clientes';
            $input['cliente_id'] = $vcliente->id;
            $input['seguimiento_id'] = 0;
            $input['estatus'] = $st_cliente->name;
            $input['estatus_id'] = $st_cliente->id;
            $input['fecha'] = Date('Y-m-d');
            $input['usu_alta_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            $input['usu_mod_id'] = isset(Auth::user()->id) ? Auth::user()->id : 1;
            HEstatus::create($input);
        }

        //Llenando de fecha limite de entrega de docs en base a matricula
        if ($vcliente->matricula <> $cliente->matricula) {
            $mesMatricula = intval(substr($cliente->matricula, 0, 2)) + 2;
            $anioMatricula = "20" . substr($cliente->matricula, 2, 2);
            $this->cliente->fec_limite_entrega_docs = date_create_from_format('Y-m-d', $anioMatricula . "-" . $mesMatricula . "-01");
        }
        //dd($this->cliente->nombre."-".$vcliente->nombre);
        if ($cliente->bnd_doc_oblig_entregados == 1) {
            $cliente->fec_docs_oblig_entregados = date('Y-m-d');
        }
    }

    public function updated(Cliente $cliente)
    {
        /*
        if ($cliente->bnd_doc_oblig_entregados == 1) {
            $cliente->fec_docs_oblig_entregados = date('Y-m-d');
            $cliente->save();
        }
            */
    }
}
