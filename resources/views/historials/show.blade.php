@extends('plantillas.admin_template')

@include('historials._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('historials.index') }}">@yield('historialsAppTitle')</a></li>
    <li class="active">{{ $historial->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('historialsAppTitle') / Mostrar {{$historial->id}}

            {!! Form::model($historial, array('route' => array('historials.destroy', $historial->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('historial.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('historials.edit', $historial->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('historial.destroy')
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
                    <p class="form-control-static">{{$historial->id}}</p>
                </div>
                <div class="form-group">
                     <label for="historia_evento_name">HISTORIA_EVENTO_NAME</label>
                     <p class="form-control-static">{{$historial->historiaEvento->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$historial->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$historial->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$historial->archivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_nombre">EMPLEADO_NOMBRE</label>
                     <p class="form-control-static">{{$historial->empleado->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$historial->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$historial->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('historials.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection