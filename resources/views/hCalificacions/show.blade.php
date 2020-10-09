@extends('plantillas.admin_template')

@include('hCalificacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hCalificacions.index') }}">@yield('hCalificacionsAppTitle')</a></li>
    <li class="active">{{ $hCalificacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hCalificacionsAppTitle') / Mostrar {{$hCalificacion->id}}

            {!! Form::model($hCalificacion, array('route' => array('hCalificacions.destroy', $hCalificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hCalificacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hCalificacions.edit', $hCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hCalificacion.destroy')
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
                    <p class="form-control-static">{{$hCalificacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$hCalificacion->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacion_calificacion">CALIFICACION_CALIFICACION</label>
                     <p class="form-control-static">{{$hCalificacion->calificacion->calificacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="carga_ponderacion_name">CARGA_PONDERACION_NAME</label>
                     <p class="form-control-static">{{$hCalificacion->cargaPonderacion->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacion_parcial_anterior">CALIFICACION_PARCIAL_ANTERIOR</label>
                     <p class="form-control-static">{{$hCalificacion->calificacion_parcial_anterior}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacion_parcial_actual">CALIFICACION_PARCIAL_ACTUAL</label>
                     <p class="form-control-static">{{$hCalificacion->calificacion_parcial_actual}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hCalificacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hCalificacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection