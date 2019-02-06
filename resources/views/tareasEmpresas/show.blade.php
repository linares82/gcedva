@extends('plantillas.admin_template')

@include('tareasEmpresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('tareasEmpresas.index') }}">@yield('tareasEmpresasAppTitle')</a></li>
    <li class="active">{{ $tareasEmpresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('tareasEmpresasAppTitle') / Mostrar {{$tareasEmpresa->id}}

            {!! Form::model($tareasEmpresa, array('route' => array('tareasEmpresas.destroy', $tareasEmpresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('tareasEmpresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('tareasEmpresas.edit', $tareasEmpresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('tareasEmpresa.destroy')
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
                    <p class="form-control-static">{{$tareasEmpresa->id}}</p>
                </div>
                <div class="form-group">
                     <label for="empresa_razon_social">EMPRESA_RAZON_SOCIAL</label>
                     <p class="form-control-static">{{$tareasEmpresa->empresa->razon_social}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_nombre">EMPLEADO_NOMBRE</label>
                     <p class="form-control-static">{{$tareasEmpresa->empleado->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="tarea_name">TAREA_NAME</label>
                     <p class="form-control-static">{{$tareasEmpresa->tarea->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="asunto_name">ASUNTO_NAME</label>
                     <p class="form-control-static">{{$tareasEmpresa->asunto->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$tareasEmpresa->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_tarea_name">ST_TAREA_NAME</label>
                     <p class="form-control-static">{{$tareasEmpresa->stTarea->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$tareasEmpresa->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$tareasEmpresa->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('tareasEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection