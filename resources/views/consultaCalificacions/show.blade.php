@extends('plantillas.admin_template')

@include('consultaCalificacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('consultaCalificacions.index') }}">@yield('consultaCalificacionsAppTitle')</a></li>
    <li class="active">{{ $consultaCalificacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('consultaCalificacionsAppTitle') / Mostrar {{$consultaCalificacion->id}}

            {!! Form::model($consultaCalificacion, array('route' => array('consultaCalificacions.destroy', $consultaCalificacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('consultaCalificacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('consultaCalificacions.edit', $consultaCalificacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('consultaCalificacion.destroy')
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
                    <p class="form-control-static">{{$consultaCalificacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id">ID</label>
                     <p class="form-control-static">{{$consultaCalificacion->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="horario">HORARIO</label>
                     <p class="form-control-static">{{$consultaCalificacion->horario}}</p>
                </div>
                    <div class="form-group">
                     <label for="materia">MATERIA</label>
                     <p class="form-control-static">{{$consultaCalificacion->materia}}</p>
                </div>
                    <div class="form-group">
                     <label for="modulo">MODULO</label>
                     <p class="form-control-static">{{$consultaCalificacion->modulo}}</p>
                </div>
                    <div class="form-group">
                     <label for="instructor">INSTRUCTOR</label>
                     <p class="form-control-static">{{$consultaCalificacion->instructor}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$consultaCalificacion->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="apellido_paterno">APELLIDO_PATERNO</label>
                     <p class="form-control-static">{{$consultaCalificacion->apellido_paterno}}</p>
                </div>
                    <div class="form-group">
                     <label for="apellido_materno">APELLIDO_MATERNO</label>
                     <p class="form-control-static">{{$consultaCalificacion->apellido_materno}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$consultaCalificacion->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="calif_final">CALIF_FINAL</label>
                     <p class="form-control-static">{{$consultaCalificacion->calif_final}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$consultaCalificacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$consultaCalificacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('consultaCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection