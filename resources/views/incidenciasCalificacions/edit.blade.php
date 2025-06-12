@extends('plantillas.admin_template')

@include('incidenciasCalificacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('incidenciasCalificacions.index') }}">@yield('incidenciasCalificacionsAppTitle')</a></li>
	    <li><a href="{{ route('incidenciasCalificacions.show', $incidenciasCalificacion->id) }}">{{ $incidenciasCalificacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('incidenciasCalificacionsAppTitle') / Editar {{$incidenciasCalificacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($incidenciasCalificacion, array('route' => array('incidenciasCalificacions.update', $incidenciasCalificacion->id),'method' => 'post')) !!}

@include('incidenciasCalificacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('incidenciasCalificacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection