@extends('plantillas.admin_template')

@include('facturaGLineas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('facturaGLineas.index') }}">@yield('facturaGLineasAppTitle')</a></li>
    <li class="active">{{ $facturaGLinea->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('facturaGLineasAppTitle') / Mostrar {{$facturaGLinea->id}}

            {!! Form::model($facturaGLinea, array('route' => array('facturaGLineas.destroy', $facturaGLinea->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('facturaGLinea.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('facturaGLineas.edit', $facturaGLinea->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('facturaGLinea.destroy')
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
                    <p class="form-control-static">{{$facturaGLinea->id}}</p>
                </div>
                <div class="form-group">
                     <label for="factura_g_id">FACTURA_G_ID</label>
                     <p class="form-control-static">{{$facturaGLinea->facturaG->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_operacion">FECHA_OPERACION</label>
                     <p class="form-control-static">{{$facturaGLinea->fecha_operacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="concepto">CONCEPTO</label>
                     <p class="form-control-static">{{$facturaGLinea->concepto}}</p>
                </div>
                    <div class="form-group">
                     <label for="referencia">REFERENCIA</label>
                     <p class="form-control-static">{{$facturaGLinea->referencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="referencia_ampliada">REFERENCIA_AMPLIADA</label>
                     <p class="form-control-static">{{$facturaGLinea->referencia_ampliada}}</p>
                </div>
                    <div class="form-group">
                     <label for="cargo">CARGO</label>
                     <p class="form-control-static">{{$facturaGLinea->cargo}}</p>
                </div>
                    <div class="form-group">
                     <label for="abono">ABONO</label>
                     <p class="form-control-static">{{$facturaGLinea->abono}}</p>
                </div>
                    <div class="form-group">
                     <label for="saldo">SALDO</label>
                     <p class="form-control-static">{{$facturaGLinea->saldo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$facturaGLinea->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$facturaGLinea->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('facturaGLineas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection