@extends('plantillas.admin_template')

@include('titulacionDocumentacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('titulacionDocumentacions.index') }}">@yield('titulacionDocumentacionsAppTitle')</a></li>
    <li class="active">{{ $titulacionDocumentacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('titulacionDocumentacionsAppTitle') / Mostrar {{$titulacionDocumentacion->id}}

            {!! Form::model($titulacionDocumentacion, array('route' => array('titulacionDocumentacions.destroy', $titulacionDocumentacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('titulacionDocumentacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('titulacionDocumentacions.edit', $titulacionDocumentacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('titulacionDocumentacion.destroy')
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
                    <p class="form-control-static">{{$titulacionDocumentacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="titulacion_id">TITULACION_ID</label>
                     <p class="form-control-static">{{$titulacionDocumentacion->titulacion->id}}</p>
                </div>
                    <div class="form-group">
                     <label for="titulacion_documento_name">TITULACION_DOCUMENTO_NAME</label>
                     <p class="form-control-static">{{$titulacionDocumentacion->titulacionDocumento->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="archivo">ARCHIVO</label>
                     <p class="form-control-static">{{$titulacionDocumentacion->archivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$titulacionDocumentacion->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$titulacionDocumentacion->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('titulacionDocumentacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection