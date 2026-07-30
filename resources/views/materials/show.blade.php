@extends('plantillas.admin_template')

@include('materials._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('materials.index') }}">@yield('materialsAppTitle')</a></li>
    <li class="active">{{ $material->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('materialsAppTitle') / Mostrar {{$material->id}}

            {!! Form::model($material, array('route' => array('materials.destroy', $material->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('material.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('materials.edit', $material->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('material.destroy')
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
                    <p class="form-control-static">{{$material->id}}</p>
                </div>
                <div class="form-group">
                     <label for="seccion_name">SECCION_NAME</label>
                     <p class="form-control-static">{{$material->seccion->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$material->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$material->archivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_disponibilidad">FECHA_DISPONIBILIDAD</label>
                     <p class="form-control-static">{{$material->fecha_disponibilidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$material->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$material->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('materials.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection