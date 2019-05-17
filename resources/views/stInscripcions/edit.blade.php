@extends('plantillas.admin_template')

@include('stInscripcions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stInscripcions.index') }}">@yield('stInscripcionsAppTitle')</a></li>
	    <li><a href="{{ route('stInscripcions.show', $stInscripcion->id) }}">{{ $stInscripcion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stInscripcionsAppTitle') / Editar {{$stInscripcion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stInscripcion, array('route' => array('stInscripcions.update', $stInscripcion->id),'method' => 'post')) !!}

@include('stInscripcions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stInscripcions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection