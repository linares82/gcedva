@extends('plantillas.admin_template')

@include('movimientos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('movimientos.index') }}">@yield('movimientosAppTitle')</a></li>
    <li class="active">{{ $movimiento->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('movimientosAppTitle') / Mostrar {{$movimiento->id}}

            {!! Form::model($movimiento, array('route' => array('movimientos.destroy', $movimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('movimiento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('movimientos.edit', $movimiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('movimiento.destroy')
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
                    <p class="form-control-static">{{$movimiento->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$movimiento->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="articulo_name">ARTICULO_NAME</label>
                     <p class="form-control-static">{{$movimiento->articulo->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="cantidad">CANTIDAD</label>
                     <p class="form-control-static">{{$movimiento->cantidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$movimiento->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="entrada_salida_name">ENTRADA_SALIDA_NAME</label>
                     <p class="form-control-static">{{$movimiento->entradaSalida->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$movimiento->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$movimiento->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('movimientos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection