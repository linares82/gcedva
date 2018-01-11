@extends('plantillas.admin_template')

@include('cuestionarioRespuestas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuestionarioRespuestas.index') }}">@yield('cuestionarioRespuestasAppTitle')</a></li>
    <li class="active">{{ $cuestionarioRespuesta->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuestionarioRespuestasAppTitle') / Mostrar {{$cuestionarioRespuesta->id}}

            {!! Form::model($cuestionarioRespuesta, array('route' => array('cuestionarioRespuestas.destroy', $cuestionarioRespuesta->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuestionarioRespuesta.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuestionarioRespuestas.edit', $cuestionarioRespuesta->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuestionarioRespuesta.destroy')
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
                    <p class="form-control-static">{{$cuestionarioRespuesta->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cuestionario_id">CUESTIONARIO_ID</label>
                     <p class="form-control-static">{{$cuestionarioRespuesta->cuestionario_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuestionario_pregunta">CUESTIONARIO_PREGUNTA</label>
                     <p class="form-control-static">{{$cuestionarioRespuesta->cuestionario_pregunta}}</p>
                </div>
                    <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$cuestionarioRespuesta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cuestionarioRespuesta->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cuestionarioRespuesta->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuestionarioRespuestas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection