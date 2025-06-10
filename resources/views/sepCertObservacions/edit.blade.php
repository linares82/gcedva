@extends('plantillas.admin_template')

@include('sepCertObservacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepCertObservacions.index') }}">@yield('sepCertObservacionsAppTitle')</a></li>
	    <li><a href="{{ route('sepCertObservacions.show', $sepCertObservacion->id) }}">{{ $sepCertObservacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepCertObservacionsAppTitle') / Editar {{$sepCertObservacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepCertObservacion, array('route' => array('sepCertObservacions.update', $sepCertObservacion->id),'method' => 'post')) !!}

@include('sepCertObservacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepCertObservacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection