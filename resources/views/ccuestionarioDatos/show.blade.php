@extends('plantillas.admin_template')

@include('ccuestionarioDatos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ccuestionarioDatos.index') }}">@yield('ccuestionarioDatosAppTitle')</a></li>
    <li class="active">{{ $ccuestionarioDato->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ccuestionarioDatosAppTitle') / Mostrar {{$ccuestionarioDato->id}}

            {!! Form::model($ccuestionarioDato, array('route' => array('ccuestionarioDatos.destroy', $ccuestionarioDato->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ccuestionarioDato.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ccuestionarioDatos.edit', $ccuestionarioDato->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ccuestionarioDato.destroy')
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
                    <p class="form-control-static">{{$ccuestionarioDato->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$ccuestionarioDato->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="ccuestionario_name">CCUESTIONARIO_NAME</label>
                     <p class="form-control-static">{{$ccuestionarioDato->ccuestionario->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="ccuestionario_pregunta_id">CCUESTIONARIO_PREGUNTA_ID</label>
                     <p class="form-control-static">{{$ccuestionarioDato->ccuestionario_pregunta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="ccuestionario_respuesta_id">CCUESTIONARIO_RESPUESTA_ID</label>
                     <p class="form-control-static">{{$ccuestionarioDato->ccuestionario_respuesta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$ccuestionarioDato->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$ccuestionarioDato->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$ccuestionarioDato->usu_mod_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$ccuestionarioDato->usu_alta_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('ccuestionarioDatos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection