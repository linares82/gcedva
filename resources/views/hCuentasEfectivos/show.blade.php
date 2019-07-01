@extends('plantillas.admin_template')

@include('hCuentasEfectivos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hCuentasEfectivos.index') }}">@yield('hCuentasEfectivosAppTitle')</a></li>
    <li class="active">{{ $hCuentasEfectivo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hCuentasEfectivosAppTitle') / Mostrar {{$hCuentasEfectivo->id}}

            {!! Form::model($hCuentasEfectivo, array('route' => array('hCuentasEfectivos.destroy', $hCuentasEfectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hCuentasEfectivo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hCuentasEfectivos.edit', $hCuentasEfectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hCuentasEfectivo.destroy')
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
                    <p class="form-control-static">{{$hCuentasEfectivo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cuenta_efectivo_id">CUENTA_EFECTIVO_ID</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->cuenta_efectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="saldo_inicial">SALDO_INICIAL</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->saldo_inicial}}</p>
                </div>
                    <div class="form-group">
                     <label for="saldo_actualizado">SALDO_ACTUALIZADO</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->saldo_actualizado}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_saldo_inicial">FECHA_SALDO_INICIAL</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->fecha_saldo_inicial}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hCuentasEfectivo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hCuentasEfectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection