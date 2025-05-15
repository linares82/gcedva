@extends('plantillas.admin_template')

@include('sepObservacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepObservacions.index') }}">@yield('sepObservacionsAppTitle')</a></li>
	    <li><a href="{{ route('sepObservacions.show', $sepObservacion->id) }}">{{ $sepObservacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepObservacionsAppTitle') / Editar {{$sepObservacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepObservacion, array('route' => array('sepObservacions.update', $sepObservacion->id),'method' => 'post')) !!}

@include('sepObservacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepObservacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection