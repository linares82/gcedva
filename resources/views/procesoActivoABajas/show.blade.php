@extends('plantillas.admin_template')

@include('procesoActivoABajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('procesoActivoABajas.index') }}">@yield('procesoActivoABajasAppTitle')</a></li>
    <li class="active">{{ $procesoActivoABaja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('procesoActivoABajasAppTitle') / Mostrar {{$procesoActivoABaja->id}}

            {!! Form::model($procesoActivoABaja, array('route' => array('procesoActivoABajas.destroy', $procesoActivoABaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('procesoActivoABaja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('procesoActivoABajas.edit', $procesoActivoABaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('procesoActivoABaja.destroy')
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
                    <p class="form-control-static">{{$procesoActivoABaja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="orden">ORDEN</label>
                     <p class="form-control-static">{{$procesoActivoABaja->orden}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_mensualidades">BND_MENSUALIDADES</label>
                     <p class="form-control-static">{{$procesoActivoABaja->bnd_mensualidades}}</p>
                </div>
                    <div class="form-group">
                     <label for="cantidad_adeudos">CANTIDAD_ADEUDOS</label>
                     <p class="form-control-static">{{$procesoActivoABaja->cantidad_adeudos}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_cliente_id">ST_CLIENTE_ID</label>
                     <p class="form-control-static">{{$procesoActivoABaja->st_cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="dias">DIAS</label>
                     <p class="form-control-static">{{$procesoActivoABaja->dias}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$procesoActivoABaja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$procesoActivoABaja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('procesoActivoABajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection