@extends('plantillas.admin_template')

@include('bsBajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('bsBajas.index') }}">@yield('bsBajasAppTitle')</a></li>
    <li class="active">{{ $bsBaja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('bsBajasAppTitle') / Mostrar {{$bsBaja->id}}

            {!! Form::model($bsBaja, array('route' => array('bsBajas.destroy', $bsBaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('bsBaja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('bsBajas.edit', $bsBaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('bsBaja.destroy')
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
                    <p class="form-control-static">{{$bsBaja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$bsBaja->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_baja">FECHA_BAJA</label>
                     <p class="form-control-static">{{$bsBaja->fecha_baja}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_baja">BND_BAJA</label>
                     <p class="form-control-static">{{$bsBaja->bnd_baja}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_reactivar">FECHA_REACTIVAR</label>
                     <p class="form-control-static">{{$bsBaja->fecha_reactivar}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_reactivar">BND_REACTIVAR</label>
                     <p class="form-control-static">{{$bsBaja->bnd_reactivar}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$bsBaja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$bsBaja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('bsBajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection