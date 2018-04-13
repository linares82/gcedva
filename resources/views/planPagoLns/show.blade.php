@extends('plantillas.admin_template')

@include('planPagoLns._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('planPagoLns.index') }}">@yield('planPagoLnsAppTitle')</a></li>
    <li class="active">{{ $planPagoLn->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('planPagoLnsAppTitle') / Mostrar {{$planPagoLn->id}}

            {!! Form::model($planPagoLn, array('route' => array('planPagoLns.destroy', $planPagoLn->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('planPagoLn.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('planPagoLns.edit', $planPagoLn->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('planPagoLn.destroy')
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
                    <p class="form-control-static">{{$planPagoLn->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plan_pago_id">PLAN_PAGO_ID</label>
                     <p class="form-control-static">{{$planPagoLn->plan_pago_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="caja_concepto_name">CAJA_CONCEPTO_NAME</label>
                     <p class="form-control-static">{{$planPagoLn->cajaConcepto->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_contable_name">CUENTA_CONTABLE_NAME</label>
                     <p class="form-control-static">{{$planPagoLn->cuentaContable->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_recargo_id">CUENTA_RECARGO_ID</label>
                     <p class="form-control-static">{{$planPagoLn->cuenta_recargo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_pago">FECHA_PAGO</label>
                     <p class="form-control-static">{{$planPagoLn->fecha_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$planPagoLn->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="inicial_bnd">INICIAL_BND</label>
                     <p class="form-control-static">{{$planPagoLn->inicial_bnd}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$planPagoLn->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$planPagoLn->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('planPagoLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection