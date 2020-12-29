@extends('plantillas.admin_template')

@include('incidenceClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('incidenceClientes.index') }}">@yield('incidenceClientesAppTitle')</a></li>
    <li class="active">{{ $incidenceCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('incidenceClientesAppTitle') / Mostrar {{$incidenceCliente->id}}

            {!! Form::model($incidenceCliente, array('route' => array('incidenceClientes.destroy', $incidenceCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('incidenceCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('incidenceClientes.edit', $incidenceCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('incidenceCliente.destroy')
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
                    <p class="form-control-static">{{$incidenceCliente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">INCIDENCIA</label>
                     <p class="form-control-static">{{$incidenceCliente->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$incidenceCliente->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$incidenceCliente->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('incidenceClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection