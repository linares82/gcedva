@extends('plantillas.admin_template')

@include('stVinculacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('stVinculacions.index') }}">@yield('stVinculacionsAppTitle')</a></li>
    <li class="active">{{ $stVinculacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('stVinculacionsAppTitle') / Mostrar {{$stVinculacion->id}}

            {!! Form::model($stVinculacion, array('route' => array('stVinculacions.destroy', $stVinculacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('stVinculacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('stVinculacions.edit', $stVinculacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('stVinculacion.destroy')
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
                    <p class="form-control-static">{{$stVinculacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">ESTATUS</label>
                     <p class="form-control-static">{{$stVinculacion->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$stVinculacion->usu_alta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$stVinculacion->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('stVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection