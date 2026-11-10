@extends('plantillas.admin_template')

@include('devolucionesCajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('devolucionesCajas.index') }}">@yield('devolucionesCajasAppTitle')</a></li>
    <li class="active">{{ $devolucionesCaja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('devolucionesCajasAppTitle') / Mostrar {{$devolucionesCaja->id}}

            {!! Form::model($devolucionesCaja, array('route' => array('devolucionesCajas.destroy', $devolucionesCaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('devolucionesCaja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('devolucionesCajas.edit', $devolucionesCaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('devolucionesCaja.destroy')
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
                    <p class="form-control-static">{{$devolucionesCaja->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="caja_consecutivo">CONSECUTIVO</label>
                     <p class="form-control-static">{{$devolucionesCaja->caja->consecutivo}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantel_razon">RAZON</label>
                     <p class="form-control-static">{{$devolucionesCaja->plantel->razon}}</p>
                </div>
                
                    <div class="form-group col-sm-4">
                     <label for="cliente_nombre">CLIENTE</label>
                     <p class="form-control-static">{{$devolucionesCaja->cliente->nombre}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="caja_concepto_name">CONCEPTO</label>
                     <p class="form-control-static">{{$devolucionesCaja->cajaConcepto->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="grado_name">GRADO</label>
                     <p class="form-control-static">{{$devolucionesCaja->grado->name}}</p>
                </div>    
                    <div class="form-group col-sm-4">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$devolucionesCaja->monto}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="motivos_dev_caja_name">MOTIVO</label>
                     <p class="form-control-static">{{$devolucionesCaja->motivosDevCaja->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="vobo">VO.BO.</label>
                     <p class="form-control-static">{{$devolucionesCaja->vobo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="obs">OBS.</label>
                     <p class="form-control-static">{{$devolucionesCaja->obs}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$devolucionesCaja->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$devolucionesCaja->usu_mod->name}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ESTATUS</label>
                     <p class="form-control-static">{{$devolucionesCaja->stDevCaja->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('devolucionesCajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
            @permission('devolucionesCajas.aprobar')
            <a class="btn btn-success" href="{{ route('devolucionesCajas.aprobar', $devolucionesCaja->id) }}"><i class="fa fa-thumbs-up"></i>  Aprobar</a>
            @endpermission
            @permission('devolucionesCajas.rechazar')
            <a class="btn btn-danger" href="{{ route('devolucionesCajas.rechazar', $devolucionesCaja->id) }}"><i class="fa fa-thumbs-down"></i>  Rechazar</a>
            @endpermission
        </div>
    </div>

@endsection