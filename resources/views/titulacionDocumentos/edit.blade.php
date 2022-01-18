@extends('plantillas.admin_template')

@include('titulacionDocumentos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('titulacionDocumentos.index') }}">@yield('titulacionDocumentosAppTitle')</a></li>
	    <li><a href="{{ route('titulacionDocumentos.show', $titulacionDocumento->id) }}">{{ $titulacionDocumento->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('titulacionDocumentosAppTitle') / Editar {{$titulacionDocumento->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($titulacionDocumento, array('route' => array('titulacionDocumentos.update', $titulacionDocumento->id),'method' => 'post')) !!}

@include('titulacionDocumentos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('titulacionDocumentos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection