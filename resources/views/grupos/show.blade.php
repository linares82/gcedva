@extends('plantillas.admin_template')

@include('grupos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('grupos.index') }}">@yield('gruposAppTitle')</a></li>
    <li class="active">{{ $grupo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('gruposAppTitle') / Mostrar {{$grupo->id}}

            {!! Form::model($grupo, array('route' => array('grupos.destroy', $grupo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('grupo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('grupos.edit', $grupo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('grupo.destroy')
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
                    <p class="form-control-static">{{$grupo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$grupo->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="desc_corta">DESC_CORTA</label>
                     <p class="form-control-static">{{$grupo->desc_corta}}</p>
                </div>
                    <div class="form-group">
                     <label for="limite_alumnos">LIMITE_ALUMNOS</label>
                     <p class="form-control-static">{{$grupo->limite_alumnos}}</p>
                </div>
                    <div class="form-group">
                     <label for="jornada_id">JORNADA_ID</label>
                     <p class="form-control-static">{{$grupo->jornada_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="salon_id">SALON_ID</label>
                     <p class="form-control-static">{{$grupo->salon_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="periodo_id">PERIODO_ID</label>
                     <p class="form-control-static">{{$grupo->periodo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$grupo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$grupo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('grupos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection