@extends('plantillas.admin_template')

@include('sepModalidadTitulacions._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepModalidadTitulacions.index') }}">@yield('sepModalidadTitulacionsAppTitle')</a></li>
    <li class="active">{{ $sepModalidadTitulacion->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepModalidadTitulacionsAppTitle') / Mostrar {{$sepModalidadTitulacion->id}}

            {!! Form::model($sepModalidadTitulacion, array('route' => array('sepModalidadTitulacions.destroy', $sepModalidadTitulacion->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepModalidadTitulacion.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepModalidadTitulacions.edit', $sepModalidadTitulacion->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepModalidadTitulacion.destroy')
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
                    <p class="form-control-static">{{$sepModalidadTitulacion->id}}</p>
                </div>
                <div class="form-group">
                     <label for="id_modalidad">ID_MODALIDAD</label>
                     <p class="form-control-static">{{$sepModalidadTitulacion->id_modalidad}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$sepModalidadTitulacion->descripcion}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepModalidadTitulacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection