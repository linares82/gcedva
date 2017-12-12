@extends('plantillas.admin_template')

@include('materiumPeriodos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('materiumPeriodos.index') }}">@yield('materiumPeriodosAppTitle')</a></li>
    <li class="active">{{ $materiumPeriodo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('materiumPeriodosAppTitle') / Mostrar {{$materiumPeriodo->id}}

            {!! Form::model($materiumPeriodo, array('route' => array('materiumPeriodos.destroy', $materiumPeriodo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('materiumPeriodo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('materiumPeriodos.edit', $materiumPeriodo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('materiumPeriodo.destroy')
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
                    <p class="form-control-static">{{$materiumPeriodo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="materium_id">MATERIUM_ID</label>
                     <p class="form-control-static">{{$materiumPeriodo->materium_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="periodo_estudio_id">PERIODO_ESTUDIO_ID</label>
                     <p class="form-control-static">{{$materiumPeriodo->periodo_estudio_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$materiumPeriodo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$materiumPeriodo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('materiumPeriodos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection