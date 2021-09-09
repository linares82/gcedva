@extends('plantillas.admin_template')

@include('hCambiosCajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('hCambiosCajas.index') }}">@yield('hCambiosCajasAppTitle')</a></li>
    <li class="active">{{ $hCambiosCaja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('hCambiosCajasAppTitle') / Mostrar {{$hCambiosCaja->id}}

            {!! Form::model($hCambiosCaja, array('route' => array('hCambiosCajas.destroy', $hCambiosCaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('hCambiosCaja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('hCambiosCajas.edit', $hCambiosCaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('hCambiosCaja.destroy')
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
                    <p class="form-control-static">{{$hCambiosCaja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="campo">CAMPO</label>
                     <p class="form-control-static">{{$hCambiosCaja->campo}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_anterior">VALOR_ANTERIOR</label>
                     <p class="form-control-static">{{$hCambiosCaja->valor_anterior}}</p>
                </div>
                    <div class="form-group">
                     <label for="valor_nuevo">VALOR_NUEVO</label>
                     <p class="form-control-static">{{$hCambiosCaja->valor_nuevo}}</p>
                </div>
                    <div class="form-group">
                     <label for="user_id">USER_ID</label>
                     <p class="form-control-static">{{$hCambiosCaja->user_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$hCambiosCaja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$hCambiosCaja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('hCambiosCajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection