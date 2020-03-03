@extends('plantillas.admin_template')

@include('hCalifPonderacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hCalifPonderacions.index') }}">@yield('hCalifPonderacionsAppTitle')</a></li>
    <li class="active">{{ $hCalifPonderacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hCalifPonderacionsAppTitle') / Mostrar {{$hCalifPonderacion->id}}

            {!! Form::model($hCalifPonderacion, array('route' => array('hCalifPonderacions.destroy', $hCalifPonderacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hCalifPonderacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hCalifPonderacions.edit', $hCalifPonderacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hCalifPonderacion.destroy')
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
                    <p class="form-control-static">{{$hCalifPonderacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="calificacion_ponderacion_id">CALIFICACION_PONDERACION_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->calificacion_ponderacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacion_id">CALIFICACION_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->calificacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="carga_pondercaion_id">CARGA_PONDERCAION_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->carga_pondercaion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacion_parcial">CALIFICACION_PARCIAL</label>
                     <p class="form-control-static">{{$hCalifPonderacion->calificacion_parcial}}</p>
                </div>
                    <div class="form-group">
                     <label for="calificacon_parcial_calculada">CALIFICACON_PARCIAL_CALCULADA</label>
                     <p class="form-control-static">{{$hCalifPonderacion->calificacon_parcial_calculada}}</p>
                </div>
                    <div class="form-group">
                     <label for="ponderacion">PONDERACION</label>
                     <p class="form-control-static">{{$hCalifPonderacion->ponderacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="tiene_detalle">TIENE_DETALLE</label>
                     <p class="form-control-static">{{$hCalifPonderacion->tiene_detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="padre_id">PADRE_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->padre_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hCalifPonderacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hCalifPonderacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection