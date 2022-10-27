@extends('plantillas.admin_template')

@include('prospectoAvisos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoAvisos.index') }}">@yield('prospectoAvisosAppTitle')</a></li>
    <li class="active">{{ $prospectoAviso->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoAvisosAppTitle') / Mostrar {{$prospectoAviso->id}}

            {!! Form::model($prospectoAviso, array('route' => array('prospectoAvisos.destroy', $prospectoAviso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoAviso.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoAvisos.edit', $prospectoAviso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoAviso.destroy')
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
                    <p class="form-control-static">{{$prospectoAviso->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_seguimiento_id">PROSPECTO_SEGUIMIENTO_ID</label>
                     <p class="form-control-static">{{$prospectoAviso->prospecto_seguimiento_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="prospecto_asunto_id">PROSPECTO_ASUNTO_ID</label>
                     <p class="form-control-static">{{$prospectoAviso->prospecto_asunto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$prospectoAviso->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$prospectoAviso->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$prospectoAviso->activo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prospectoAviso->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prospectoAviso->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoAvisos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection