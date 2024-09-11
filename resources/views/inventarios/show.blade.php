@extends('plantillas.admin_template')

@include('inventarios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('inventarios.index') }}">@yield('inventariosAppTitle')</a></li>
    <li class="active">{{ $inventario->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('inventariosAppTitle') / Mostrar {{$inventario->id}}

            {!! Form::model($inventario, array('route' => array('inventarios.destroy', $inventario->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('inventario.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('inventarios.edit', $inventario->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('inventario.destroy')
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
                    <p class="form-control-static">{{$inventario->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$inventario->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="area">AREA</label>
                     <p class="form-control-static">{{$inventario->area}}</p>
                </div>
                    <div class="form-group">
                     <label for="escuela">ESCUELA</label>
                     <p class="form-control-static">{{$inventario->escuela}}</p>
                </div>
                    <div class="form-group">
                     <label for="tipo_inventario">TIPO_INVENTARIO</label>
                     <p class="form-control-static">{{$inventario->tipo_inventario}}</p>
                </div>
                    <div class="form-group">
                     <label for="ubicacion">UBICACION</label>
                     <p class="form-control-static">{{$inventario->ubicacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="cantidad">CANTIDAD</label>
                     <p class="form-control-static">{{$inventario->cantidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$inventario->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="medida">MEDIDA</label>
                     <p class="form-control-static">{{$inventario->medida}}</p>
                </div>
                    <div class="form-group">
                     <label for="marca">MARCA</label>
                     <p class="form-control-static">{{$inventario->marca}}</p>
                </div>
                    <div class="form-group">
                     <label for="observaciones">OBSERVACIONES</label>
                     <p class="form-control-static">{{$inventario->observaciones}}</p>
                </div>
                    <div class="form-group">
                     <label for="existe_si">EXISTE_SI</label>
                     <p class="form-control-static">{{$inventario->existe_si}}</p>
                </div>
                    <div class="form-group">
                     <label for="existe_no">EXISTE_NO</label>
                     <p class="form-control-static">{{$inventario->existe_no}}</p>
                </div>
                    <div class="form-group">
                     <label for="estado_bueno">ESTADO_BUENO</label>
                     <p class="form-control-static">{{$inventario->estado_bueno}}</p>
                </div>
                    <div class="form-group">
                     <label for="estado_malo">ESTADO_MALO</label>
                     <p class="form-control-static">{{$inventario->estado_malo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$inventario->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$inventario->usu_mod_id}}</p>
                </div>
                </div>
                    
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('inventarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection