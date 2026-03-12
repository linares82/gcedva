@extends('plantillas.admin_template')

@include('incidenciasJustificacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('incidenciasJustificacions.index') }}">@yield('incidenciasJustificacionsAppTitle')</a></li>
    <li class="active">{{ $incidenciasJustificacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('incidenciasJustificacionsAppTitle') / Mostrar {{$incidenciasJustificacion->id}}

            {!! Form::model($incidenciasJustificacion, array('route' => array('incidenciasJustificacions.destroy', $incidenciasJustificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('incidenciasJustificacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('incidenciasJustificacions.edit', $incidenciasJustificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('incidenciasJustificacion.destroy')
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
                    <p class="form-control-static">{{$incidenciasJustificacion->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$incidenciasJustificacion->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$incidenciasJustificacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MOD.</label>
                     <p class="form-control-static">{{$incidenciasJustificacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('incidenciasJustificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection