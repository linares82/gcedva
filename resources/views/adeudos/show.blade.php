@extends('plantillas.admin_template')

@include('adeudos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('adeudos.index') }}">@yield('adeudosAppTitle')</a></li>
    <li class="active">{{ $adeudo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('adeudosAppTitle') / Mostrar {{$adeudo->id}}

            {!! Form::model($adeudo, array('route' => array('adeudos.destroy', $adeudo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('adeudo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('adeudos.edit', $adeudo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('adeudo.destroy')
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
                    <p class="form-control-static">{{$adeudo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_nombre">CLIENTE_NOMBRE</label>
                     <p class="form-control-static">{{$adeudo->cliente->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="concepto_cobro_id">CONCEPTO_COBRO_ID</label>
                     <p class="form-control-static">{{$adeudo->concepto_cobro_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_contable_name">CUENTA_CONTABLE_NAME</label>
                     <p class="form-control-static">{{$adeudo->cuentaContable->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_recargo_id">CUENTA_RECARGO_ID</label>
                     <p class="form-control-static">{{$adeudo->cuenta_recargo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_pago">FECHA_PAGO</label>
                     <p class="form-control-static">{{$adeudo->fecha_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$adeudo->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="inicial_bnd">INICIAL_BND</label>
                     <p class="form-control-static">{{$adeudo->inicial_bnd}}</p>
                </div>
                    <div class="form-group">
                     <label for="plan_pago_ln_fecha_pago">PLAN_PAGO_LN_FECHA_PAGO</label>
                     <p class="form-control-static">{{$adeudo->planPagoLn->fecha_pago}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$adeudo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$adeudo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('adeudos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection