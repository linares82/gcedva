@extends('plantillas.admin_template')

@include('ingresoEgresos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('ingresoEgresos.index') }}">@yield('ingresoEgresosAppTitle')</a></li>
    <li class="active">{{ $ingresoEgreso->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('ingresoEgresosAppTitle') / Mostrar {{$ingresoEgreso->id}}

            {!! Form::model($ingresoEgreso, array('route' => array('ingresoEgresos.destroy', $ingresoEgreso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('ingresoEgreso.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ingresoEgresos.edit', $ingresoEgreso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('ingresoEgreso.destroy')
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
                    <p class="form-control-static">{{$ingresoEgreso->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cuenta_efectivo_id">CUENTA_EFECTIVO_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->cuenta_efectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="pago_id">PAGO_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->pago_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="egreso_id">EGRESO_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->egreso_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$ingresoEgreso->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$ingresoEgreso->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$ingresoEgreso->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('ingresoEgresos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection