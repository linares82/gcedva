@extends('plantillas.admin_template')

@include('prospectoHactividads._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoHactividads.index') }}">@yield('prospectoHactividadsAppTitle')</a></li>
    <li class="active">{{ $prospectoHactividad->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoHactividadsAppTitle') / Mostrar {{$prospectoHactividad->id}}

            {!! Form::model($prospectoHactividad, array('route' => array('prospectoHactividads.destroy', $prospectoHactividad->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoHactividad.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoHactividads.edit', $prospectoHactividad->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoHactividad.destroy')
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
                    <p class="form-control-static">{{$prospectoHactividad->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_id">PROSPECTO_ID</label>
                     <p class="form-control-static">{{$prospectoHactividad->prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="prospecto_seguimiento_id">PROSPECTO_SEGUIMIENTO_ID</label>
                     <p class="form-control-static">{{$prospectoHactividad->prospecto_seguimiento_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="tarea">TAREA</label>
                     <p class="form-control-static">{{$prospectoHactividad->tarea}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$prospectoHactividad->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="hora">HORA</label>
                     <p class="form-control-static">{{$prospectoHactividad->hora}}</p>
                </div>
                    <div class="form-group">
                     <label for="asunto">ASUNTO</label>
                     <p class="form-control-static">{{$prospectoHactividad->asunto}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$prospectoHactividad->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prospectoHactividad->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prospectoHactividad->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoHactividads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection