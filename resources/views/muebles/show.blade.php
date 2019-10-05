@extends('plantillas.admin_template')

@include('muebles._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('muebles.index') }}">@yield('mueblesAppTitle')</a></li>
    <li class="active">{{ $mueble->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('mueblesAppTitle') / Mostrar {{$mueble->id}}

            {!! Form::model($mueble, array('route' => array('muebles.destroy', $mueble->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('mueble.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('muebles.edit', $mueble->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('mueble.destroy')
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
                    <p class="form-control-static">{{$mueble->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$mueble->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="articulo_name">ARTICULO_NAME</label>
                     <p class="form-control-static">{{$mueble->articulo->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_alta">FECHA_ALTA</label>
                     <p class="form-control-static">{{$mueble->fecha_alta}}</p>
                </div>
                    <div class="form-group">
                     <label for="ubicacion_art_ubicacion">UBICACION_ART_UBICACION</label>
                     <p class="form-control-static">{{$mueble->ubicacionArt->ubicacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="empleado_nombre">EMPLEADO_NOMBRE</label>
                     <p class="form-control-static">{{$mueble->empleado->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="marca">MARCA</label>
                     <p class="form-control-static">{{$mueble->marca}}</p>
                </div>
                    <div class="form-group">
                     <label for="modelo">MODELO</label>
                     <p class="form-control-static">{{$mueble->modelo}}</p>
                </div>
                    <div class="form-group">
                     <label for="no_serie">NO_SERIE</label>
                     <p class="form-control-static">{{$mueble->no_serie}}</p>
                </div>
                    <div class="form-group">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$mueble->observaciones}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_mueble_name">ST_MUEBLE_NAME</label>
                     <p class="form-control-static">{{$mueble->stMueble->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_mueble_uso_name">ST_MUEBLE_USO_NAME</label>
                     <p class="form-control-static">{{$mueble->stMuebleUso->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="no_inv">NO_INV</label>
                     <p class="form-control-static">{{$mueble->no_inv}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$mueble->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$mueble->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('muebles.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection