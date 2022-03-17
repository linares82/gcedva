@extends('plantillas.admin_template')

@include('empresasVinculacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('empresasVinculacions.index') }}">@yield('empresasVinculacionsAppTitle')</a></li>
    <li class="active">{{ $empresasVinculacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('empresasVinculacionsAppTitle') / Mostrar {{$empresasVinculacion->id}}

            {!! Form::model($empresasVinculacion, array('route' => array('empresasVinculacions.destroy', $empresasVinculacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('empresasVinculacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('empresasVinculacions.edit', $empresasVinculacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('empresasVinculacion.destroy')
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
                    <p class="form-control-static">{{$empresasVinculacion->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="razon_social">RAZON SOCIAL</label>
                     <p class="form-control-static">{{$empresasVinculacion->razon_social}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre_contacto">NOMBRE CONTACTO</label>
                     <p class="form-control-static">{{$empresasVinculacion->nombre_contacto}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_fijo">TEL. FIJO</label>
                     <p class="form-control-static">{{$empresasVinculacion->tel_fijo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="tel_cel">TEL. CEL.</label>
                     <p class="form-control-static">{{$empresasVinculacion->tel_cel}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="correo1">CORREO 1</label>
                     <p class="form-control-static">{{$empresasVinculacion->correo1}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="correo2">CORREO 2</label>
                     <p class="form-control-static">{{$empresasVinculacion->correo2}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="direccion">DIRECCION</label>
                     <p class="form-control-static">{{$empresasVinculacion->direccion}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">U. ALTA</label>
                     <p class="form-control-static">{{$empresasVinculacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$empresasVinculacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('empresasVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection