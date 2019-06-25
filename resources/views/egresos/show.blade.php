@extends('plantillas.admin_template')

@include('egresos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('egresos.index') }}">@yield('egresosAppTitle')</a></li>
    <li class="active">{{ $egreso->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('egresosAppTitle') / Mostrar {{$egreso->id}}

            {!! Form::model($egreso, array('route' => array('egresos.destroy', $egreso->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('egreso.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('egresos.edit', $egreso->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('egreso.destroy')
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
                    <p class="form-control-static">{{$egreso->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="fecha">PLANTEL</label>
                     <p class="form-control-static">{{$egreso->plantel->razon}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$egreso->fecha}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="egresos_concepto_name">EGRESOS CONCEPTO</label>
                     <p class="form-control-static">{{$egreso->egresosConcepto->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$egreso->detalle}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="forma_pago_name">FORMA PAGO</label>
                     <p class="form-control-static">{{$egreso->formaPago->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="cuentas_efectivo_name">CUENTA EFECTIVO</label>
                     <p class="form-control-static">{{$egreso->cuentasEfectivo->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$egreso->monto}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="empleado_nombre">RESPONSABLE</label>
                     <p class="form-control-static">{{$egreso->empleado->nombre}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$egreso->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$egreso->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('egresos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection