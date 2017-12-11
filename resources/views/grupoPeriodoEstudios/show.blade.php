@extends('plantillas.admin_template')

@include('grupoPeriodoEstudios._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('grupoPeriodoEstudios.index') }}">@yield('grupoPeriodoEstudiosAppTitle')</a></li>
    <li class="active">{{ $grupoPeriodoEstudio->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('grupoPeriodoEstudiosAppTitle') / Mostrar {{$grupoPeriodoEstudio->id}}

            {!! Form::model($grupoPeriodoEstudio, array('route' => array('grupoPeriodoEstudios.destroy', $grupoPeriodoEstudio->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('grupoPeriodoEstudio.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('grupoPeriodoEstudios.edit', $grupoPeriodoEstudio->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('grupoPeriodoEstudio.destroy')
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
                    <p class="form-control-static">{{$grupoPeriodoEstudio->id}}</p>
                </div>
                <div class="form-group">
                     <label for="grupo_id">GRUPO_ID</label>
                     <p class="form-control-static">{{$grupoPeriodoEstudio->grupo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="periodo_estudio_id">PERIODO_ESTUDIO_ID</label>
                     <p class="form-control-static">{{$grupoPeriodoEstudio->periodo_estudio_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('grupoPeriodoEstudios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection