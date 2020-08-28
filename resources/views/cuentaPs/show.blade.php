@extends('plantillas.admin_template')

@include('cuentaPs._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cuentaPs.index') }}">@yield('cuentaPsAppTitle')</a></li>
    <li class="active">{{ $cuentaP->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cuentaPsAppTitle') / Mostrar {{$cuentaP->id}}

            {!! Form::model($cuentaP, array('route' => array('cuentaPs.destroy', $cuentaP->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cuentaP.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cuentaPs.edit', $cuentaP->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cuentaP.destroy')
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
                    <p class="form-control-static">{{$cuentaP->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">NOMBRE</label>
                     <p class="form-control-static">{{$cuentaP->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$cuentaP->clave}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$cuentaP->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICAION</label>
                     <p class="form-control-static">{{$cuentaP->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cuentaPs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection