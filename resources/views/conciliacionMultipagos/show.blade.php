@extends('plantillas.admin_template')

@include('conciliacionMultipagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('conciliacionMultipagos.index') }}">@yield('conciliacionMultipagosAppTitle')</a></li>
    <li class="active">{{ $conciliacionMultipago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('conciliacionMultipagosAppTitle') / Mostrar {{$conciliacionMultipago->id}}

            {!! Form::model($conciliacionMultipago, array('route' => array('conciliacionMultipagos.destroy', $conciliacionMultipago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('conciliacionMultipago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('conciliacionMultipagos.edit', $conciliacionMultipago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('conciliacionMultipago.destroy')
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
                    <p class="form-control-static">{{$conciliacionMultipago->id}}</p>
                </div>
                <div class="form-group">
                     <label for="fecha_carga">FECHA_CARGA</label>
                     <p class="form-control-static">{{$conciliacionMultipago->fecha_carga}}</p>
                </div>
                    <div class="form-group">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$conciliacionMultipago->archivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="registros">REGISTROS</label>
                     <p class="form-control-static">{{$conciliacionMultipago->registros}}</p>
                </div>
                    <div class="form-group">
                     <label for="contador_ejecucion">CONTADOR_EJECUCION</label>
                     <p class="form-control-static">{{$conciliacionMultipago->contador_ejecucion}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$conciliacionMultipago->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$conciliacionMultipago->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('conciliacionMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection