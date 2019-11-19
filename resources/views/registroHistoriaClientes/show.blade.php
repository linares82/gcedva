@extends('plantillas.admin_template')

@include('registroHistoriaClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('registroHistoriaClientes.index') }}">@yield('registroHistoriaClientesAppTitle')</a></li>
    <li class="active">{{ $registroHistoriaCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('registroHistoriaClientesAppTitle') / Mostrar {{$registroHistoriaCliente->id}}

            {!! Form::model($registroHistoriaCliente, array('route' => array('registroHistoriaClientes.destroy', $registroHistoriaCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('registroHistoriaCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('registroHistoriaClientes.edit', $registroHistoriaCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('registroHistoriaCliente.destroy')
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
                    <p class="form-control-static">{{$registroHistoriaCliente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="historia_cliente_id">HISTORIA_CLIENTE_ID</label>
                     <p class="form-control-static">{{$registroHistoriaCliente->historia_cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_historia_cliente_id">ST_HISTORIA_CLIENTE_ID</label>
                     <p class="form-control-static">{{$registroHistoriaCliente->st_historia_cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="comentario">COMENTARIO</label>
                     <p class="form-control-static">{{$registroHistoriaCliente->comentario}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$registroHistoriaCliente->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$registroHistoriaCliente->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('registroHistoriaClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection