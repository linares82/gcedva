@extends('plantillas.admin_template')

@include('cuentasEfectivoPlantels._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuentasEfectivoPlantels.index') }}">@yield('cuentasEfectivoPlantelsAppTitle')</a></li>
    <li class="active">{{ $cuentasEfectivoPlantel->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuentasEfectivoPlantelsAppTitle') / Mostrar {{$cuentasEfectivoPlantel->id}}

            {!! Form::model($cuentasEfectivoPlantel, array('route' => array('cuentasEfectivoPlantels.destroy', $cuentasEfectivoPlantel->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuentasEfectivoPlantel.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuentasEfectivoPlantels.edit', $cuentasEfectivoPlantel->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuentasEfectivoPlantel.destroy')
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
                    <p class="form-control-static">{{$cuentasEfectivoPlantel->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cuentas_efectivo_id">CUENTAS_EFECTIVO_ID</label>
                     <p class="form-control-static">{{$cuentasEfectivoPlantel->cuentas_efectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$cuentasEfectivoPlantel->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cuentasEfectivoPlantel->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cuentasEfectivoPlantel->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuentasEfectivoPlantels.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection