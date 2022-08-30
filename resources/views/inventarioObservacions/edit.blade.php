@extends('plantillas.admin_template')

@include('inventarioObservacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('inventarioObservacions.index') }}">@yield('inventarioObservacionsAppTitle')</a></li>
	    <li><a href="{{ route('inventarioObservacions.show', $inventarioObservacion->id) }}">{{ $inventarioObservacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('inventarioObservacionsAppTitle') / Editar {{$inventarioObservacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($inventarioObservacion, array('route' => array('inventarioObservacions.update', $inventarioObservacion->id),'method' => 'post')) !!}

@include('inventarioObservacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('inventarioObservacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection