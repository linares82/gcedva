@extends('plantillas.admin_template')

@include('historiClienteInscripcions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('historiClienteInscripcions.index') }}">@yield('historiClienteInscripcionsAppTitle')</a></li>
    <li class="active">{{ $historiClienteInscripcion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('historiClienteInscripcionsAppTitle') / Mostrar {{$historiClienteInscripcion->id}}

            {!! Form::model($historiClienteInscripcion, array('route' => array('historiClienteInscripcions.destroy', $historiClienteInscripcion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('historiClienteInscripcion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('historiClienteInscripcions.edit', $historiClienteInscripcion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('historiClienteInscripcion.destroy')
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
                    <p class="form-control-static">{{$historiClienteInscripcion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="historia_cliente_id">HISTORIA_CLIENTE_ID</label>
                     <p class="form-control-static">{{$historiClienteInscripcion->historia_cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="inscripcion_id">INSCRIPCION_ID</label>
                     <p class="form-control-static">{{$historiClienteInscripcion->inscripcion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$historiClienteInscripcion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$historiClienteInscripcion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('historiClienteInscripcions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection