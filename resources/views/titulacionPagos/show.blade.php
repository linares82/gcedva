@extends('plantillas.admin_template')

@include('titulacionPagos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('titulacionPagos.index') }}">@yield('titulacionPagosAppTitle')</a></li>
    <li class="active">{{ $titulacionPago->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('titulacionPagosAppTitle') / Mostrar {{$titulacionPago->id}}

            {!! Form::model($titulacionPago, array('route' => array('titulacionPagos.destroy', $titulacionPago->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('titulacionPago.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('titulacionPagos.edit', $titulacionPago->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('titulacionPago.destroy')
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
                    <p class="form-control-static">{{$titulacionPago->id}}</p>
                </div>
                <div class="form-group">
                     <label for="titulacion_intento_id">TITULACION_INTENTO_ID</label>
                     <p class="form-control-static">{{$titulacionPago->titulacionIntento->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$titulacionPago->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="monto">MONTO</label>
                     <p class="form-control-static">{{$titulacionPago->monto}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$titulacionPago->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$titulacionPago->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('titulacionPagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection