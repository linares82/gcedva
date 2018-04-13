@extends('plantillas.admin_template')

@include('cuentaContables._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuentaContables.index') }}">@yield('cuentaContablesAppTitle')</a></li>
    <li class="active">{{ $cuentaContable->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuentaContablesAppTitle') / Mostrar {{$cuentaContable->id}}

            {!! Form::model($cuentaContable, array('route' => array('cuentaContables.destroy', $cuentaContable->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuentaContable.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuentaContables.edit', $cuentaContable->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuentaContable.destroy')
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
                    <p class="form-control-static">{{$cuentaContable->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$cuentaContable->clave}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="name">CUENTA</label>
                     <p class="form-control-static">{{$cuentaContable->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$cuentaContable->activo}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cuentaContable->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODDIFICACION</label>
                     <p class="form-control-static">{{$cuentaContable->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuentaContables.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection