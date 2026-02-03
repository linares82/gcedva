@extends('plantillas.admin_template')

@include('leadHEstatuses._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('leadHEstatuses.index') }}">@yield('leadHEstatusesAppTitle')</a></li>
	    <li><a href="{{ route('leadHEstatuses.show', $leadHEstatus->id) }}">{{ $leadHEstatus->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('leadHEstatusesAppTitle') / Editar {{$leadHEstatus->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($leadHEstatus, array('route' => array('leadHEstatuses.update', $leadHEstatus->id),'method' => 'post')) !!}

@include('leadHEstatuses._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('leadHEstatuses.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection