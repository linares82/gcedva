@extends('plantillas.admin_template')

@include('cajaLns._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cajaLns.index') }}">@yield('cajaLnsAppTitle')</a></li>
    <li class="active">{{ $cajaLn->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cajaLnsAppTitle') / Mostrar {{$cajaLn->id}}

            {!! Form::model($cajaLn, array('route' => array('cajaLns.destroy', $cajaLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cajaLn.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cajaLns.edit', $cajaLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cajaLn.destroy')
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
                    <p class="form-control-static">{{$cajaLn->id}}</p>
                </div>
                <div class="form-group">
                     <label for="caja_cliente_id">CAJA_CLIENTE_ID</label>
                     <p class="form-control-static">{{$cajaLn->caja->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="concepto_id">CONCEPTO_ID</label>
                     <p class="form-control-static">{{$cajaLn->concepto_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="subtotal">SUBTOTAL</label>
                     <p class="form-control-static">{{$cajaLn->subtotal}}</p>
                </div>
                    <div class="form-group">
                     <label for="descuento">DESCUENTO</label>
                     <p class="form-control-static">{{$cajaLn->descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="recargo">RECARGO</label>
                     <p class="form-control-static">{{$cajaLn->recargo}}</p>
                </div>
                    <div class="form-group">
                     <label for="total">TOTAL</label>
                     <p class="form-control-static">{{$cajaLn->total}}</p>
                </div>
                    <div class="form-group">
                     <label for="autorizacion_descuento">AUTORIZACION_DESCUENTO</label>
                     <p class="form-control-static">{{$cajaLn->autorizacion_descuento}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cajaLn->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cajaLn->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cajaLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection