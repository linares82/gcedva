@extends('plantillas.admin_template')

@include('cuestionarioPreguntas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuestionarioPreguntas.index') }}">@yield('cuestionarioPreguntasAppTitle')</a></li>
    <li class="active">{{ $cuestionarioPregunta->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuestionarioPreguntasAppTitle') / Mostrar {{$cuestionarioPregunta->id}}

            {!! Form::model($cuestionarioPregunta, array('route' => array('cuestionarioPreguntas.destroy', $cuestionarioPregunta->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuestionarioPregunta.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuestionarioPreguntas.edit', $cuestionarioPregunta->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuestionarioPregunta.destroy')
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
                    <p class="form-control-static">{{$cuestionarioPregunta->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cuestionario_id">CUESTIONARIO_ID</label>
                     <p class="form-control-static">{{$cuestionarioPregunta->cuestionario_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$cuestionarioPregunta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cuestionarioPregunta->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cuestionarioPregunta->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuestionarioPreguntas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection