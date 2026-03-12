@extends('plantillas.admin_template')

@include('incidenciasJustificacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('incidenciasJustificacions.index') }}">@yield('incidenciasJustificacionsAppTitle')</a></li>
	    <li><a href="{{ route('incidenciasJustificacions.show', $incidenciasJustificacion->id) }}">{{ $incidenciasJustificacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('incidenciasJustificacionsAppTitle') / Editar {{$incidenciasJustificacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($incidenciasJustificacion, array('route' => array('incidenciasJustificacions.update', $incidenciasJustificacion->id),'method' => 'post')) !!}

@include('incidenciasJustificacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('incidenciasJustificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection