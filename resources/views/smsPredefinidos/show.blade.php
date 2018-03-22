@extends('plantillas.admin_template')

@include('smsPredefinidos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('smsPredefinidos.index') }}">@yield('smsPredefinidosAppTitle')</a></li>
    <li class="active">{{ $smsPredefinido->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('smsPredefinidosAppTitle') / Mostrar {{$smsPredefinido->id}}

            {!! Form::model($smsPredefinido, array('route' => array('smsPredefinidos.destroy', $smsPredefinido->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('smsPredefinido.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('smsPredefinidos.edit', $smsPredefinido->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('smsPredefinido.destroy')
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
                    <p class="form-control-static">{{$smsPredefinido->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">NOMBRE</label>
                     <p class="form-control-static">{{$smsPredefinido->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$smsPredefinido->detalle}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$smsPredefinido->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODDIFICACION</label>
                     <p class="form-control-static">{{$smsPredefinido->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('smsPredefinidos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection