@extends('plantillas.admin_template')

@include('cajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cajas.index') }}">@yield('cajasAppTitle')</a></li>
    <li class="active">{{ $caja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cajasAppTitle') / Mostrar {{$caja->id}}

            {!! Form::model($caja, array('route' => array('cajas.destroy', $caja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('caja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cajas.edit', $caja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('caja.destroy')
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
                    <p class="form-control-static">{{$caja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$caja->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$caja->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="subtotal">SUBTOTAL</label>
                     <p class="form-control-static">{{$caja->subtotal}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$caja->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="recargo">RECARGO</label>
                     <p class="form-control-static">{{$caja->recargo}}</p>
                </div>
                    <div class="form-group">
                     <label for="total">TOTAL</label>
                     <p class="form-control-static">{{$caja->total}}</p>
                </div>
                    <div class="form-group">
                     <label for="forma_pago_name">FORMA_PAGO_NAME</label>
                     <p class="form-control-static">{{$caja->formaPago->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="autorizacion_descuento">AUTORIZACION_DESCUENTO</label>
                     <p class="form-control-static">{{$caja->autorizacion_descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$caja->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$caja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$caja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection