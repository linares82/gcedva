@extends('plantillas.admin_template')

@include('ccuestionarioRespuestas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ccuestionarioRespuestas.index') }}">@yield('ccuestionarioRespuestasAppTitle')</a></li>
    <li class="active">{{ $ccuestionarioRespuestum->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ccuestionarioRespuestasAppTitle') / Mostrar {{$ccuestionarioRespuestum->id}}

            {!! Form::model($ccuestionarioRespuestum, array('route' => array('ccuestionarioRespuestas.destroy', $ccuestionarioRespuestum->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ccuestionarioRespuestum.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ccuestionarioRespuestas.edit', $ccuestionarioRespuestum->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ccuestionarioRespuestum.destroy')
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
                    <p class="form-control-static">{{$ccuestionarioRespuestum->id}}</p>
                </div>
                <div class="form-group">
                     <label for="ccuestionario_name">CCUESTIONARIO_NAME</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->ccuestionario->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="ccuestionario_pregunta_id">CCUESTIONARIO_PREGUNTA_ID</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->ccuestionario_pregunta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->usu_mod_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$ccuestionarioRespuestum->usu_alta_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('ccuestionarioRespuestas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection