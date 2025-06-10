@extends('plantillas.admin_template')

@include('sepCertObservacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepCertObservacions.index') }}">@yield('sepCertObservacionsAppTitle')</a></li>
    <li class="active">{{ $sepCertObservacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepCertObservacionsAppTitle') / Mostrar {{$sepCertObservacion->id}}

            {!! Form::model($sepCertObservacion, array('route' => array('sepCertObservacions.destroy', $sepCertObservacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepCertObservacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepCertObservacions.edit', $sepCertObservacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepCertObservacion.destroy')
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
                    <p class="form-control-static">{{$sepCertObservacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id_observacion">ID_OBSERVACION</label>
                     <p class="form-control-static">{{$sepCertObservacion->id_observacion}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$sepCertObservacion->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion_corta">DESCRIPCION_CORTA</label>
                     <p class="form-control-static">{{$sepCertObservacion->descripcion_corta}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepCertObservacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection