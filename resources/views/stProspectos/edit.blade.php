@extends('plantillas.admin_template')

@include('stProspectos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stProspectos.index') }}">@yield('stProspectosAppTitle')</a></li>
	    <li><a href="{{ route('stProspectos.show', $stProspecto->id) }}">{{ $stProspecto->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stProspectosAppTitle') / Editar {{$stProspecto->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stProspecto, array('route' => array('stProspectos.update', $stProspecto->id),'method' => 'post')) !!}

@include('stProspectos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stProspectos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection