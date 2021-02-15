@extends('plantillas.admin_template')

@include('historiaClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('historiaClientes.index') }}">@yield('historiaClientesAppTitle')</a></li>
    <li class="active">{{ $historiaCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('historiaClientesAppTitle') / Mostrar {{$historiaCliente->id}}

            {!! Form::model($historiaCliente, array('route' => array('historiaClientes.destroy', $historiaCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('historiaCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('historiaClientes.edit', $historiaCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('historiaCliente.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$historiaCliente->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="evento_cliente_name">EVENTO</label>
                     <p class="form-control-static">{{$historiaCliente->eventoCliente->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$historiaCliente->descripcion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$historiaCliente->fecha}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$historiaCliente->archivo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="cliente_nombre">CLIENTE</label>
                     <p class="form-control-static">{{$historiaCliente->cliente->nombre}}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cliente_nombre">INSCRIPCION</label>
                    <p class="form-control-static">{{($historiaCliente->inscripcion ? $historiaCliente->inscripcion->grupo->name ." ". $historiaCliente->inscripcion->turno->name : 'Vacio')}}</p>
               </div>
                <div class="form-group col-sm-4">
                    <label for="cliente_nombre">REACTIVACION</label>
                    <p class="form-control-static">{{$historiaCliente->reactivado}}</p>
               </div>
               <div class="form-group col-sm-4">
                        <label for="cliente_nombre">FEC. ULTIMA REACTIVACION</label>
                        <p class="form-control-static">{{$historiaCliente->fec_reactivado}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$historiaCliente->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACON</label>
                     <p class="form-control-static">{{$historiaCliente->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ url('historiaClientes/index?q%5Bcliente_id_lt%5D='.$historiaCliente->cliente_id) }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection