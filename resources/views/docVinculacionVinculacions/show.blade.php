@extends('plantillas.admin_template')

@include('docVinculacionVinculacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('docVinculacionVinculacions.index') }}">@yield('docVinculacionVinculacionsAppTitle')</a></li>
    <li class="active">{{ $docVinculacionVinculacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('docVinculacionVinculacionsAppTitle') / Mostrar {{$docVinculacionVinculacion->id}}

            {!! Form::model($docVinculacionVinculacion, array('route' => array('docVinculacionVinculacions.destroy', $docVinculacionVinculacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('docVinculacionVinculacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('docVinculacionVinculacions.edit', $docVinculacionVinculacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('docVinculacionVinculacion.destroy')
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
                    <p class="form-control-static">{{$docVinculacionVinculacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="doc_vinculacion_name">DOC_VINCULACION_NAME</label>
                     <p class="form-control-static">{{$docVinculacionVinculacion->docVinculacion->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="vinculacion_lugar_practica">VINCULACION_LUGAR_PRACTICA</label>
                     <p class="form-control-static">{{$docVinculacionVinculacion->vinculacion->lugar_practica}}</p>
                </div>
                    <div class="form-group">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$docVinculacionVinculacion->archivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$docVinculacionVinculacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$docVinculacionVinculacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('docVinculacionVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection