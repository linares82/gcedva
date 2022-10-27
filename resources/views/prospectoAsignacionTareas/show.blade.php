@extends('plantillas.admin_template')

@include('prospectoAsignacionTareas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoAsignacionTareas.index') }}">@yield('prospectoAsignacionTareasAppTitle')</a></li>
    <li class="active">{{ $prospectoAsignacionTarea->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoAsignacionTareasAppTitle') / Mostrar {{$prospectoAsignacionTarea->id}}

            {!! Form::model($prospectoAsignacionTarea, array('route' => array('prospectoAsignacionTareas.destroy', $prospectoAsignacionTarea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoAsignacionTarea.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoAsignacionTareas.edit', $prospectoAsignacionTarea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoAsignacionTarea.destroy')
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
                    <p class="form-control-static">{{$prospectoAsignacionTarea->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_id">PROSPECTO_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->prospecto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_id">EMPLEADO_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->empleado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="prospecto_tarea_id">PROSPECTO_TAREA_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->prospecto_tarea_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="prospecto_asunto_id">PROSPECTO_ASUNTO_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->prospecto_asunto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="propecto_st_seg_id">PROPECTO_ST_SEG_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->propecto_st_seg_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="obs">OBS</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->obs}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prospectoAsignacionTarea->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoAsignacionTareas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection