@extends('plantillas.admin_template')

@include('sepAutorizacionReconocimientos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepAutorizacionReconocimientos.index') }}">@yield('sepAutorizacionReconocimientosAppTitle')</a></li>
    <li class="active">{{ $sepAutorizacionReconocimiento->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepAutorizacionReconocimientosAppTitle') / Mostrar {{$sepAutorizacionReconocimiento->id}}

            {!! Form::model($sepAutorizacionReconocimiento, array('route' => array('sepAutorizacionReconocimientos.destroy', $sepAutorizacionReconocimiento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepAutorizacionReconocimiento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepAutorizacionReconocimientos.edit', $sepAutorizacionReconocimiento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepAutorizacionReconocimiento.destroy')
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
                    <p class="form-control-static">{{$sepAutorizacionReconocimiento->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id_autorizacion_reconocimiento">ID_AUTORIZACION_RECONOCIMIENTO</label>
                     <p class="form-control-static">{{$sepAutorizacionReconocimiento->id_autorizacion_reconocimiento}}</p>
                </div>
                    <div class="form-group">
                     <label for="autorizacion_reconocimiento">AUTORIZACION_RECONOCIMIENTO</label>
                     <p class="form-control-static">{{$sepAutorizacionReconocimiento->autorizacion_reconocimiento}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepAutorizacionReconocimientos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection