@extends('plantillas.admin_template')

@include('existencias._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('existencias.index') }}">@yield('existenciasAppTitle')</a></li>
    <li class="active">{{ $existencium->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('existenciasAppTitle') / Mostrar {{$existencium->id}}

            {!! Form::model($existencium, array('route' => array('existencias.destroy', $existencium->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('existencium.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('existencias.edit', $existencium->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('existencium.destroy')
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
                    <p class="form-control-static">{{$existencium->id}}</p>
                </div>
                <div class="form-group">
                     <label for="articulo_id">ARTICULO_ID</label>
                     <p class="form-control-static">{{$existencium->articulo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$existencium->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="existencia">EXISTENCIA</label>
                     <p class="form-control-static">{{$existencium->existencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$existencium->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$existencium->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('existencias.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection