@extends('plantillas.admin_template')

@include('facturaGeneralLineas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('facturaGeneralLineas.index') }}">@yield('facturaGeneralLineasAppTitle')</a></li>
    <li class="active">{{ $facturaGeneralLinea->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('facturaGeneralLineasAppTitle') / Mostrar {{$facturaGeneralLinea->id}}

            {!! Form::model($facturaGeneralLinea, array('route' => array('facturaGeneralLineas.destroy', $facturaGeneralLinea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('facturaGeneralLinea.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('facturaGeneralLineas.edit', $facturaGeneralLinea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('facturaGeneralLinea.destroy')
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
                    <p class="form-control-static">{{$facturaGeneralLinea->id}}</p>
                </div>
                <div class="form-group">
                     <label for="factura_general_uuid">FACTURA_GENERAL_UUID</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->facturaGeneral->uuid}}</p>
                </div>
                    <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="caja_fecha">CAJA_FECHA</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->caja->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="pago_fecha">PAGO_FECHA</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->pago->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_incluido">BND_INCLUIDO</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->bnd_incluido}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$facturaGeneralLinea->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('facturaGeneralLineas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection