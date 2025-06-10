@extends('plantillas.admin_template')

@include('procedenciaAlumnos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('procedenciaAlumnos.index') }}">@yield('procedenciaAlumnosAppTitle')</a></li>
    <li class="active">{{ $procedenciaAlumno->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('procedenciaAlumnosAppTitle') / Mostrar {{$procedenciaAlumno->id}}

            {!! Form::model($procedenciaAlumno, array('route' => array('procedenciaAlumnos.destroy', $procedenciaAlumno->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('procedenciaAlumno.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('procedenciaAlumnos.edit', $procedenciaAlumno->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('procedenciaAlumno.destroy')
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
                    <p class="form-control-static">{{$procedenciaAlumno->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$procedenciaAlumno->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="institucion_procedencia">INSTITUCION_PROCEDENCIA</label>
                     <p class="form-control-static">{{$procedenciaAlumno->institucion_procedencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="sep_t_estudio_antecedente_id">SEP_T_ESTUDIO_ANTECEDENTE_ID</label>
                     <p class="form-control-static">{{$procedenciaAlumno->sep_t_estudio_antecedente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="estado_id">ESTADO_ID</label>
                     <p class="form-control-static">{{$procedenciaAlumno->estado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_inicio">FECHA_INICIO</label>
                     <p class="form-control-static">{{$procedenciaAlumno->fecha_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_terminacion">FECHA_TERMINACION</label>
                     <p class="form-control-static">{{$procedenciaAlumno->fecha_terminacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="numero_cedula_string">NUMERO_CEDULA_STRING</label>
                     <p class="form-control-static">{{$procedenciaAlumno->numero_cedula_string}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$procedenciaAlumno->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$procedenciaAlumno->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('procedenciaAlumnos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection