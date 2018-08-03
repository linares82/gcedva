@extends('plantillas.admin_template')

@include('pagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('pagos.index') }}">@yield('pagosAppTitle')</a></li>
    <li class="active">{{ $pago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('pagosAppTitle') / Mostrar {{$pago->id}}

            {!! Form::model($pago, array('route' => array('pagos.destroy', $pago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('pago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('pagos.edit', $pago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('pago.destroy')
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
                    <p class="form-control-static">{{$pago->id}}</p>
                </div>
                <div class="form-group">
                     <label for="caja_id">CAJA_ID</label>
                     <p class="form-control-static">{{$pago->caja->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$pago->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$pago->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="forma_pago_name">FORMA_PAGO_NAME</label>
                     <p class="form-control-static">{{$pago->formaPago->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="referencia">REFERENCIA</label>
                     <p class="form-control-static">{{$pago->referencia}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$pago->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$pago->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('pagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection