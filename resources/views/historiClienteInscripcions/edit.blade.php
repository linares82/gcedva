@extends('plantillas.admin_template')

@include('historiClienteInscripcions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('historiClienteInscripcions.index') }}">@yield('historiClienteInscripcionsAppTitle')</a></li>
	    <li><a href="{{ route('historiClienteInscripcions.show', $historiClienteInscripcion->id) }}">{{ $historiClienteInscripcion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('historiClienteInscripcionsAppTitle') / Editar {{$historiClienteInscripcion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($historiClienteInscripcion, array('route' => array('historiClienteInscripcions.update', $historiClienteInscripcion->id),'method' => 'post')) !!}

@include('historiClienteInscripcions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('historiClienteInscripcions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection