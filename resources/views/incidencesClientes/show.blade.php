@extends('plantillas.admin_template')

@include('incidencesClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('incidencesClientes.index') }}">@yield('incidencesClientesAppTitle')</a></li>
    <li class="active">{{ $incidencesCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('incidencesClientesAppTitle') / Mostrar {{$incidencesCliente->id}}

            {!! Form::model($incidencesCliente, array('route' => array('incidencesClientes.destroy', $incidencesCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('incidencesCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('incidencesClientes.edit', $incidencesCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('incidencesCliente.destroy')
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
                    <p class="form-control-static">{{$incidencesCliente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="incidence_cliente_name">INCIDENCE_CLIENTE_NAME</label>
                     <p class="form-control-static">{{$incidencesCliente->incidenceCliente->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$incidencesCliente->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$incidencesCliente->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$incidencesCliente->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$incidencesCliente->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('incidencesClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection