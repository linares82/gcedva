@extends('plantillas.admin_template')

@include('titulacionDocumentacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('titulacionDocumentacions.index') }}">@yield('titulacionDocumentacionsAppTitle')</a></li>
	    <li><a href="{{ route('titulacionDocumentacions.show', $titulacionDocumentacion->id) }}">{{ $titulacionDocumentacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('titulacionDocumentacionsAppTitle') / Editar {{$titulacionDocumentacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($titulacionDocumentacion, array('route' => array('titulacionDocumentacions.update', $titulacionDocumentacion->id),'method' => 'post')) !!}

@include('titulacionDocumentacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('titulacionDocumentacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection